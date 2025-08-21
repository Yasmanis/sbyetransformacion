<template>
    <q-card class="offer-card q-ma-md" bordered>
        <div class="discount-badge">
            <q-badge
                color="black"
                text-color="white"
                :label="`${object.price}  €`"
            />
        </div>

        <q-card-section>
            <div
                class="text-body1 text-grey-8 q-mb-md"
                v-html="object.description"
            ></div>

            <!-- Precios -->
            <div class="row items-center q-mt-sm">
                <div class="text-h5 text-weight-bold text-black">
                    {{ object.price }} €
                </div>
                <div class="text-strike text-grey-6 q-ml-sm">
                    {{ product.price }} €
                </div>
            </div>
            <div class="row items-center text-grey-7">
                <q-icon name="event" class="q-mr-xs" />
                <span class="text-caption">{{ period }}</span>
            </div>
        </q-card-section>

        <q-card-actions align="between" class="q-pa-md">
            <q-btn flat round color="grey-8" icon="favorite_border" />
            <q-btn
                color="black"
                no-caps
                :label="inCart ? 'en carrito' : 'agregar'"
                :icon="inCart ? 'check' : 'shopping_cart'"
                @click="inCart = !inCart"
            />
        </q-card-actions>
    </q-card>
</template>

<script setup>
import { computed, ref } from "vue";

defineOptions({
    name: "OffersComponent",
});

const props = defineProps({
    object: Object,
    product: Object,
});

const inCart = ref(false);

const period = computed(() => {
    const { start_at, end_at } = props.object;
    if (end_at) {
        return `hasta ${end_at}`;
    }
    return `desde ${start_at}`;
});
</script>

<style lang="scss" scoped>
.offer-card {
    width: 100%;
    max-width: 300px;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

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

    .q-card__section {
        padding: 16px;
    }

    .q-card__actions {
        padding-top: 0;
    }
}
</style>
