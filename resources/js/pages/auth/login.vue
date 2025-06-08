<template>
    <q-layout view="lHh Lpr lFf">
        <q-page-container>
            <q-page
                class="window-height window-width row justify-center items-center bg-primary"
            >
                <div class="column q-pa-lg">
                    <q-card square class="shadow-24" style="width: 300px">
                        <q-card-section class="bg-primary">
                            <q-img
                                :src="`${$page.props.public_path}images/logo/1.png`"
                            />
                        </q-card-section>
                        <form-forgot-password-component
                            v-if="lostPassword"
                            @reset="
                                (val) => {
                                    email = val;
                                    lostPassword = false;
                                }
                            "
                            @cancel="lostPassword = false"
                        />
                        <form-login-component
                            :email="email"
                            v-if="!lostPassword"
                        />
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
                                tooltipsColor="black"
                                tooltips="volver a inicio"
                                href="/"
                                :flat="false"
                                color="black"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-facebook-f"
                                tooltipsColor="black"
                                tooltips="facebook"
                                class="q-mx-md"
                                href="https://www.facebook.com/profile.php?id=61563937152210"
                                target="_blank"
                                :flat="false"
                                color="black"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-youtube"
                                tooltipsColor="black"
                                tooltips="youtube"
                                href="https://www.youtube.com/@sbyetransformacion"
                                target="_blank"
                                :flat="false"
                                color="black"
                            />
                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-instagram"
                                tooltipsColor="black"
                                tooltips="instagram"
                                class="q-mx-md"
                                href="https://www.instagram.com/sbyetransformacion/"
                                target="_blank"
                                :flat="false"
                                color="black"
                            />

                            <q-btn-component
                                size="sm"
                                padding="sm"
                                icon="fab fa-tiktok"
                                tooltipsColor="black"
                                tooltips="tiktok"
                                href="https://www.tiktok.com/@sbyetransformacion"
                                target="_blank"
                                :flat="false"
                                color="black"
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
import { errorValidation } from "../../helpers/notifications";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import FormForgotPasswordComponent from "../../components/auth/FormForgotPasswordComponent.vue";
import FormLoginComponent from "../../components/auth/FormLoginComponent.vue";
defineOptions({
    name: "Login",
});

const lostPassword = ref(false);
const email = ref(null);
</script>
