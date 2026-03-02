<template>
    <q-tabs
        v-model="tab"
        dense
        align="left"
        no-caps
        :class="Dark.isActive ? '' : 'bg-white text-primary'"
    >
        <q-tab name="invoice" icon="credit_card" label="datos de facturacion" />
        <q-tab name="cash" icon="mdi-cash" label="metodos de pago" />
    </q-tabs>

    <q-separator />

    <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="invoice" class="no-padding">
            <list-billing-information />
        </q-tab-panel>
        <q-tab-panel name="cash" class="no-padding">
            <list-payment-method />
        </q-tab-panel>
    </q-tab-panels>
</template>

<script setup>
import { ref } from "vue";
import { Dark } from "quasar";
import ListBillingInformation from "./ListBillingInformation.vue";
import ListPaymentMethod from "./ListPaymentMethod.vue";

defineOptions({
    name: "InfoComponent",
});
const tab = ref("invoice");
</script>
