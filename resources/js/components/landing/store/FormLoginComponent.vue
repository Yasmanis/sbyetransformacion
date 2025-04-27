<template>
    <p class="text-center text-white">
        YA SOY CLIENTE EN SBYETRANSFORMACION APP
    </p>
    <q-form ref="formLogin" greedy class="q-gutter-md">
        <q-card flat>
            <q-card-section class="q-gutter-sm">
                <text-field
                    label="email"
                    name="email"
                    :model-value="form.email"
                    type="email"
                    :error="errors.email !== undefined"
                    :error-message="errors.email"
                    :rules="[
                        (val) => !!val || 'el correo es requerido',
                        (val, rules) => rules.email(val) || 'correo no valido',
                    ]"
                    @keydown.enter.prevent="authenticate"
                    @update="onUpdate"
                />
                <text-field
                    label="contraseña"
                    name="password"
                    type="password"
                    :model-value="form.password"
                    :error="errors.password !== undefined"
                    :error-message="errors.password"
                    :rules="[
                        (val) =>
                            (val && val.length > 0) ||
                            'la contraseña es requerido',
                    ]"
                    @keydown.enter.prevent="authenticate"
                    @update="onUpdate"
                    v-if="!lostPassword"
                />
                <checkbox-field
                    name="rememberme"
                    :model-value="form.rememberme"
                    label="recordar contraseña"
                    class="q-pl-none q-ml-none q-mt-md"
                    @update="onUpdate"
                    v-if="!lostPassword"
                />
            </q-card-section>
            <q-card-section class="text-center">
                <q-btn
                    :label="
                        lostPassword ? 'CAMBIO DE CONTRASEÑA' : 'INICIAR SESION'
                    "
                    label="INICIAR SESION"
                    color="black"
                    @click="authenticate"
                />
            </q-card-section>
            <q-card-section class="text-center">
                <q-item-label
                    class="text-primary cursor-pointer"
                    @click="lostPassword = !lostPassword"
                    >{{
                        lostPassword
                            ? "volver al login"
                            : "he olvidado mi contraseña"
                    }}</q-item-label
                >
            </q-card-section>
        </q-card>
    </q-form>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import TextField from "../../form/input/TextField.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import { usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../../helpers/notifications";
import { login, getPassword } from "../../../services/auth";

defineOptions({
    name: "FormLoginComponent",
});

const lostPassword = ref(false);
const formLogin = ref(null);

const form = ref({
    email: null,
    password: null,
    rememberme: false,
});

watch(lostPassword, (n) => {
    form.value = {
        email: null,
        password: null,
        rememberme: false,
    };
    formLogin.value.resetValidation();
});

const errors = computed(() => {
    return usePage().props.errors;
});

const onUpdate = (name, val) => {
    form.value[name] = val;
};

const authenticate = async () => {
    formLogin.value.validate().then(async (success) => {
        if (success) {
            let { email, password, rememberme } = form.value;
            if (lostPassword.value) {
                getPassword(email);
            } else {
                login(email, password, rememberme);
            }
        } else {
            errorValidation();
        }
    });
};
</script>
