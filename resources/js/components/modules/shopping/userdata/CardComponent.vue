<template>
    <btn-add-component
        @click="showDialog = true"
        tooltips="añadir una nueva tarjeta"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        @hide="showDialogConfirm = false"
        @before-show="checkBillingInformation"
    >
        <q-card>
            <dialog-header-component
                icon="mdi-credit-card-plus-outline"
                title="nueva tarjeta"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-form ref="form" greedy class="q-gutter-sm">
                    <text-field
                        label="nombre"
                        name="name"
                        :othersProps="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <text-field
                        label="numero"
                        name="number"
                        mask="#### #### #### ####"
                        hint="formato #### #### #### ####"
                        :othersProps="{
                            required: true,
                            type: 'creditcard',
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
                            type: 'monthyear',
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="showDialogConfirm" persistent>
        <q-card style="width: 900px; max-width: 100vw">
            <dialog-header-component
                icon="mdi-credit-card-plus-outline"
                title="nueva tarjeta"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <current-billing-information
                            @change="onChangeBilling"
                        />
                        <q-list dense>
                            <q-item style="padding: 0">
                                <checkbox-field
                                    label="metodo de pago predeterminado"
                                    name="predetermined"
                                    :dense="false"
                                    @update="
                                        (name, val) => (formData[name] = val)
                                    "
                                />
                            </q-item>
                            <q-item
                                class="bg-green-11 q-ml-sm"
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
                        </q-list>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <q-list
                            dense
                            :class="
                                Screen.xs || Screen.sm ? 'q-mt-md' : 'q-ml-md'
                            "
                        >
                            <q-item style="padding: 0">
                                <q-item-section>
                                    <q-card class="bg-grey-4">
                                        <q-item-section class="q-pa-md">
                                            <div class="row">
                                                <div class="col">
                                                    <q-icon
                                                        name="mdi-integrated-circuit-chip"
                                                        size="lg"
                                                    />
                                                </div>
                                                <div
                                                    class="col self-center text-right q-pr-lg"
                                                >
                                                    <q-icon
                                                        name="mdi-wifi rotate-90"
                                                        size="sm"
                                                    />
                                                </div>
                                            </div>
                                            <q-item-label class="q-mt-md">
                                                tarjeta de debito ****
                                                {{
                                                    formData.number.split(
                                                        " "
                                                    )[3]
                                                }}
                                            </q-item-label>
                                            <q-item-label>{{
                                                currentBilling?.full_name ?? "-"
                                            }}</q-item-label>
                                        </q-item-section>
                                    </q-card>
                                </q-item-section>
                            </q-item>
                            <q-item
                                class="bg-green-11 q-mt-md"
                                style="padding: 5px"
                            >
                                <q-item-section avatar top>
                                    <q-icon name="mdi-information-outline" />
                                </q-item-section>
                                <q-item-section class="text-justify">
                                    nos vamos a poner en contacto con el banco
                                    para obtener la imagen de tu tarjeta
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component @click="store" />
                <btn-cancel-component
                    cancel
                    @click="showDialogConfirm = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnAddComponent from "../../../btn/BtnAddComponent.vue";
import TextField from "../../../form/input/TextField.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import BtnSaveComponent from "../../../btn/BtnSaveComponent.vue";
import BtnConfirmComponent from "../../../btn/BtnConfirmComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Screen } from "quasar";
import { errorValidation, info } from "../../../../helpers/notifications";

import CurrentBillingInformation from "./CurrentBillingInformation.vue";

defineOptions({
    name: "CardComponent",
});

const props = defineProps({
    object: Object,
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);
const showDialogConfirm = ref(false);
const currentBilling = ref(null);

const form = ref(null);
const formData = useForm({
    name: null,
    number: null,
    defeat: null,
    predetermined: false,
    billing_information_id: null,
});

const user = computed(() => {
    return usePage().props.auth.user;
});

const onChangeBilling = (billing) => {
    currentBilling.value = billing;
    formData.billing_information_id = billing?.id ?? null;
};

const checkBillingInformation = () => {
    if (user.value.billings_information.length === 0) {
        showDialog.value = false;
        info(
            "no se puede agregar un metodo de pago sin tener datos de facturacion"
        );
    }
};

const setDefaultData = () => {
    formData.reset();
    form.value.resetValidation();
};

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            showDialogConfirm.value = true;
        } else {
            errorValidation();
        }
    });
};

const store = async () => {
    if (formData.billing_information_id) {
        formData.post("/admin/users/payment-methods", {
            onSuccess: () => {
                setDefaultData();
                showDialog.value = false;
            },
            onError: () => {
                showDialogConfirm.value = false;
            },
        });
    } else {
        info("debe especificar los datos de facturación");
    }
};
</script>
