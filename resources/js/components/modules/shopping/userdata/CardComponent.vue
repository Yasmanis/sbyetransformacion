<template>
    <btn-add-component
        @click="showDialog = true"
        tooltips="añadir una nueva tarjeta"
    />

    <q-dialog v-model="showDialog" persistent>
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
                            </q-item>
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
                                                tarjeta de debito **** 3004
                                            </q-item-label>
                                            <q-item-label
                                                >nombre apellido
                                                apellido</q-item-label
                                            >
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
                <btn-confirm-component @click="object ? update : store" />
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
import { errorValidation } from "../../../../helpers/notifications";

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

const form = ref(null);
const formData = useForm({
    name: null,
    number: null,
    defeat: null,
    predetermined: false,
});

const user = computed(() => {
    return usePage().props.auth.user;
});

const save = async () => {
    console.log(formData);

    showDialogConfirm.value = true;
    // form.value.validate().then((success) => {
    //     if (success) {
    //         showDialogConfirm.value = true;
    //     } else {
    //         errorValidation();
    //     }
    // });
};

const store = async () => {
    console.log(formData);

    // formData.post(props.module.base_url, {
    //     onSuccess: (data) => {
    //         setDefaultData();
    //         emits("created", data.props.object, hide);
    //     },
    // });
};

const update = async () => {
    console.log(formData);
    // formData.put(`${props.module.base_url}/${props.object.id}`, {
    //     onSuccess: (data) => {
    //         setDefaultData();
    //         emits("updated", data.props.object);
    //     },
    // });
};
</script>
