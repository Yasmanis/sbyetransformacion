<template>
    <q-item style="padding: 0">
        <q-item-section avatar top>
            <q-img
                :src="`${$page.props.public_path}${
                    product.image_path?.substring(1) ?? 'images/logo/2.png'
                }`"
                width="70px"
            />
        </q-item-section>
        <q-item-section>
            <q-item-label class="text-bold">
                {{ product.name }}
            </q-item-label>
            <q-item-label> precio: {{ product.final_price }} € </q-item-label>
        </q-item-section>
    </q-item>
</template>

<script setup>
defineOptions({
    name: "ProductsAbstract",
});

const props = defineProps({
    product: Object,
});
</script>
