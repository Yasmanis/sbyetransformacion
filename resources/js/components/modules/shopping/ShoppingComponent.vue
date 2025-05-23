<template>
    <q-card flat bordered>
        <q-card-section class="q-pa-xs">
            <div class="column items-end">
                <btn-share-component />
            </div>
            <q-img :src="`${$page.props.public_path}images/logo/2.png`" />
        </q-card-section>
        <q-card-section class="q-pa-md">
            <q-item-label lines="3" class="text-center text-bold"
                >el nivel intermedio dentro de la metodologia
                sbyetransformacion</q-item-label
            >
        </q-card-section>
        <q-card-section class="q-pa-none">
            <full-sale-information />
            <div class="text-right q-pa-xs q-gutter-xs">
                <basket-sale-component />
                <return-sale-component />
            </div>
        </q-card-section>
    </q-card>
</template>

<script setup>
import BtnShareComponent from "../../btn/BtnShareComponent.vue";
import FullSaleInformation from "./FullSaleInformation.vue";
import BasketSaleComponent from "./BasketSaleComponent.vue";
import ReturnSaleComponent from "./ReturnSaleComponent.vue";
defineOptions({
    name: "ShoppingComponent",
});

const props = defineProps({});
</script>
