<template>
    <q-layout view="lHh Lpr lFf">
        <q-page-container>
            <q-page
                class="window-height window-width row justify-center items-center bg-primary"
            >
                <div class="column q-pa-lg">
                    <q-card square class="shadow-24" style="width: 300px">
                        <q-card-section class="bg-black">
                            <q-img
                                :src="`${$page.props.public_path}images/logo/1.png`"
                            />
                        </q-card-section>
                        <q-card-section>
                            <q-form class="q-px-sm" ref="formRef" greedy>
                                <q-input
                                    square
                                    clearable
                                    dense
                                    v-model="form.email"
                                    type="email"
                                    label="correo"
                                    :error="errors.email !== undefined"
                                    :error-message="errors.email"
                                    :rules="[
                                        (val) =>
                                            !!val || 'el correo es requerido',
                                        (val, rules) =>
                                            rules.email(val) ||
                                            'correo no valido',
                                    ]"
                                    @keydown.enter.prevent="authenticate"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="email" />
                                    </template>
                                </q-input>
                                <q-input
                                    square
                                    dense
                                    clearable
                                    v-model="form.password"
                                    :type="isPwd ? 'password' : 'text'"
                                    label="contrase&ntilde;a"
                                    :error="errors.password !== undefined"
                                    :error-message="errors.password"
                                    :rules="[
                                        (val) =>
                                            (val && val.length > 0) ||
                                            'la contraseña es requerido',
                                    ]"
                                    @keydown.enter.prevent="authenticate"
                                    v-if="!lostPassword"
                                >
                                    <template v-slot:append>
                                        <q-icon
                                            class="cursor-pointer"
                                            :name="
                                                isPwd
                                                    ? 'visibility_off'
                                                    : 'visibility'
                                            "
                                            @click="isPwd = !isPwd"
                                        />
                                    </template>
                                    <template v-slot:prepend>
                                        <q-icon name="lock" />
                                    </template>
                                </q-input>
                                <q-checkbox
                                    v-model="form.rememberme"
                                    label="recordarme"
                                    v-if="!lostPassword"
                                ></q-checkbox>
                            </q-form>
                        </q-card-section>
                        <q-card-section class="q-px-lg q-pt-none">
                            <q-btn
                                size="md"
                                color="primary"
                                class="full-width text-white"
                                :label="
                                    lostPassword
                                        ? 'cambio de contraseña'
                                        : 'acceder'
                                "
                                @click="authenticate"
                            />
                        </q-card-section>
                        <q-card-section
                            class="text-center q-pt-none cursor-pointer"
                        >
                            <q-item-label
                                class="text-primary"
                                @click="lostPassword = !lostPassword"
                                >{{
                                    lostPassword
                                        ? "volver al login"
                                        : "he olvidado mi contraseña"
                                }}</q-item-label
                            >
                        </q-card-section>
                        <q-card-section align="center">
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fas fa-home"
                                tooltipsColor="primary"
                                tooltips="volver a inicio"
                                href="/"
                                :flat="false"
                                color="primary"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-facebook-f"
                                tooltipsColor="primary"
                                tooltips="facebook"
                                class="q-mx-md"
                                href="https://www.facebook.com/profile.php?id=61563937152210"
                                target="_blank"
                                :flat="false"
                                color="primary"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-youtube"
                                tooltipsColor="primary"
                                tooltips="youtube"
                                href="https://www.youtube.com/@sbyetransformacion"
                                target="_blank"
                                :flat="false"
                                color="primary"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-instagram"
                                tooltipsColor="primary"
                                tooltips="instagram"
                                class="q-mx-md"
                                href="https://www.instagram.com/sbyetransformacion/"
                                target="_blank"
                                :flat="false"
                                color="primary"
                            />

                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-tiktok"
                                tooltipsColor="primary"
                                tooltips="tiktok"
                                href="https://www.tiktok.com/@sbyetransformacion"
                                target="_blank"
                                :flat="false"
                                color="primary"
                            />
                        </q-card-section>
                    </q-card>
                </div>
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { login, getPassword } from "../../services/auth";
import { errorValidation, error } from "../../helpers/notifications";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
defineOptions({
    name: "Login",
});

const form = ref({
    email: null,
    password: null,
    rememberme: false,
});

const formRef = ref(null);

const isPwd = ref(true);
const lostPassword = ref(false);

watch(lostPassword, (n) => {
    form.value = {
        email: null,
        password: null,
        rememberme: false,
    };
});

const errors = computed(() => {
    return usePage().props.errors;
});

const authenticate = async () => {
    formRef.value.validate().then(async (success) => {
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

watch(errors, (n, o) => {
    if (Object.keys(n).length > 0) {
        errorValidation();
    }
});
</script>
