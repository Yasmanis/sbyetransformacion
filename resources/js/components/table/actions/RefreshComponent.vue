<template>
    <q-btn-component class="btn-show-hide-columns" tooltips="actualizar"
        :icon="`img:${$page.props.public_path}images/icon/refresh.png`" @click="onRefresh" />
</template>

<script setup>
defineOptions({
    name: "RefreshComponent",
});

import QBtnComponent from "../../base/QBtnComponent.vue";

const emit = defineEmits(["refresh"]);

const onRefresh = () => {
    emit("refresh");
};
</script>
