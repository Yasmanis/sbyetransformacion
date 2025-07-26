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
            <q-item-label>contado</q-item-label>
            <q-item-label
                ><ul class="q-ma-none q-pl-md text-body2">
                    <li>
                        pago inicial
                        {{ product.total_to_car * product.first_payment }}
                        €
                    </li>
                    <li>
                        {{ product.total_payments }} pagos mensuales de
                        {{ amountPerPayment }}
                        €
                    </li>
                </ul></q-item-label
            >
            <q-item-label class="text-bold">
                {{ product.total_to_car * product.price }} €
            </q-item-label>
        </q-item-section>
    </q-item>
    <q-item style="padding: 0" class="q-mt-md">
        <q-item-section>
            <payments-table :product="product" />
        </q-item-section>
    </q-item>
</template>

<script setup>
import { ref } from "vue";
import PaymentsTable from "./PaymentsTable.vue";

defineOptions({
    name: "ProductsAbstract",
});

const props = defineProps({
    product: Object,
});
</script>
