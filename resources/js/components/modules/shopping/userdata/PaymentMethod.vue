<template>
    <btn-edit-component @click="showDialog = true" tooltips="editar" />

    <q-dialog
        v-model="showDialog"
        persistent
        @before-show="onBeforeShow"
        @hide="onHide"
    >
        <q-card style="width: 900px; max-width: 100vw">
            <dialog-header-component
                icon="mdi-credit-card-edit-outline"
                title="editar metodo de pago"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <div class="row">
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-sm"
                    >
                        <q-form ref="form" greedy>
                            <text-field
                                label="nombre"
                                name="name"
                                :model-value="formData.name"
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
                                :model-value="formData.defeat"
                                :othersProps="{
                                    required: true,
                                    type: 'monthyear',
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                            <checkbox-field
                                label="metodo de pago predeterminado"
                                name="predetermined"
                                class="q-mt-sm"
                                :model-value="formData.predetermined"
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
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-sm"
                    >
                        <current-billing-information
                            :current="object.billing_information_id"
                            @change="
                                (b) =>
                                    (formData.billing_information_id =
                                        b?.id ?? null)
                            "
                        />
                    </div>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../../../btn/BtnSaveComponent.vue";
import TextField from "../../../form/input/TextField.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import CurrentBillingInformation from "./CurrentBillingInformation.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Screen } from "quasar";

defineOptions({
    name: "PaymentMethod",
});

const props = defineProps({
    object: Object,
});

const showDialog = ref(false);
const form = ref(null);

const formData = useForm({
    name: null,
    defeat: null,
    predetermined: false,
    billing_information_id: null,
});

const billings_information = computed(() => {
    return usePage().props.auth.user.billings_information;
});

const onBeforeShow = () => {
    for (const key in props.object) {
        if (formData[key] !== undefined) {
            formData[key] = props.object[key];
        }
    }
};

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            update();
        } else {
            errorValidation();
        }
    });
};

const update = async () => {
    formData.put(`/admin/users/payment-methods/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};

const onHide = () => {
    formData.reset();
};
</script>
