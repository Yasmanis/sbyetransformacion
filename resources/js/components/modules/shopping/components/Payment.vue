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
                            style="padding: 0"
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
                                    :ratio="16 / 9"
                                    width="80px"
                                    fit="fill"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>
                                    {{ method.name }}
                                </q-item-label>
                                <q-item-label>
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
                        <q-item class="bg-primary text-white q-mt-md">
                            <q-item-section>
                                2. DIRECCION DE FACTURACION
                            </q-item-section>
                        </q-item>
                        <address-card :object="currentBillingInformation" />
                        <q-item style="padding: 0px 0px">
                            <q-item-section>
                                <checkbox-field
                                    name="change_address"
                                    label="direccion nueva para este envio"
                                />
                            </q-item-section>
                            <q-item-section avatar>
                                <btn-edit-component />
                            </q-item-section>
                        </q-item>
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
                            <q-item-section> pagos pendientes: </q-item-section>
                            <q-item-section avatar>
                                {{ pendingAmount }} €
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
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import AddressCard from "./AddressCard.vue";
import { Screen } from "quasar";
import {
    subtotalAmount,
    pendingAmount,
    paymentsMethods,
    currentPaymentMethod,
    billingsInformation,
    currentBillingInformation,
} from "../../../../services/shopping";

defineOptions({
    name: "Payment",
});

const methods = ref([]);

onBeforeMount(() => {
    paymentsMethods.value.forEach((m) => {
        methods.value.push({ ...m });
    });
    let predetermined = methods.value.find((m) => m.predetermined);
    if (
        currentPaymentMethod.value &&
        currentPaymentMethod.id !== predetermined.id
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
        currentBillingInformation.value = billingsInformation.value.find(
            (b) => b.id === n.billing_information_id
        );
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
