<template>
    <p class="text-center">
        ES LA PRIMERA VEZ <br />
        QUE CONTRATO EN SBYETRANSFORMACION APP
    </p>
    <q-btn label="INICIAR REGISTRO" color="black" @click="showDialog = true" />
    <q-dialog v-model="showDialog" persistent @hide="onHide">
        <q-card style="width: 900px; max-width: 90vw">
            <q-toolbar>
                <q-icon name="mdi-file-account-outline" size="sm" />
                <q-toolbar-title style="padding-left: 5px"
                    >acceso a sbyetransformacion para formalizar la
                    compra</q-toolbar-title
                >
                <car-component only-btn />
            </q-toolbar>
            <q-separator />
            <q-card-section>
                <q-form ref="formRef" greedy class="q-gutter-sm">
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="nombre"
                                name="name"
                                :model-value="formData.name"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="apellidos"
                                name="surname"
                                :model-value="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <select-field
                                label="genero"
                                name="genre"
                                :model-value="formData.genre"
                                :filterable="false"
                                :options="[
                                    {
                                        label: 'masculino',
                                        value: 'M',
                                    },
                                    {
                                        label: 'femenino',
                                        value: 'F',
                                    },
                                ]"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <date-field
                                label="fecha de nacimiento"
                                name="birthdate"
                                :model-value="formData.birthdate"
                                end-now
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <select-field
                                label="pais"
                                name="country_id"
                                :model-value="formData.country_id"
                                :others-props="{
                                    required: true,
                                    url_to_options: '/countries',
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="localidad"
                                name="city"
                                :model-value="formData.city"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="provincia"
                                name="province"
                                :model-value="formData.province"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="codigo postal"
                                name="postal_code"
                                :model-value="formData.postal_code"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                label="tipo via"
                                name="road"
                                :model-value="formData.road"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-9 col-md-9 col-lg-9 col-xl-9 q-px-sm"
                        >
                            <text-field
                                label="nombre via, numero, portal, piso, puerta"
                                name="address"
                                :model-value="formData.address"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-sm"
                        >
                            <text-field
                                name="phone"
                                :model-value="formData.phone"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            >
                                <template #before>
                                    <select-field
                                        name="phone_code"
                                        label="telefono"
                                        :model-value="formData.phone_code"
                                        :disable="!formData.country_id"
                                        :options="phoneCodes"
                                        :filterable="false"
                                        :clearable="false"
                                        style="width: 120px !important"
                                        @update="onUpdateField"
                                        :others-props="{
                                            required: true,
                                        }"
                                    />
                                </template>
                            </text-field>
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-px-sm"
                        >
                            <text-field
                                label="email"
                                name="email"
                                :model-value="formData.email"
                                :others-props="{
                                    required: true,
                                    type: 'email',
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-6 col-lg-3 col-md-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                type="password"
                                label="contraseña"
                                name="password"
                                :model-value="formData.password"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-lg-3 col-md-3 col-xl-3 q-px-sm"
                        >
                            <text-field
                                type="password"
                                label="confirmar contraseña"
                                name="password_confirmed"
                                :model-value="formData.password_confirmed"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-lg-6 col-md-6 col-xl-6 q-px-sm q-pt-md"
                            :class="
                                !screen.xs && !screen.sm ? 'text-right' : null
                            "
                        >
                            <checkbox-field
                                label="leo y acepto los terminos legales"
                                name="conditions"
                                :model-value="formData.conditions"
                                @update="onUpdateField"
                            />
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-card-actions align="right" class="q-mb-sm">
                <btn-confirm-component
                    tooltips="registrarme"
                    @click="register"
                />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import CarComponent from "./CarComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import { useQuasar } from "quasar";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation, error } from "../../../helpers/notifications";

defineOptions({
    name: "FormRegisterComponent",
});

const emits = defineEmits(["showing"]);

const formData = useForm({
    name: null,
    surname: null,
    genre: null,
    birthdate: null,
    country_id: null,
    city: null,
    province: null,
    road: null,
    address: null,
    postal_code: null,
    phone: null,
    phone_code: null,
    email: null,
    password: null,
    password_confirmed: null,
    conditions: false,
});
const formRef = ref(null);
const screen = computed(() => {
    return useQuasar().screen;
});

const showDialog = ref(false);

const page = usePage();

const phoneCodes = ref([]);

watch(
    () => formData.country_id,
    (n) => {
        formData.phone_code = null;
    }
);

const onHide = () => {
    formData["name"] = null;
    formData["surname"] = null;
    formData["genre"] = null;
    formData["birthdate"] = null;
    formData["country_id"] = null;
    formData["city"] = null;
    formData["province"] = null;
    formData["road"] = null;
    formData["address"] = null;
    formData["postal_code"] = null;
    formData["phone"] = null;
    formData["phone_code"] = null;
    formData["email"] = null;
    formData["password"] = null;
    formData["password_confirmed"] = null;
    formData["conditions"] = false;
    phoneCodes.value = [];
    page.props.errors = {};
};

const onUpdateField = (name, val, full) => {
    if (name === "country_id" && val !== null) {
        let codes = full.phonecode.split(" ");
        phoneCodes.value = [];
        codes.forEach((c) => {
            phoneCodes.value.push({
                label: c,
                value: c,
            });
        });
    }

    formData[name] = val;
};

const register = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            if (!formData.conditions) {
                error("debe aceptar los terminos legales");
            } else {
                submit();
            }
        } else {
            errorValidation();
        }
    });
};

const submit = () => {
    formData.post("/buyer-register", {
        onSuccess: (response) => {
            formData.reset();
            formRef.value.reset();
            showDialog.value = false;
        },
    });
};
</script>
<style>
.q-item__label.ellipsis {
    max-width: 90% !important;
}
.q-select .q-field__input {
    min-width: 10px;
}
</style>
