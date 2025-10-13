<template>
    <q-btn-component
        :label="label"
        :round="false"
        :flat="false"
        :class="class"
        padding="5px 10px"
        @click="showDialog = true"
        v-if="label"
    /><q-btn-component
        icon="mdi-basket-plus-outline"
        tooltips="volver a comprar"
        :class="class"
        @click="showDialog = true"
        v-else
    />
    <q-dialog v-model="showDialog" @before-show="onBeforeShow">
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-basket"
                :title="`MI CESTA (${products.length} producto${
                    products.length > 1 ? 's' : ''
                })`"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 60vh" class="scroll">
                <q-stepper
                    flat
                    v-model="step"
                    header-nav
                    ref="stepper"
                    color="primary"
                    header-class="custom-stepper-header"
                    animated
                >
                    <q-step
                        :name="1"
                        title="MI CESTA"
                        icon="mdi-basket"
                        :done="step > 1"
                        :header-nav="step > 1"
                        style="padding: 5px"
                    >
                        <products
                            :object="products[0]"
                            v-if="products.length === 1"
                        />
                        <q-list dense separator v-else>
                            <q-expansion-item
                                v-for="(p, index) in products"
                                :key="`product-${p.id}`"
                                group="somegroup"
                                icon="shopping_cart_checkout"
                                :label="p.name"
                                :default-opened="index === 0"
                                header-class="text-primary"
                            >
                                <q-card>
                                    <q-card-section>
                                        <products :object="p" />
                                    </q-card-section>
                                </q-card>
                            </q-expansion-item>
                        </q-list>

                        <q-item>
                            <btn-delete-component
                                tooltips="vaciar cesta"
                                @click="
                                    () => {
                                        products = [];
                                        showDialog = false;
                                    }
                                "
                                v-if="products.length > 0"
                            />
                            <btn-shoppin-car-component
                                @click="showDialog = false"
                            />
                        </q-item>
                    </q-step>

                    <q-step
                        :name="3"
                        title="PAGO"
                        icon="mdi-currency-eur"
                        :done="step > 2"
                        :header-nav="step > 3"
                    >
                        <payment
                            @change-billing="
                                (billing) => (currentBilling = billing)
                            "
                        />
                    </q-step>

                    <q-step
                        :name="4"
                        title="CONFIRMACION"
                        icon="mdi-file-check-outline"
                        :header-nav="step > 4"
                    >
                        <confirmation
                            @accepted="(val) => (accepted = val)"
                            :billing-information="currentBilling"
                        />
                    </q-step>
                </q-stepper>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn
                    v-if="step > 1"
                    flat
                    color="black"
                    @click="stepper.previous()"
                    label="anterior"
                    class="q-ml-sm"
                />
                <q-btn
                    @click="createPayment"
                    color="black"
                    label="pagar"
                    v-if="step === 4"
                />
                <q-btn
                    @click="onStepChange"
                    color="black"
                    label="siguiente"
                    v-else
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import BtnShoppinCarComponent from "../../btn/BtnShoppinCarComponent.vue";
import Shipment from "./components/Shipment.vue";
import Payment from "./components/Payment.vue";
import Confirmation from "./components/Confirmation.vue";
import Products from "./components/Products.vue";
import {
    products,
    currentPaymentMethod,
    subtotalAmount,
} from "../../../services/shopping";
import { error } from "../../../helpers/notifications";
import { Loading } from "quasar";
import axios from "axios";

defineOptions({
    name: "StepperPage",
});

const props = defineProps({
    label: String,
    class: String,
    show: Boolean,
});

const showDialog = ref(false);
const step = ref(1);
const stepper = ref(null);
const accepted = ref(false);
const currentBilling = ref(null);

onMounted(() => {
    showDialog.value = props.show;
});

watch(
    () => props.show,
    (n) => {
        showDialog.value = n;
    }
);

const onStepChange = () => {
    if (step.value === 3) {
        if (!currentPaymentMethod.value) {
            error("debe seleccionar el metodo de pago");
            return;
        }
        //  else if (!currentBilling.value) {
        //     error("debe especificar la direccion de facturacion");
        //     return;
        // }
        else {
            stepper.value.next();
        }
    } else {
        stepper.value.next();
    }
};

const onBeforeShow = () => {
    step.value = 1;
    currentPaymentMethod.value = null;
    currentBilling.value = null;
};

const createPayment = async () => {
    if (!accepted.value) {
        error("debe aceptar los terminos legales de esta contratacion");
    } else {
        Loading.show();
        try {
            const response = await axios.post("/payments/store", {
                method: currentPaymentMethod.value,
                information: currentBilling.value,
                products: products.value,
                amount: subtotalAmount.value,
            });
            if (response.data.id) {
                const approveLink = response.data.links.find(
                    (link) => link.rel === "approve"
                );
                if (approveLink) {
                    window.location.href = approveLink.href;
                }
            }
        } catch (err) {
            error(
                `error al crear el pago: ${
                    err.response?.data?.message || err.message
                }`
            );
        } finally {
            Loading.hide();
        }
    }
};
</script>
<style>
.q-stepper__step-inner {
    padding: 10px 20px !important;
}
</style>
