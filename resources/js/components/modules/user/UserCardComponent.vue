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
                        <users-select-dialog-component
                            name="assigned_user"
                            label="facilitador de procesos"
                            icon="fas fa-user-plus"
                            icon-size="sm"
                            selected-role="facilitador"
                            :multiple="false"
                            :show-label-when-selected="false"
                            @update="
                                (name, val) =>
                                    (formData[name] = val[0]?.value ?? null)
                            "
                        />
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
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 q-pb-md"
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
                        <users-select-dialog-component
                            name="gestor"
                            label="gestor"
                            icon="mdi-account-voice"
                            :multiple="false"
                            :show-label-when-selected="false"
                            @update="
                                (name, val) =>
                                    (formData[name] = val[0]?.value ?? null)
                            "
                        />
                    </div>
                </div>
                <div class="row q-col-gutter-md">
                    <div
                        class="col-xs-12 col-xl-2 col-lg-2 col-md-2 col-sm-12"
                        :style="{
                            'padding-top':
                                Screen.xs || Screen.sm ? null : '50px',
                        }"
                    >
                        <text-field label="programa" />
                    </div>
                    <div
                        class="col-xs-12 col-sm-12 col-xl-3 col-lg-3 col-md-3 q-col-gutter-sm q-pt-lg"
                    >
                        <q-item-label caption>consultas</q-item-label>
                        <div class="row q-col-gutter-md">
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field label="totales" />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field label="consumidas" />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field label="proxima" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-xs-12 col-sm-6 col-xl-2 col-lg-2 col-md-2 q-col-gutter-md"
                        :style="{
                            'padding-top':
                                Screen.xs || Screen.sm ? null : '50px',
                        }"
                    >
                        <text-field label="ultimo pago" />
                        <text-field />
                    </div>
                    <div
                        class="col-xs-12 col-sm-6 col-xl-2 col-lg-2 col-md-2 q-col-gutter-md"
                        :style="{
                            'padding-top':
                                Screen.xs || Screen.sm ? null : '50px',
                        }"
                    >
                        <date-field label="proximo pago" />
                        <text-field />
                    </div>
                    <div
                        class="col-xs-12 col-xl-3 col-lg-3 col-md-3 q-col-gutter-sm col-sm-12 q-pt-lg"
                    >
                        <q-item-label caption>consolidacion</q-item-label>
                        <div class="row q-col-gutter-md">
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field label="totales" />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field label="consumidas" />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <date-field label="proxima" />
                            </div>
                        </div>
                    </div>
                </div>
                <q-item style="padding: 0" class="q-mt-md">
                    <q-item-section
                        ><text-field
                            name="characteristics"
                            type="textarea"
                            label="caracteristicas"
                            autogrow
                            @update="onUpdateField"
                    /></q-item-section>
                    <q-item-section avatar>
                        <q-icon name="mdi-image-plus">
                            <q-tooltip-component title="subir imagen" />
                        </q-icon>
                    </q-item-section>
                </q-item>
                <div class="row q-mt-md">
                    <div class="col">
                        <text-field
                            name="observations"
                            type="textarea"
                            label="observaciones"
                            autogrow
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-mt-xs q-col-gutter-md">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <text-field
                            name="observations"
                            type="textarea"
                            label="fecha gestion"
                            autogrow
                            @update="onUpdateField"
                        />
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                        <text-field
                            name="observations"
                            type="textarea"
                            label="citas y gestiones"
                            autogrow
                            @update="onUpdateField"
                        />
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
import { onMounted, watch, ref, readonly } from "vue";
import BtnHighlightComponent from "../../btn/BtnHighlightComponent.vue";
import BtnMsgComponent from "../../btn/BtnMsgComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import ImageField from "../../form/input/ImageField.vue";
import BtnBasketComponent from "../../btn/BtnBasketComponent.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";

import FormNoteComponent from "../notes/FormNoteComponent.vue";
import MenuNoteComponent from "../notes/MenuNoteComponent.vue";
import UsersSelectDialogComponent from "./UsersSelectDialogComponent.vue";
import { useForm } from "@inertiajs/vue3";

import { useUtils } from "../../../composables/useUtils.js";
import { map } from "lodash";
import { Screen } from "quasar";
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
