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
                        :name="2"
                        title="ENVIO"
                        icon="mdi-truck-fast-outline"
                        :done="step > 2"
                        :header-nav="step > 2"
                    >
                        <shipment :products="products" />
                    </q-step>

                    <q-step
                        :name="3"
                        title="PAGO"
                        icon="mdi-currency-eur"
                        :done="step > 2"
                        :header-nav="step > 3"
                    >
                        <payment />
                    </q-step>

                    <q-step
                        :name="4"
                        title="CONFIRMACION"
                        icon="mdi-file-check-outline"
                        :header-nav="step > 4"
                    >
                        <confirmation />
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
                    @click="onStepChange"
                    color="black"
                    :label="step === 4 ? 'guardar' : 'siguiente'"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
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
    currentBillingInformation,
} from "../../../services/shopping";
import { error } from "../../../helpers/notifications";

defineOptions({
    name: "StepperPage",
});

const props = defineProps({
    label: String,
    class: String,
});

const showDialog = ref(false);
const step = ref(1);
const stepper = ref(null);

const onStepChange = () => {
    if (step.value === 2) {
        return;
    }
    if (step.value === 3 && !currentPaymentMethod.value) {
        error("debe seleccionar el metodo de pago");
        return;
    } else {
        stepper.value.next();
    }
};

const onBeforeShow = () => {
    step.value = 1;
    currentPaymentMethod.value = null;
    currentBillingInformation.value = null;
};
</script>
<style>
.q-stepper__step-inner {
    padding: 10px 20px !important;
}
</style>
