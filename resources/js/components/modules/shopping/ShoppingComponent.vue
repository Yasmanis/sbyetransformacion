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
            <q-btn-component
                label="toda mi informacion"
                class="full-width"
                :flat="false"
                :round="false"
                :color="Dark.isActive ? 'primary' : ''"
                square
            />
            <div class="text-right q-pa-xs q-gutter-xs">
                <basket-sale-component />
                <return-sale-component />
            </div>
        </q-card-section>
    </q-card>
</template>

<script setup>
import BtnShareComponent from "../../btn/BtnShareComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BasketSaleComponent from "./BasketSaleComponent.vue";
import ReturnSaleComponent from "./ReturnSaleComponent.vue";
import { Dark } from "quasar";
defineOptions({
    name: "ShoppingComponent",
});

const props = defineProps({});
</script>
