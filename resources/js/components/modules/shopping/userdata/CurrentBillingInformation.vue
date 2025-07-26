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
                    {{
                        currentBilling?.full_name ??
                        billingInformation?.full_name ??
                        "-"
                    }}
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{
                        currentBilling?.nif_cif ??
                        billingInformation?.nif_cif ??
                        "-"
                    }}
                </q-item-label>
            </q-item-section>
        </q-item>
        <q-item>
            <q-item-section>
                <q-item-label>
                    {{
                        currentBilling?.address ??
                        billingInformation?.address ??
                        "-"
                    }}
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
                    {{
                        currentBilling?.postal_code ??
                        billingInformation?.postal_code ??
                        "-"
                    }}
                    –
                    {{
                        currentBilling?.province ??
                        billingInformation?.province ??
                        "-"
                    }}
                    ({{
                        currentBilling?.country_str ??
                        billingInformation?.country_str ??
                        "-"
                    }})
                </q-item-label>
            </q-item-section>
            <q-item-section avatar>
                <list-billing-information
                    :current="billingInformation"
                    :predetermined="predetermined"
                    @change="onChangeBilling"
                />
            </q-item-section>
        </q-item>
    </q-list>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ListBillingInformation from "./ListBillingInformation.vue";

defineOptions({
    name: "CurrentBillingInformation",
});

const props = defineProps({
    current: { Number, default: 0 },
    predetermined: Boolean,
});

const emits = defineEmits(["change"]);

const currentBilling = ref(null);

const user = computed(() => {
    return usePage().props.auth.user;
});

const billingInformation = computed(() => {
    let billing = null;
    const billings = user.value.billings_information;
    if (billings.length > 0) {
        billing =
            props.current > 0
                ? billings.find((b) => b.id === props.current)
                : billings.find((b) => b.predetermined) ?? billings[0];
    }
    emits("change", billing);
    return billing;
});

const onChangeBilling = (b) => {
    emits("change", b);
    currentBilling.value = b;
};
</script>
