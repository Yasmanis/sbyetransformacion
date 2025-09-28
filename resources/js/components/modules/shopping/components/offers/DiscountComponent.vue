<template>
    <q-card class="offer-card" flat>
        <div class="discount-badge">
            <q-badge
                color="black"
                text-color="white"
                :label="`-${object.income} €`"
            />
        </div>

        <q-card-section class="q-pa-xs">
            <div
                class="text-body1 text-grey-8 q-mb-md"
                v-html="object.description"
            ></div>

            <!-- Precios -->
            <div class="row items-center q-mt-sm">
                <div class="text-h5 text-weight-bold text-black">
                    {{ product.price - object.income }} €
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
    </q-card>
</template>

<script setup>
import { computed } from "vue";

defineOptions({
    name: "DiscountComponent",
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
