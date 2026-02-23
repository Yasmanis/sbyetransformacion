<template>
    <q-card flat bordered :id="`product-payment-${product.id}`" v-if="product">
        <q-card-section class="q-pa-xs">
            <q-list>
                <q-item>
                    <q-item-section />
                    <q-item-section avatar style="min-width: 10px !important">
                        <btn-share-component />
                    </q-item-section>
                </q-item>
                <q-item>
                    <q-item-section>
                        <q-img
                            :src="`${$page.props.public_path}${
                                product.image_path?.substring(1) ??
                                'images/logo/2.png'
                            }`"
                            :ratio="9 / 16"
                            fit="fill"
                        />
                    </q-item-section>
                </q-item>
                <q-item style="padding: 0">
                    <q-item-section>
                        <q-item-label lines="3" class="text-center text-bold">{{
                            product.name
                        }}</q-item-label>

                        <q-item-label style="padding: 0">
                            <product-information
                                :product="product"
                                @add-product="emits('add-product')"
                            />
                        </q-item-label>
                        <q-item-label>
                            <div class="text-right q-pa-xs q-gutter-xs">
                                <q-btn-component
                                    icon="mdi-basket-plus-outline"
                                    tooltips="volver a comprar"
                                    @click="emits('sales-again')"
                                />
                            </div>
                        </q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
    </q-card>

    <q-card flat bordered v-else>
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

import ProductInformation from "./ProductInformation.vue";
import BtnBasketComponent from "../../btn/BtnBasketComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
defineOptions({
    name: "CardProductComponent",
});

const props = defineProps({
    product: Object,
});

const emits = defineEmits(["sales-again"]);
</script>
