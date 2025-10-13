<template>
    <q-btn-component
        icon="mdi-card-account-details-outline"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" full-width persistent>
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-card-account-details-outline"
                title="ficha de usuario"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="scroll">
                <q-form ref="formRef" greedy>
                    <div class="row q-col-gutter-x-lg">
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="name"
                                label="nombre"
                                :model-value="formData.name"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="surname"
                                label="apellidos"
                                :model-value="formData.surname"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="user_process"
                                label="facilitador de procesos"
                                :model-value="formData.user_process"
                                :readonly="true"
                                :othersProps="{
                                    required: true,
                                }"
                            >
                                <template #after>
                                    <q-btn-component
                                        icon="mdi-account-tie"
                                        tooltips="seleccionar"
                                    />
                                </template>
                            </text-field>
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <select-field
                                name="genre"
                                label="genero"
                                :model-value="formData.genre"
                                :options="[
                                    {
                                        label: 'masculino',
                                        value: 'm',
                                    },
                                    {
                                        label: 'femenino',
                                        value: 'f',
                                    },
                                ]"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-col-gutter-x-lg">
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12"
                        >
                            <date-field
                                name="birthdate"
                                label="fecha nacimiento"
                                :model-value="formData.birthdate"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12"
                        >
                            <text-field
                                name="age"
                                label="edad"
                                readonly
                                :model-value="formData.age"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12"
                        >
                            <text-field
                                name="old_age"
                                :model-value="formData.old_age"
                                :readonly="true"
                                label="antigüedad"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-8 col-xs-12"
                        >
                            <country-field />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12"
                        >
                            <text-field
                                name="postal_code"
                                :model-value="formData.postal_code"
                                :readonly="true"
                                label="codigo postal"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-col-gutter-x-lg">
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="locate"
                                label="localidad"
                                :model-value="formData.locate"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="province"
                                label="provincia"
                                :model-value="formData.province"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-12"
                        >
                            <text-field
                                name="road"
                                :model-value="formData.road"
                                label="tipo via"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-6 col-lg-6 col-md-6 col-sm-9 col-xs-12"
                        >
                            <text-field
                                name="address"
                                :model-value="formData.address"
                                label="nombre via, numero, portal, piso, puerta"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-col-gutter-x-lg">
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12"
                        >
                            <phone-field />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="province"
                                label="provincia"
                                :model-value="formData.province"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="email"
                                :model-value="formData.email"
                                label="email"
                                :othersProps="{
                                    required: true,
                                    type: 'email',
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="nif_cif"
                                :model-value="formData.nif_cif"
                                label="nif/cif"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div
                            class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12"
                        >
                            <text-field
                                name="gestor"
                                :model-value="formData.gestor"
                                label="gestor"
                                readonly
                                :othersProps="{
                                    required: true,
                                }"
                                ><template #after>
                                    <q-btn-component
                                        icon="mdi-account-tie"
                                        tooltips="seleccionar"
                                    />
                                    <btn-basket-component /> </template
                            ></text-field>
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import CountryField from "../../form/input/CountryField.vue";
import PhoneField from "../../form/input/PhoneField.vue";
import BtnBasketComponent from "../../btn/BtnBasketComponent.vue";
import { useForm } from "@inertiajs/vue3";
defineOptions({
    name: "UserCardComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);
const formRef = ref(null);
const formData = useForm({});
</script>
