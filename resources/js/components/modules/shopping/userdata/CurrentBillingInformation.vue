<template>
    <q-list dense>
        <q-item class="bg-green-11">
            <q-item-section>
                <q-item-label class="text-center text-bold">
                    DATOS FACTURACION
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{ user.full_name }}
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{ billingInformation?.nif_cif ?? "-" }}
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{ billingInformation?.address ?? "-" }}
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label> pueblo – ciudad </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{ billingInformation?.postal_code ?? "-" }}
                    –
                    {{ billingInformation?.province ?? "-" }}
                    ({{ billingInformation?.country_str ?? "-" }})
                </q-item-label>
            </q-item-section>
            <q-item-section avatar>
                <list-billing-information
                    :current="billingInformation"
                    @confirm="onBillingConfirm"
                />
            </q-item-section>
        </q-item>
    </q-list>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ListBillingInformation from "./ListBillingInformation.vue";

defineOptions({
    name: "CurrentBillingInformation",
});

const user = computed(() => {
    return usePage().props.auth.user;
});

const billingInformation = computed(() => {
    const billings = user.value.billings_information;
    if (billings.length > 0) {
        return billings.find((b) => b.predetermined) ?? billings[0];
    }
    return null;
});

const onBillingConfirm = (billing) => {
    user.value.billings_information.forEach((b) => {
        if (b.id === billing.id) {
            b.predetermined = true;
        } else {
            b.predetermined = false;
        }
    });
};
</script>
