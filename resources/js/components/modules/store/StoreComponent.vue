<template>
    <div class="row">
        <div
            class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12"
            v-for="(item, index) in items"
            :key="`item-${index}`"
        >
            <product-component :product="item" class="q-ma-xs" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ProductComponent from "./ProductComponent.vue";

defineOptions({
    name: "StoreComponent",
});

const props = defineProps({});

const items = [
    { name: "el nivel mas largo dentro de la metodologia sbyetransformacion" },
    { name: "el nivel intermedio dentro de la metodologia sbyetransformacion" },
    { name: "el nivel mas rapido dentro de la metodologia sbyetransformacion" },
];
</script>
