<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs ? 'q-pr-xs' : ''"
        >
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense
                        ><q-item class="bg-primary text-white">
                            <q-item-section>
                                1. SELECCIONA EL METODO DE PAGO
                            </q-item-section>
                        </q-item>
                        <q-item
                            style="padding: 5px 0px"
                            v-for="(method, indexMethod) in methods"
                            :key="`method-${indexMethod}`"
                            clickable
                            @click="onChangeMethod(method)"
                        >
                            <q-item-section avatar>
                                <checkbox-field
                                    :dense="false"
                                    name="predetermined"
                                    :model-value="method.predetermined"
                                    @update="onChangeMethod(method)"
                                />
                            </q-item-section>
                            <q-item-section avatar>
                                <q-img
                                    :src="`${$page.props.public_path}images/logo/2.png`"
                                    width="80px"
                                    fit="fill"
                                    v-if="method.id !== 0"
                                />
                                <q-img
                                    :src="`${$page.props.public_path}images/others/paypal.png`"
                                    width="80px"
                                    fit="fill"
                                    v-else
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>
                                    {{ method.name }}
                                </q-item-label>
                                <q-item-label v-if="method.id !== 0">
                                    tarjeta de credito que termina en ••••
                                    {{ method.number.split(" ")[3] }}
                                </q-item-label>
                                <q-item-label
                                    class="text-red"
                                    v-if="method.expired"
                                >
                                    <q-icon
                                        name="mdi-alert-outline"
                                        size="md"
                                    />
                                    tu medio de pago ha expirado
                                </q-item-label>
                            </q-item-section>
                        </q-item>

                        <current-billing-information
                            text="2. DIRECCION DE FACTURACION"
                            bgClass="bg-primary q-mt-md"
                            textClass="text-white"
                            :current="currentBillingInformation"
                            @change="
                                (billing) => emits('change-billing', billing)
                            "
                        />
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
        <div
            class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
            :class="!Screen.xs ? 'q-pl-xs' : ''"
        >
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item class="bg-primary text-white">
                            <q-item-section> subtotal: </q-item-section>
                            <q-item-section avatar>
                                {{ subtotalAmount }} €
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section>
                                <q-item-label caption
                                    ><i
                                        >estas realizando una compra 100%
                                        segura</i
                                    ></q-item-label
                                >
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, ref, watch } from "vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import CurrentBillingInformation from "../userdata/CurrentBillingInformation.vue";
import { Screen } from "quasar";
import {
    subtotalAmount,
    paymentsMethods,
    currentPaymentMethod,
    billingsInformation,
    currentBillingInformation,
} from "../../../../services/shopping";

defineOptions({
    name: "Payment",
});

const emits = defineEmits(["change-billing"]);

const methods = ref([
    {
        id: 0,
        name: "PayPal",
        predetermined: true,
        number: "#### #### #### ####",
    },
]);

onBeforeMount(() => {
    paymentsMethods.value.forEach((m) => {
        methods.value.push({ ...m });
    });
    let predetermined = methods.value.find((m) => m.predetermined);
    if (
        currentPaymentMethod.value &&
        currentPaymentMethod.id !== predetermined?.id
    ) {
        predetermined.predetermined = false;
        predetermined = methods.value.find(
            (m) => m.id === currentPaymentMethod.value.id
        );
        predetermined.predetermined = true;
    } else {
        currentPaymentMethod.value = predetermined;
    }
});

watch(
    currentPaymentMethod,
    (n) => {
        currentBillingInformation.value = n
            ? billingsInformation.value.find(
                  (b) => b.id === n.billing_information_id
              )?.id ?? 0
            : 0;
    },
    {
        deep: true,
    }
);

const onChangeMethod = (m) => {
    m.predetermined = !m.predetermined;
    let current = methods.value.find((p) => p.predetermined && p.id != m.id);
    if (current) {
        current.predetermined = false;
    }
    currentPaymentMethod.value = m.predetermined ? m : null;
};
</script>
