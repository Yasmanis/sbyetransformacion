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
</template>

<script setup>
import { onBeforeMount, ref, watch } from "vue";
import TextField from "../../form/input/TextField.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Loading } from "quasar";
import { error, error500 } from "../../../helpers/notifications.js";
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
        category: usePage().props?.category?.id || null,
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
    },
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
                    "ya existe una seccion con el nombre actual especificado",
                );
                emits("error");
            } else {
                error500();
            }
            Loading.hide();
        });
};

const update = async () => {
    const send = useForm(formData.value);
    send.put(`/admin/school/${props.object.id}`, {
        onSuccess: () => {
            emits("update");
        },
        onError: () => {
            emits("error");
        },
    });
};
</script>
