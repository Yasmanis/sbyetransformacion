<template>
    <btn-public-component :public="object.active" @click="save" />
</template>

<script setup>
import BtnPublicComponent from "../../btn/BtnPublicComponent.vue";
import axios from "axios";
import { error, success } from "../../../helpers/notifications";
import { Loading } from "quasar";
defineOptions({
    name: "ActiveComponent",
});

const props = defineProps({
    object: Object,
    baseUrl: String,
});

const emits = defineEmits(["save"]);

const save = () => {
    Loading.show();
    axios
        .post(`${props.baseUrl}/active/${props.object.id}`)
        .then((response) => {
            emits("save");
            success(response.data.message);
        })
        .catch(() => {
            error("ha ocurrido un error al procesar la solicitud");
        })
        .finally(() => {
            Loading.hide();
        });
};
</script>
