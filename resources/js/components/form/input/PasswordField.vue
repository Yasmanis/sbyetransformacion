<template>
    <template v-if="inline">
        <div class="row q-col-gutter-md">
            <div
                class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3"
                v-if="oldPassword"
            >
                <q-input
                    name="old_password"
                    label="contraseña actual"
                    :rules="[(val) => !!val || 'requerido']"
                    :error="oldPwd !== null"
                    :error-message="oldPwd"
                    :dense="dense"
                    :clearable="clearable"
                    hide-bottom-space
                    bottom-slots
                    v-model="oldPass"
                    :type="isOldPwd ? 'password' : 'text'"
                    class="full-width"
                    @update:model-value="onChangeOldPassword"
                >
                    <template #hint>
                        <ul
                            style="
                                padding: 0;
                                margin-top: 0px;
                                margin-bottom: 0px;
                            "
                        >
                            <li style="list-style: none">requerido</li>
                        </ul>
                    </template>
                    <template v-slot:append>
                        <q-icon
                            :name="isOldPwd ? 'visibility_off' : 'visibility'"
                            class="cursor-pointer"
                            @click="isOldPwd = !isOldPwd"
                        />
                    </template>
                </q-input>
            </div>
            <div
                class="col-xs-12"
                :class="
                    oldPassword
                        ? 'col-sm-4 col-md-4 col-lg-4 col-xl-4'
                        : 'col-sm-6 col-md-6 col-lg-6 col-xl-6'
                "
            >
                <q-input
                    :name="props.name"
                    :label="props.label"
                    :rules="fieldRules"
                    :error="errorPwd !== null"
                    :error-message="errorPwd"
                    :dense="dense"
                    :clearable="clearable"
                    hide-bottom-space
                    bottom-slots
                    v-model="model"
                    :type="isPwd ? 'password' : 'text'"
                    class="full-width"
                    @update:model-value="onChangePassword"
                >
                    <template #label v-if="label">
                        {{ label }}
                        <span class="text-red" v-if="othersProps?.required"
                            >*</span
                        >
                    </template>
                    <template #hint v-if="fieldHelp?.length > 0">
                        <ul
                            style="
                                padding: 0;
                                margin-top: 0px;
                                margin-bottom: 0px;
                            "
                        >
                            <li
                                v-for="(h, index) in fieldHelp"
                                :key="`help-${index}`"
                                style="list-style: none"
                            >
                                {{ h }}
                            </li>
                        </ul>
                    </template>
                    <template v-slot:append>
                        <q-icon
                            :name="isPwd ? 'visibility_off' : 'visibility'"
                            class="cursor-pointer"
                            @click="isPwd = !isPwd"
                        />
                    </template>
                </q-input>
            </div>
            <div
                class="col-xs-12"
                :class="
                    oldPassword
                        ? 'col-sm-4 col-md-4 col-lg-4 col-xl-4'
                        : 'col-sm-6 col-md-6 col-lg-6 col-xl-6'
                "
            >
                <q-input
                    v-model="modelConfirm"
                    name="password_confirm"
                    label="confirmar contraseña"
                    :rules="[
                        (val) => !!val || 'requerido',
                        (val) =>
                            val === model || 'las contraseñas no coinciden',
                    ]"
                    :error="errorConfirm !== null"
                    :error-message="errorConfirm"
                    :dense="dense"
                    :clearable="clearable"
                    hide-bottom-space
                    bottom-slots
                    :type="isPwdConfirm ? 'password' : 'text'"
                    class="full-width"
                    @update:model-value="onChangeConfirm"
                >
                    <template #label>
                        confirmar contraseña
                        <span class="text-red" v-if="othersProps?.required"
                            >*</span
                        >
                    </template>
                    <template #hint>
                        <ul
                            style="
                                padding: 0;
                                margin-top: 0px;
                                margin-bottom: 0px;
                            "
                        >
                            <li style="list-style: none">
                                igual que la anterior
                            </li>
                        </ul>
                    </template>
                    <template v-slot:append>
                        <q-icon
                            :name="
                                isPwdConfirm ? 'visibility_off' : 'visibility'
                            "
                            class="cursor-pointer"
                            @click="isPwdConfirm = !isPwdConfirm"
                        />
                    </template>
                </q-input>
            </div>
        </div>
    </template>
    <template v-else
        ><q-input
            name="old_password"
            label="contraseña actual"
            :rules="[(val) => !!val || 'requerido']"
            :error="oldPwd !== null"
            :error-message="oldPwd"
            :dense="dense"
            :clearable="clearable"
            hide-bottom-space
            bottom-slots
            v-model="oldPass"
            :type="isOldPwd ? 'password' : 'text'"
            class="full-width"
            @update:model-value="onChangeOldPassword"
            v-if="oldPassword"
        >
            <template #hint>
                <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                    <li style="list-style: none">requerido</li>
                </ul>
            </template>
            <template v-slot:append>
                <q-icon
                    :name="isOldPwd ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isOldPwd = !isOldPwd"
                />
            </template>
        </q-input>
        <q-input
            :name="props.name"
            :label="props.label"
            :rules="fieldRules"
            :error="errorPwd !== null"
            :error-message="errorPwd"
            :dense="dense"
            :clearable="clearable"
            hide-bottom-space
            bottom-slots
            v-model="model"
            :type="isPwd ? 'password' : 'text'"
            class="full-width"
            @update:model-value="onChangePassword"
        >
            <template #label v-if="label">
                {{ label }}
                <span class="text-red" v-if="othersProps?.required">*</span>
            </template>
            <template #hint v-if="fieldHelp?.length > 0">
                <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                    <li
                        v-for="(h, index) in fieldHelp"
                        :key="`help-${index}`"
                        style="list-style: none"
                    >
                        {{ h }}
                    </li>
                </ul>
            </template>
            <template v-slot:append>
                <q-icon
                    :name="isPwd ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isPwd = !isPwd"
                />
            </template>
        </q-input>
        <q-input
            v-model="modelConfirm"
            name="password_confirm"
            label="confirmar contraseña"
            :rules="[
                (val) => !!val || 'requerido',
                (val) => val === model || 'las contraseñas no coinciden',
            ]"
            :error="errorConfirm !== null"
            :error-message="errorConfirm"
            :dense="dense"
            :clearable="clearable"
            hide-bottom-space
            bottom-slots
            :type="isPwdConfirm ? 'password' : 'text'"
            class="full-width"
            @update:model-value="onChangeConfirm"
        >
            <template #label v-if="label">
                {{ label }}
                <span class="text-red" v-if="othersProps?.required">*</span>
            </template>
            <template #hint>
                <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                    <li style="list-style: none">igual que la anterior</li>
                </ul>
            </template>
            <template v-slot:append>
                <q-icon
                    :name="isPwdConfirm ? 'visibility_off' : 'visibility'"
                    class="cursor-pointer"
                    @click="isPwdConfirm = !isPwdConfirm"
                />
            </template> </q-input
    ></template>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, computed } from "vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "PasswordField",
});

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
        default: "contraseña",
    },
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
    oldPassword: {
        type: Boolean,
        default: false,
    },
    inline: Boolean,
});

const emits = defineEmits(["update", "confirm", "old-password"]);
const page = usePage();
const model = ref(null);
const modelConfirm = ref(null);
const oldPass = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);
const isPwd = ref(true);
const isPwdConfirm = ref(true);
const isOldPwd = ref(true);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

const errorPwd = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});

const errorConfirm = computed(() => {
    let name = `${props.name}_confirmed`;
    return page.props.errors
        ? page.props.errors[name]
            ? page.props.errors[name]
            : null
        : null;
});

const oldPwd = computed(() => {
    return page.props.errors
        ? page.props.errors["old_password"]
            ? page.props.errors["old_password"]
            : null
        : null;
});

const reset = () => {
    model.value = null;
    modelConfirm.value = null;
    oldPass.value = null;
    isPwd.value = true;
    isPwdConfirm.value = true;
    isOldPwd.value = true;
    delete page.props.errors["old_password"];
};

const onChangePassword = (val) => {
    emits("update", props.name, val);
};

const onChangeConfirm = (val) => {
    emits("confirm", `${props.name ? props.name : "password"}_confirmed`, val);
};

const onChangeOldPassword = (val) => {
    emits("old-password", "old_password", val);
};

defineExpose({ reset });
</script>
