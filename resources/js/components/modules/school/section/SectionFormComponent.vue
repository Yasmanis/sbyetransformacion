<template>
    <text-field
        v-model="formData.name"
        label="nombre"
        name="name"
        :othersProps="{
            required: true,
        }"
        :modelValue="formData.name"
        @update="onUpdateField"
    />
    <checkbox-field
        label="añadir descripcion"
        name="add_description"
        :modelValue="addDescription"
        class="q-ml-none"
        @update="
            (name, val) => {
                addDescription = val;
                formData.description = null;
            }
        "
    />
    <editor-field
        v-model="formData.description"
        name="description"
        :rows="3"
        :modelValue="formData.description"
        :othersProps="{
            required: true,
        }"
        @update="onUpdateField"
        v-if="addDescription"
    />
</template>

<script setup>
import { computed, onBeforeMount, ref, watch } from "vue";
import TextField from "../../../form/input/TextField.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import EditorField from "../../../form/input/EditorField.vue";
import { useForm } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";
import { error, error500 } from "../../../../helpers/notifications";
import axios from "axios";

defineOptions({
    name: "SectionFormComponent",
});

const props = defineProps({
    object: Object,
    segment: {
        type: String,
        required: true,
    },
    save: {
        type: Boolean,
        default: false,
    },
});

const $q = useQuasar();

const emits = defineEmits(["store", "update", "error"]);

const formData = ref({
    name: null,
    description: null,
});

const addDescription = ref(false);

onBeforeMount(() => {
    formData.value = {
        name: props.object ? props.object.name : null,
        description: props.object ? props.object.description : null,
    };
    addDescription.value = formData.value.description ? true : false;
});

watch(
    () => props.save,
    (n, o) => {
        if (n) {
            if (props.object) update();
            else store();
        }
    }
);

const onUpdateField = (name, val) => {
    formData.value[name] = val;
};

const store = async () => {
    Loading.show({
        message: "adicionando seccion",
    });
    await axios
        .post(`/admin/${props.segment}`, formData.value)
        .then((response) => {
            emits("store", response.data.id);
        })
        .catch((err) => {
            if (err.response.data.errors) {
                error(
                    "ya existe una seccion con el nombre actual especificado"
                );
            } else {
                error500();
            }
            Loading.hide();
        });
};

const update = async () => {
    const send = useForm(formData.value);
    send.put(`/admin/life/${props.object.id}`, {
        onSuccess: () => {
            emits("update");
        },
        onError: () => {
            emits("error");
        },
    });
};
</script>
