<template>
    <q-layout view="lHh Lpr lFf">
        <q-page-container>
            <q-page
                class="window-height window-width row justify-center items-center bg-primary"
            >
                <div class="column q-pa-lg">
                    <q-card square class="shadow-24" style="width: 300px">
                        <q-card-section class="bg-deep-purple-7">
                            <span class="text-h5 text-white q-my-md"
                                >sbyetransformacion</span
                            >
                        </q-card-section>
                        <q-card-section>
                            <q-form class="q-px-sm" ref="formRef" greedy>
                                <q-input
                                    square
                                    clearable
                                    v-model="form.email"
                                    type="email"
                                    label="correo"
                                    :error="errors.email !== undefined"
                                    :error-message="errors.email"
                                    :rules="[
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
                                    clearable
                                    v-model="form.password"
                                    type="password"
                                    label="contrase&ntilde;a"
                                    :error="errors.password !== undefined"
                                    :error-message="errors.password"
                                    :rules="[
                                        (val) =>
                                            (val && val.length > 0) ||
                                            'la contraseña es requerido',
                                    ]"
                                >
                                    <template v-slot:prepend>
                                        <q-icon name="lock" />
                                    </template>
                                </q-input>
                            </q-form>
                        </q-card-section>
                        <q-card-actions class="q-px-lg">
                            <q-btn
                                size="lg"
                                color="primary"
                                class="full-width text-white"
                                label="acceder"
                                @click="authenticate(form.email, form.password)"
                            />
                        </q-card-actions>
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
defineOptions({
    name: "Login",
});

const form = ref({
    email: "sa@sa.com",
    password: "password",
});

const formRef = ref(null);

const errors = computed(() => {
    return usePage().props.errors;
});

const authenticate = (email, password) => {
    formRef.value.validate().then((success) => {
        if (success) {
            login(email, password);
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
