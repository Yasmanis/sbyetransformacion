<template>
    <q-card flat>
        <q-card-section>
            <q-form ref="form" greedy>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <text-field
                            :modelValue="formData.name"
                            name="name"
                            label="nombre"
                            :highlighteds="
                                user?.row_config?.highlighteds_columns ?? null
                            "
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
                            :highlighteds="
                                user?.row_config?.highlighteds_columns ?? null
                            "
                            :othersProps="{
                                required: true,
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <select-field
                            label="rol"
                            name="roles"
                            :model-value="formData.roles"
                            :multiple="true"
                            :others-props="{
                                url_to_options: '/roles',
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <users-select-dialog-component
                            name="facilitator_id"
                            label="facilitador de procesos"
                            icon="fas fa-user-plus"
                            icon-size="sm"
                            selected-role="facilitador"
                            :multiple="false"
                            :show-label-when-selected="false"
                            :model-value="formData.facilitator_id"
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-col-gutter-x-lg">
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
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
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
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
                        class="col-xl-1 col-lg-1 col-md-1 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="age"
                            label="edad"
                            :model-value="formData.age?.toString() ?? '0'"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
                    </div>
                    <div
                        class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="old_age"
                            :model-value="formData.antique"
                            label="antigüedad"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
                    </div>
                    <div
                        class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pb-md"
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
                            @update="onUpdateField"
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
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pb-md"
                    >
                        <users-select-dialog-component
                            name="manager_id"
                            label="gestor"
                            :icon="`img:${$page.props.public_path}images/icon/${
                                Dark.isActive ? 'white' : 'black'
                            }-manager.png`"
                            selected-role="facilitador"
                            :multiple="false"
                            :show-label-when-selected="false"
                            :model-value="formData.manager_id"
                            @update="onUpdateField"
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
                        <text-field
                            label="programa"
                            name="program"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
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
                                <text-field
                                    name="totales"
                                    label="totales"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field
                                    name="consumidas"
                                    label="consumidas"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field
                                    name="proxima"
                                    label="proxima"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
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
                        <text-field
                            label="ultimo pago"
                            name="last_payment"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
                        <text-field
                            name="name"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
                    </div>
                    <div
                        class="col-xs-12 col-sm-6 col-xl-2 col-lg-2 col-md-2 q-col-gutter-md"
                        :style="{
                            'padding-top':
                                Screen.xs || Screen.sm ? null : '50px',
                        }"
                    >
                        <date-field
                            label="proximo pago"
                            name="next_payment"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
                        <text-field
                            name="name"
                            :othersProps="{
                                readonly: true,
                            }"
                        />
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
                                <text-field
                                    name="totals"
                                    label="totales"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <text-field
                                    name="consumidas"
                                    label="consumidas"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
                            </div>
                            <div
                                :class="
                                    Screen.xs || Screen.sm
                                        ? 'col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4'
                                        : 'col-12'
                                "
                            >
                                <date-field
                                    name="proxima"
                                    label="proxima"
                                    :othersProps="{
                                        readonly: true,
                                    }"
                                />
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
                            :model-value="formData.characteristics"
                            @update="onUpdateField"
                    /></q-item-section>
                    <q-item-section avatar>
                        <form-cropper-field
                            name="characteristics_img"
                            size="40px"
                            :square="true"
                            :model-value="formData.characteristics_img"
                            @update="onUpdateField"
                        />
                    </q-item-section>
                </q-item>
                <div class="row q-mt-md">
                    <div class="col">
                        <text-field
                            name="observations"
                            type="textarea"
                            label="observaciones"
                            autogrow
                            :model-value="formData.observations"
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-mt-xs q-col-gutter-md">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <text-field
                            name="managers_dates"
                            type="textarea"
                            label="fecha gestion"
                            autogrow
                            :model-value="formData.managers_dates"
                            @update="onUpdateField"
                        />
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                        <text-field
                            name="managers_quotes"
                            type="textarea"
                            label="citas y gestiones"
                            autogrow
                            :model-value="formData.managers_quotes"
                            @update="onUpdateField"
                        />
                    </div>
                </div>
                <div class="row q-mt-md q-col-gutter-md" v-if="!user">
                    <div
                        class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 q-pb-md"
                    >
                        <text-field
                            name="username"
                            label="usuario"
                            :othersProps="{
                                required: true,
                            }"
                            @update="onUpdateField"
                        />
                    </div>
                    <div
                        class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12 q-pb-md"
                    >
                        <password-field
                            ref="passwordRef"
                            label="contraseña"
                            inline
                            name="password"
                            :othersProps="{ required: true }"
                            @update="onUpdateField"
                            @confirm="onUpdateField"
                        />
                    </div>
                </div>
            </q-form>
        </q-card-section>
        <q-separator />
        <q-card-actions>
            <q-toolbar class="no-padding" style="min-height: 20px !important">
                <btn-msg-component />
                <highlighted-component v-if="user" />
                <template v-if="user">
                    <menu-note-component
                        :object="user.note"
                        v-if="user?.note"
                    />
                    <form-note-component
                        model="User"
                        :notables="[user]"
                        v-else
                    />
                </template>

                <q-space />

                <btn-save-component @click="save" />
                <q-btn-component
                    icon="mdi-content-save-move-outline"
                    tooltips="guardar y volver a la lista"
                    @click="save(true)"
                />
                <lock-unlock-component
                    :object="user"
                    v-if="user && hasEdit && user.name !== 'sa'"
                />
            </q-toolbar>
        </q-card-actions>
    </q-card>
</template>

<script setup>
import { watch, ref, onMounted } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnMsgComponent from "../../btn/BtnMsgComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import PasswordField from "../../form/input/PasswordField.vue";
import LockUnlockComponent from "./LockUnlockComponent.vue";
import FormNoteComponent from "../notes/FormNoteComponent.vue";
import MenuNoteComponent from "../notes/MenuNoteComponent.vue";
import UsersSelectDialogComponent from "./UsersSelectDialogComponent.vue";
import FormCropperField from "../../form/input/FormCropperField.vue";
import HighlightedComponent from "../../table/actions/HighlightedComponent.vue";
import { useForm } from "@inertiajs/vue3";

import { useUtils } from "../../../composables/useUtils.js";
import { Dark, Screen } from "quasar";
import { errorValidation } from "../../../helpers/notifications.js";
defineOptions({
    name: "UserCardComponent",
});

const props = defineProps({
    user: {
        type: Object,
    },
    buyer: {
        type: Object,
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

const form = ref(null);
const formData = ref({
    birthdate: null,
});
const phoneCodes = ref([]);
const passwordRef = ref(null);

onMounted(() => {
    setData();
});

watch(
    () => formData.value.birthdate,
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
        formData.value.age = edadCalculada;
    }
);

const setData = () => {
    const user = props.user,
        buyer = props.buyer;
    formData.value = {
        name: user?.name ?? null,
        surname: user?.surname ?? null,
        email: user?.email ?? null,
        antique: user?.antique ?? null,
        roles: user?.roles ?? null,
        username: user?.username ?? null,
        genre: buyer?.genre ?? null,
        age: buyer?.age ?? null,
        birthdate: buyer?.birthdate_str ?? null,
        province: buyer?.province ?? null,
        city: buyer?.city ?? null,
        road: buyer?.road ?? null,
        address: buyer?.address ?? null,
        nif_cif: buyer?.nif_cif ?? null,
        country_id: buyer?.country_id ?? null,
        phone_code: buyer?.phone_code ?? null,
        phone: buyer?.phone ?? null,
        user_id: user?.id ?? null,
        manager_id: buyer?.manager_id ?? null,
        facilitator_id: buyer?.facilitator_id ?? null,
        characteristics: buyer?.characteristics ?? null,
        observations: buyer?.observations ?? null,
        managers_dates: buyer?.managers_dates ?? null,
        managers_quotes: buyer?.managers_quotes ?? null,
        characteristics_img: buyer?.characteristics_img ?? null,
    };
    passwordRef.value?.reset();
};

const onUpdateField = (name, value, full) => {
    if (name === "country_id" && value !== null) {
        phoneCodes.value = getPhoneCodesFromCountry(full);
        formData.value.phone_code = null;
    }
    formData.value[name] = value;
};

const onLoadedOptions = (opts) => {
    let opt = opts.find((o) => o.value === formData.value.country_id) ?? null;
    if (opt) {
        phoneCodes.value = getPhoneCodesFromCountry(opt);
    }
};

const save = (toList = false) => {
    form.value.validate().then((success) => {
        if (success) {
            const send = useForm({
                ...formData.value,
                toList,
            });
            if (props.user) {
                send.put(`/admin/users/${props.user.id}`);
            } else {
                send.post(`/admin/users`, {
                    preserveState: false,
                });
            }
        } else {
            errorValidation();
        }
    });
};
</script>
