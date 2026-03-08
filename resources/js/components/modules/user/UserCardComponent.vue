<template>
    <q-card flat>
        <q-card-section>
            <q-form ref="formRef" greedy>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <text-field
                            :modelValue="formData.name"
                            name="name"
                            label="nombre"
                            :othersProps="{
                                required: true,
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <text-field
                            :modelValue="formData.surname"
                            name="surname"
                            label="apellidos"
                            :othersProps="{
                                required: true,
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
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
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
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
                </div>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pb-md"
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
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="age"
                            label="edad"
                            readonly
                            :model-value="formData.age?.toString() ?? '0'"
                        />
                    </div>
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="old_age"
                            :model-value="formData.antique"
                            :readonly="true"
                            label="antigüedad"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-8 col-xs-12 q-pb-md"
                    >
                        <select-field
                            label="pais"
                            name="country_id"
                            :model-value="formData.country_id"
                            :others-props="{
                                required: true,
                                url_to_options: '/countries',
                            }"
                            @loaded-options="onLoadedOptions"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            label="codigo postal"
                            name="postal_code"
                            :model-value="formData.postal_code"
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <text-field
                            label="localidad"
                            name="city"
                            :model-value="formData.city"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 q-pb-md"
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
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-xs-12 q-pb-md"
                    >
                        <text-field
                            label="tipo via"
                            name="road"
                            :model-value="formData.road"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-6 col-lg-6 col-md-6 col-sm-9 col-xs-12 q-pb-md"
                    >
                        <text-field
                            label="nombre via, numero, portal, piso, puerta"
                            name="address"
                            :model-value="formData.address"
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="phone"
                            :model-value="formData.phone"
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
                                    style="width: 90px !important"
                                    @update="onUpdateField"
                                />
                            </template>
                        </text-field>
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
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
                        class="col-xl-2 col-lg-2 col-md-2col-sm-6 col-xs-12 q-pb-md"
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
                        class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pb-md"
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
        <q-separator />
        <q-card-actions>
            <q-toolbar class="no-padding" style="min-height: 20px !important">
                <btn-msg-component />
                <btn-highlight-component />
                <menu-note-component :object="user.note" v-if="user?.note" />
                <form-note-component model="User" :notables="[user]" v-else />
                <q-space />

                <btn-save-component />
                <delete-component
                    :objects="[user]"
                    url="/admin/users"
                    v-if="user.name !== 'sa' && hasDelete"
                />
            </q-toolbar>
        </q-card-actions>
    </q-card>
</template>

<script setup>
import { onMounted, watch, ref } from "vue";
import BtnHighlightComponent from "../../btn/BtnHighlightComponent.vue";
import BtnMsgComponent from "../../btn/BtnMsgComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import CountryField from "../../form/input/CountryField.vue";
import PhoneField from "../../form/input/PhoneField.vue";
import BtnBasketComponent from "../../btn/BtnBasketComponent.vue";

import FormNoteComponent from "../notes/FormNoteComponent.vue";
import MenuNoteComponent from "../notes/MenuNoteComponent.vue";
import { useForm } from "@inertiajs/vue3";

import { useUtils } from "../../../composables/useUtils.js";
defineOptions({
    name: "UserCardComponent",
});

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    buyer: {
        type: Object,
        required: true,
    },
    hasEdit: {
        type: Boolean,
        default: false,
    },
    hasDelete: {
        type: Boolean,
        default: false,
    },
});

const { getPhoneCodesFromCountry } = useUtils();

const formData = useForm({});
const phoneCodes = ref([]);

onMounted(() => {
    setData();
});

watch(
    () => formData.birthdate,
    (n) => {
        if (!n || n.length < 10) return null;

        const [dia, mes, anio] = n.split("/").map(Number);

        const hoy = new Date();
        const fechaNac = new Date(anio, mes - 1, dia);

        let edadCalculada = hoy.getFullYear() - fechaNac.getFullYear();
        const diferenciaMeses = hoy.getMonth() - fechaNac.getMonth();

        if (
            diferenciaMeses < 0 ||
            (diferenciaMeses === 0 && hoy.getDate() < fechaNac.getDate())
        ) {
            edadCalculada--;
        }
        formData.age = edadCalculada;
    },
);

const setData = () => {
    let { name, surname, email, antique } = props.user;
    const buyer = props.buyer;
    formData.name = name;
    formData.surname = surname;
    formData.antique = antique ?? null;
    formData.genre = buyer?.genre ?? null;
    formData.age = buyer?.age ?? null;
    formData.birthdate = buyer?.birthdate_str ?? null;
    formData.province = buyer?.province ?? null;
    formData.city = buyer?.city ?? null;
    formData.road = buyer?.road ?? null;
    formData.address = buyer?.address ?? null;
    formData.nif_cif = buyer?.nif_cif ?? null;
    formData.email = email ?? null;
    formData.country_id = buyer?.country_id ?? null;
    formData.phone_code = buyer?.phone_code ?? null;
    formData.phone = buyer?.phone ?? null;
};

const onUpdateField = (name, value, full) => {
    if (name === "country_id" && value !== null) {
        phoneCodes.value = getPhoneCodesFromCountry(full);
    }
    formData[name] = value;
};

const onLoadedOptions = (opts) => {
    let opt = opts.find((o) => o.value === formData.country_id) ?? null;
    if (opt) {
        phoneCodes.value = getPhoneCodesFromCountry(opt);
    }
};
</script>
