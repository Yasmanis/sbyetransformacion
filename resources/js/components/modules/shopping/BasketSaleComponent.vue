<template>
    <q-btn-component
        :label="label"
        :round="false"
        :flat="false"
        padding="5px 10px"
        @click="showDialog = true"
        v-if="label"
    /><q-btn-component
        icon="mdi-basket-plus-outline"
        tooltips="volver a comprar"
        @click="showDialog = true"
        v-else
    />
    <q-dialog v-model="showDialog">
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-basket"
                title="MI CESTA (1 producto)"
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
                    >
                        <products />
                    </q-step>

                    <q-step
                        :name="2"
                        title="ENVIO"
                        icon="mdi-truck-fast-outline"
                        :done="step > 2"
                        :header-nav="step > 2"
                    >
                        <shipment />
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
                    @click="$refs.stepper.next()"
                    color="black"
                    :label="step === 4 ? 'guardar' : 'siguiente'"
                />
                <q-btn
                    v-if="step > 1"
                    flat
                    color="black"
                    @click="$refs.stepper.previous()"
                    label="anterior"
                    class="q-ml-sm"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import Shipment from "./components/Shipment.vue";
import Payment from "./components/Payment.vue";
import Confirmation from "./components/Confirmation.vue";
import Products from "./components/Products.vue";

defineOptions({
    name: "StepperPage",
});

const props = defineProps({
    label: String,
});

const showDialog = ref(false);
const step = ref(1);
</script>
