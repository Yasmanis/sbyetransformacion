<template>
    <btn-edit-component @click="showDialog = true" tooltips="editar" />

    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 900px; max-width: 100vw">
            <dialog-header-component
                icon="mdi-credit-card-edit-outline"
                title="editar metodo de pago"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <q-form ref="form" greedy>
                            <text-field
                                label="nombre"
                                name="name"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                            <text-field
                                label="vencimiento"
                                name="defeat"
                                mask="##/####"
                                hint="formato ##/####"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                            <checkbox-field
                                label="metodo de pago predeterminado"
                                name="predetermined"
                                class="q-mt-sm"
                                @update="(name, val) => (formData[name] = val)"
                            />
                            <q-item
                                class="bg-green-11 q-mt-md"
                                style="padding: 5px"
                            >
                                <q-item-section avatar top>
                                    <q-icon name="mdi-information-outline" />
                                </q-item-section>
                                <q-item-section class="text-justify">
                                    podras ser redireccionado a la aplicación
                                    del banco para verificar este metodo de pago
                                </q-item-section>
                            </q-item>
                        </q-form>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <q-list
                            dense
                            :class="!Screen.xs && !Screen.sm ? 'q-ml-xl' : ''"
                        >
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
                                    <billing-information />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <btn-save-component />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../../../btn/BtnSaveComponent.vue";
import TextField from "../../../form/input/TextField.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import AddressSendSales from "./AddressSendSales.vue";
import BillingInformation from "./BillingInformation.vue";
import { useForm } from "@inertiajs/vue3";
import { Screen } from "quasar";

defineOptions({
    name: "PaymentMethod",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});

const showDialog = ref(false);
const form = ref(null);
const formData = useForm({
    name: null,
    number: null,
    defeat: null,
    predetermined: false,
});
</script>
