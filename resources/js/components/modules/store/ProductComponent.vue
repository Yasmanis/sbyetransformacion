<template>
    <q-card flat bordered :id="`product-store-${product.id}`">
        <q-card-section class="q-pa-xs">
            <q-list>
                <q-item>
                    <q-item-section />
                    <q-item-section avatar>
                        <btn-shoppin-car-component
                            tooltips="agregar a la cesta"
                            icon="mdi-cart-plus"
                            @click="addProductToStorage(product)"
                            v-if="getProductFromStorage(product) === null"
                        />
                        <btn-shoppin-car-component
                            tooltips="quitar de la cesta"
                            icon="mdi-cart-minus"
                            @click="removeProductFromStorage(product)"
                            v-else
                        />
                    </q-item-section>
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
                        <q-item-label
                            class="q-pt-md"
                            v-if="product.description"
                        >
                            <span v-html="product.description"></span>
                        </q-item-label>
                        <q-item-label>
                            <product-information
                                :product="product"
                                @add-product="emits('add-product', product)"
                            />
                        </q-item-label>
                        <q-item-label>
                            <div class="column items-center">
                                <help-question :product="product" />
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
                        </q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { ref } from "vue";
import BtnShareComponent from "../../btn/BtnShareComponent.vue";
import BtnShoppinCarComponent from "../../btn/BtnShoppinCarComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import ProductInformation from "../shopping/ProductInformation.vue";
import HelpQuestion from "./HelpQuestion.vue";
import {
    addProductToStorage,
    getProductFromStorage,
    products,
    removeProductFromStorage,
} from "../../../services/shopping";
defineOptions({
    name: "ProductComponent",
});

const props = defineProps({
    product: Object,
});

const emits = defineEmits(["add-product"]);

const rating = ref(0);
</script>
