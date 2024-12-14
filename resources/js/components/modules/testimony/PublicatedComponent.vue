<template>
    <btn-public-component
        :public="object.publicated"
        @click="router.post(`/admin/testimony/publicated/${object.id}`)"
    />
</template>

<script setup>
import BtnPublicComponent from "../../btn/BtnPublicComponent.vue";
import { router } from "@inertiajs/vue3";
defineOptions({
    name: "PublicatedComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});
</script>
