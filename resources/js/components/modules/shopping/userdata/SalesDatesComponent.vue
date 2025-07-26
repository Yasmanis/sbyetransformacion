<template>
    <btn-edit-component
        @click="showDialog = true"
        tooltips="editar datos de la compra"
    />

    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-card-account-details-outline"
                title="mis datos de compra"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div
                        class="col-xs-12 col-sm-6 col-lg-6 col-md-6 col-xl-6 q-pa-sm"
                    >
                        <q-list dense>
                            <q-item class="bg-green-11">
                                <q-item-section>
                                    <q-item-label class="text-center text-bold">
                                        DIRECCION DE ENVIO
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label>
                                        nombre apellido apellido
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label>
                                        direccion completa
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label>
                                        pueblo – ciudad
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label>
                                        cp –provincia (pais)
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section avatar>
                                    <address-send-sales />
                                </q-item-section> </q-item
                        ></q-list>
                    </div>
                    <div
                        class="col-xs-12 col-sm-6 col-lg-6 col-md-6 col-xl-6 q-pa-sm"
                    >
                        <current-billing-information :predetermined="true" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <q-list dense>
                            <q-item class="bg-green-11">
                                <q-item-section>
                                    <q-item-label class="text-center text-bold">
                                        METODOS DE PAGO
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item
                                class="q-py-sm"
                                v-for="(method, indexMethod) in paymentsMethods"
                                :key="`method-${indexMethod}`"
                            >
                                <q-item-section avatar>
                                    <checkbox-field
                                        :dense="false"
                                        name="predetermined"
                                        :model-value="method.predetermined"
                                        disable
                                    />
                                </q-item-section>
                                <q-item-section avatar>
                                    <q-img
                                        :src="`${$page.props.public_path}images/logo/2.png`"
                                        :ratio="16 / 9"
                                        width="200px"
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
                                <q-item-section avatar>
                                    <btn-delete-component
                                        @click="
                                            () => {
                                                currentPaymentMethod = method;
                                                showConfirm = true;
                                            }
                                        "
                                    />
                                </q-item-section>
                                <q-item-section avatar>
                                    <payment-method :object="method" />
                                </q-item-section>
                            </q-item>
                            <q-item
                                :class="
                                    paymentsMethods.length === 0
                                        ? 'q-mt-sm no-padding'
                                        : null
                                "
                            >
                                <q-item-section avatar>
                                    <card-component />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <confirm-component
        :show="showConfirm"
        cancel
        @hide="showConfirm = false"
        @ok="destroyPaymentMethod"
    />
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import AddressSendSales from "./AddressSendSales.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import CardComponent from "./CardComponent.vue";
import PaymentMethod from "./PaymentMethod.vue";
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import CurrentBillingInformation from "./CurrentBillingInformation.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { paymentsMethods } from "../../../../services/shopping";
defineOptions({
    name: "SalesDatesComponent",
});

const props = defineProps({
    object: Object,
});

const showDialog = ref(false);
const showConfirm = ref(false);
const currentPaymentMethod = ref(null);

const destroyPaymentMethod = () => {
    const send = useForm({});
    send.delete(
        `/admin/users/payment-methods/${currentPaymentMethod.value.id}`,
        {
            onSuccess: () => {
                showConfirm.value = false;
            },
        }
    );
};
</script>
