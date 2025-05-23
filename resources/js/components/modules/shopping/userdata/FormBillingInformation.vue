<template>
    <btn-add-component @click="showDialog = true" tooltips="adicionar" />

    <q-dialog v-model="showDialog" persistent @hide="onHide">
        <q-card style="width: 900px; max-width: 100vw">
            <dialog-header-component
                icon="mdi-card-account-details-outline"
                title="añadir datos de facturacion"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-form ref="form" greedy>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : null"
                        >
                            <text-field
                                name="name"
                                label="nombre"
                                :model-value="user.name"
                                disable
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-px-sm' : null"
                        >
                            <text-field
                                name="surname"
                                label="apellidos"
                                :model-value="user.surname"
                                disable
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-pl-sm' : null"
                        >
                            <text-field
                                name="nif_cif"
                                label="nif/cif"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : null"
                        >
                            <text-field
                                name="road"
                                label="tipo via"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-xl-8"
                            :class="!Screen.xs && !Screen.sm ? 'q-pl-sm' : null"
                        >
                            <text-field
                                name="address"
                                label="direccion"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : null"
                        >
                            <select-field
                                name="country_id"
                                label="pais"
                                :othersProps="{
                                    required: true,
                                    url_to_options: '/countries',
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-px-sm' : null"
                        >
                            <text-field
                                name="province"
                                label="provincia"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-4 col-md-4 col-xl-4"
                            :class="!Screen.xs && !Screen.sm ? 'q-pl-sm' : null"
                        >
                            <text-field
                                name="postal_code"
                                label="cp"
                                :othersProps="{
                                    required: true,
                                }"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <checkbox-field
                                label="establecer como predeterminado"
                                name="predetermined"
                                class="q-mt-sm"
                                :model-value="formData.predetermined"
                                @update="(name, val) => (formData[name] = val)"
                            />
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component @click="save" />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnConfirmComponent from "../../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnAddComponent from "../../../btn/BtnAddComponent.vue";
import SelectField from "../../../form/input/SelectField.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import TextField from "../../../form/input/TextField.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Screen } from "quasar";
import { errorValidation } from "../../../../helpers/notifications";

defineOptions({
    name: "FormBillingInformation",
});

const props = defineProps({
    object: Object,
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["created"]);

const showDialog = ref(false);
const form = ref(null);
const formData = useForm({
    name: null,
    surname: null,
    nif_cif: null,
    road: null,
    address: null,
    postal_code: null,
    province: null,
    country_id: null,
    predetermined: false,
});

const user = computed(() => {
    return usePage().props.auth.user;
});

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            if (props.object) {
                update();
            } else {
                store();
            }
        } else {
            errorValidation();
        }
    });
};

const store = async () => {
    formData.post("/admin/users/billing-information", {
        onSuccess: (d) => {
            emits("created", d.props.object);
            showDialog.value = false;
        },
    });
};

const update = async () => {
    formData.put(`/admin/users/billing-information/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};

const onHide = () => {
    formData.reset();
};
</script>
