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
                                        nombre apellido apellido
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label> nif </q-item-label>
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
                                </q-item-section>
                            </q-item>
                        </q-list>
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
                            <q-item class="q-py-sm">
                                <q-item-section avatar>
                                    <checkbox-field :dense="false" />
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
                                        visa clasica credito abanca
                                    </q-item-label>
                                    <q-item-label>
                                        tarjeta de credito que termina en ••••
                                        1111
                                    </q-item-label>
                                    <q-item-label class="text-red">
                                        <q-icon
                                            name="mdi-alert-outline"
                                            size="md"
                                        />
                                        tu medio de pago ha expirado
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section avatar>
                                    <btn-delete-component />
                                </q-item-section>
                                <q-item-section avatar>
                                    <payment-method />
                                </q-item-section>
                            </q-item>
                            <q-item class="q-py-sm">
                                <q-item-section avatar>
                                    <checkbox-field :dense="false" />
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
                                        visa debito abanca
                                    </q-item-label>
                                    <q-item-label>
                                        tarjeta de debito que termina en ••••
                                        3004
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section avatar>
                                    <btn-delete-component />
                                </q-item-section>
                                <q-item-section avatar>
                                    <payment-method />
                                </q-item-section>
                            </q-item>
                            <q-item>
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
import { usePage } from "@inertiajs/vue3";
defineOptions({
    name: "SalesDatesComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});

const showDialog = ref(false);

const user = computed(() => {
    return usePage().props.auth.user;
});
</script>
