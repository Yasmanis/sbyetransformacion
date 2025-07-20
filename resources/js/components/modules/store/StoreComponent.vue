<template>
    <div class="row q-mb-md">
        <div
            class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12"
            v-for="(item, index) in products"
            :key="`item-${index}`"
        >
            <product-component
                :product="item"
                class="q-ma-xs"
                @add-product="(p) => emits('add-product', p)"
            />
        </div>
    </div>
</template>

<script setup>
import ProductComponent from "./ProductComponent.vue";

defineOptions({
    name: "StoreComponent",
});

const emits = defineEmits(["add-product"]);

const props = defineProps({
    products: {
        type: Array,
        default: [],
    },
});
</script>
