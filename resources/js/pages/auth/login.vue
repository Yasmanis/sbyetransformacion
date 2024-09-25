<template>
    <q-layout view="lHh Lpr lFf">
        <q-page-container>
            <q-page
                class="window-height window-width row justify-center items-center bg-primary"
            >
                <div class="column q-pa-lg">
                    <q-card square class="shadow-24" style="width: 300px">
                        <q-card-section class="bg-deep-purple-7">
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
                                ></q-checkbox>
                            </q-form>
                        </q-card-section>
                        <q-card-actions class="q-px-lg">
                            <q-btn
                                size="md"
                                color="primary"
                                class="full-width text-white"
                                label="acceder"
                                @click="
                                    authenticate(
                                        form.email,
                                        form.password,
                                        form.rememberme
                                    )
                                "
                            />
                        </q-card-actions>
                        <q-card-section align="center">
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fas fa-home"
                                tooltipsColor="primary"
                                tooltips="volver a inicio"
                                href="/"
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
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-youtube"
                                tooltipsColor="primary"
                                tooltips="youtube"
                                href="https://www.youtube.com"
                                target="_blank"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-instagram"
                                tooltipsColor="primary"
                                tooltips="instagram"
                                class="q-mx-md"
                                href="https://www.instagram.com"
                                target="_blank"
                            />

                            <q-btn-component
                                size="sm"
                                padding="sm"
                                :icon="`img:${`${$page.props.public_path}images/icon/tiktok.png`}`"
                                tooltipsColor="primary"
                                tooltips="tiktok"
                                href="https://www.tiktok.com/@sbyetransformacion"
                                target="_blank"
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
import { login } from "../../services/auth";
import { errorValidation, error } from "../../helpers/notifications";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
defineOptions({
    name: "Login",
});

const form = ref({
    email: "sa@sa.com",
    password: "password",
    rememberme: false,
});

const formRef = ref(null);

const isPwd = ref(true);

const errors = computed(() => {
    return usePage().props.errors;
});

const authenticate = (email, password, rememberme) => {
    formRef.value.validate().then((success) => {
        if (success) {
            login(email, password, rememberme);
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
