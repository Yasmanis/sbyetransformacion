<template>
    <q-card flat class="offer-card">
        <q-card-section class="q-pa-xs">
            <div
                class="text-body1 text-grey-8 q-mb-md"
                v-html="object.description"
            ></div>

            <div class="row items-center q-mt-sm">
                <div class="text-h5 text-weight-bold text-black">
                    {{ object.price }} €
                </div>
                <div class="text-strike text-grey-6 q-ml-sm">
                    {{ product.price }} €
                </div>
            </div>
            <div class="row items-center text-grey-7">
                <div class="col">
                    <q-icon name="event" class="q-mr-xs" />
                    <span class="text-caption">{{ period }}</span>
                </div>

                <div class="col text-right">
                    <q-btn
                        color="black"
                        no-caps
                        :label="inCart ? 'en la cesta' : 'comprar'"
                        :icon="inCart ? 'check' : 'shopping_cart'"
                        :disable="
                            products.map((p) => p.id).includes(product.id)
                        "
                        @click="updateProductsStorage(product)"
                    />
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { computed, ref } from "vue";
import {
    products,
    updateProductsStorage,
} from "../../../../../services/shopping";

defineOptions({
    name: "OffersComponent",
});

const props = defineProps({
    object: Object,
    product: Object,
});

const period = computed(() => {
    const { start_at, end_at } = props.object;
    if (end_at) {
        return `hasta ${end_at}`;
    }
    return `desde ${start_at}`;
});

const inCart = computed(() => {
    return products.value.map((p) => p.id).includes(props.product.id);
});
</script>

<style lang="scss" scoped>
.offer-card {
    border-radius: 12px;
    overflow: hidden;

    .discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 1;

        .q-badge {
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
        }
    }

    .product-image {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
}
</style>
