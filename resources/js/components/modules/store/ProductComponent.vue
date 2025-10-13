<template>
    <q-card flat bordered :id="`product-store-${product.id}`">
        <q-card-section class="q-pa-xs">
            <q-item>
                <q-item-section />
                <q-item-section avatar>
                    <btn-shoppin-car-component
                        tooltips="agregar a la cesta"
                        :disable="
                            products.map((p) => p.id).includes(product.id)
                        "
                        @click="updateProductsStorage(product)"
                    />
                </q-item-section>
                <q-item-section avatar style="min-width: 10px !important">
                    <btn-share-component />
                </q-item-section>
            </q-item>
            <q-img
                :src="`${$page.props.public_path}${
                    product.image_path?.substring(1) ?? 'images/logo/2.png'
                }`"
                :ratio="9 / 16"
                fit="fill"
            />
        </q-card-section>
        <q-card-section class="q-pa-md">
            <q-item-label lines="3" class="text-center text-bold">{{
                product.name
            }}</q-item-label>
        </q-card-section>
        <q-card-section class="q-pa-xs">
            <q-item-label>
                <span v-html="product.description"></span>
            </q-item-label>
        </q-card-section>
        <q-card-section class="q-pa-none">
            <product-information
                :product="product"
                @add-product="emits('add-product', product)"
            />
            <div class="column items-center">
                <q-btn-component
                    label="alguna duda? preguntanos"
                    class="full-width"
                    :round="false"
                    no-caps
                />
                <q-rating
                    v-model="product.valoration"
                    color="primary"
                    icon="star_border"
                    icon-selected="star"
                    readonly
                />
                <q-btn-component
                    label="novedad"
                    class="full-width"
                    :round="false"
                />
            </div>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { ref } from "vue";
import BtnShareComponent from "../../btn/BtnShareComponent.vue";
import BtnShoppinCarComponent from "../../btn/BtnShoppinCarComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import ProductInformation from "../shopping/ProductInformation.vue";
import { Dark } from "quasar";
import { products, updateProductsStorage } from "../../../services/shopping";
defineOptions({
    name: "ProductComponent",
});

const props = defineProps({
    product: Object,
});

const emits = defineEmits(["add-product"]);

const rating = ref(0);
</script>
