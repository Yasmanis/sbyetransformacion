<template>
    <select-field
        name="campaign_id"
        label="campaña"
        :modelValue="model"
        :options="currentOptions"
        :othersProps="{
            url_to_options: '/selects/campaigns',
            required: true,
        }"
        :newObject="newCampaign"
        @update="onUpdateCampaign"
    >
        <!-- <template v-slot:after>
            <form-component
                :defaultIcon="`img:${$page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-campaign.png`"
                defaultTooltips="crear campaña"
                @created="onCreated"
            />
        </template> -->
    </select-field>
    <select-field
        name="sections_id"
        label="secciones"
        :modelValue="campaignSections"
        :multiple="true"
        :othersProps="{
            url_to_options: '/category-nomenclatures/section',
            required: true,
        }"
        @update="(name, value, full) => emits('update', name, value, full)"
    />
</template>

<script setup>
import { ref, onMounted } from "vue";
import FormComponent from "../../modules/campaign/FormComponent.vue";
import SelectField from "./SelectField.vue";
import { Dark } from "quasar";

defineOptions({
    name: "SelectField",
});

const props = defineProps({
    campaign: Number,
    sections: Array,
    name: {
        type: String,
    },
    label: {
        type: String,
    },
});

const emits = defineEmits(["update", "error"]);

const model = ref(null);
const newCampaign = ref(null);
const currentOptions = ref([]);
const campaignSections = ref(null);

onMounted(() => {
    model.value = props.campaign;
    campaignSections.value = props.sections;
});

const onUpdateCampaign = (name, value, object) => {
    campaignSections.value = object.sections_id;
    emits("update", name, value, object);
    emits("update", "sections_id", object.sections_id);
};

const onCreated = (object) => {
    let opt = {
        label: object.title,
        value: object.id,
        sections_id: object.sections_id,
    };
    newCampaign.value = opt;
    campaignSections.value = object.sections_id;
    emits("update", "campaign_id", object.id);
    emits("update", "sections_id", object.sections_id);
};
</script>
