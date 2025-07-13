<template>
    <q-card flat bordered>
        <q-card-section class="q-pa-xs">
            <div class="column items-end">
                <btn-share-component />
            </div>
            <q-img :src="`${$page.props.public_path}images/logo/2.png`" />
        </q-card-section>
        <q-card-section class="q-pa-md">
            <q-item-label lines="3" class="text-center text-bold">{{
                product.name
            }}</q-item-label>
        </q-card-section>
        <q-card-section class="q-pa-none">
            <product-information :product="product" />
            <div class="column items-center">
                <q-btn-component
                    label="alguna duda? preguntanos"
                    class="full-width"
                    :round="false"
                    no-caps
                />
                <q-rating
                    v-model="rating"
                    color="primary"
                    icon="star_border"
                    icon-selected="star"
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
import QBtnComponent from "../../base/QBtnComponent.vue";
import ProductInformation from "../shopping/ProductInformation.vue";
import { Dark } from "quasar";
defineOptions({
    name: "ProductComponent",
});

const props = defineProps({
    product: Object,
});

const rating = ref(0);
</script>
