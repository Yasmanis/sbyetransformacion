<template>
    <div class="col-lg-12 p-4 mt-4" id="form-testimony">
        <q-card flat class="my-card bg-primary">
            <q-card-section class="q-pa-none">
                <q-form ref="formRef" greedy>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <i
                                class="mdi mdi-asterisk text-red"
                                style="margin-left: 58px"
                                v-if="!form.email"
                            />
                            <q-input
                                v-model="form.email"
                                name="email"
                                placeholder="email"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                :rules="[
                                    (val) => !!val || 'requerido',
                                    (val, rules) =>
                                        !!rules.email(val) || 'email no valido',
                                ]"
                                hide-bottom-space
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <i
                                class="mdi mdi-asterisk text-red"
                                style="margin-left: 75px"
                                v-if="!form.name"
                            />
                            <q-input
                                v-model="form.name"
                                name="name"
                                placeholder="nombre"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                :class="!screen.xs ? 'q-mr-xs' : ''"
                                :rules="[(val) => !!val || 'requerido']"
                                hide-bottom-space
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <i
                                class="mdi mdi-asterisk text-red"
                                style="margin-left: 88px"
                                v-if="!form.surname"
                            />
                            <q-input
                                v-model="form.surname"
                                name="surname"
                                placeholder="apellidos"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                :class="!screen.xs ? 'q-mr-xs' : ''"
                                :rules="[(val) => !!val || 'requerido']"
                                hide-bottom-space
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.privated"
                                class="text-white checkbox-white"
                                checked-icon="mdi-circle"
                                unchecked-icon="mdi-circle-outline"
                                dense
                            >
                                he leido y acepto las
                                <Link href="/legal" class="text-black"
                                    >condiciones generales</Link
                                >
                                y la
                                <Link href="/private" class="text-black"
                                    >politica de privacidad</Link
                                >
                            </q-checkbox>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <small>
                                puede cancelar su subscripcion cuando quiera
                                mediante el enlace de nuestra newsletter
                            </small>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <div class="recaptcha-container">
                                <vue3-recaptcha
                                    :sitekey="google_key"
                                    @verify="
                                        (response) =>
                                            (recaptchaResponse = response)
                                    "
                                    @expire="recaptchaResponse = null"
                                ></vue3-recaptcha>
                            </div>
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-card-actions class="q-px-none">
                <q-btn
                    label="me apunto!"
                    rounded
                    color="black"
                    no-caps
                    class="q-mb-md"
                    padding="10px"
                    @click="onSubmit"
                />
            </q-card-actions>
        </q-card>
    </div>

    <subscription-test :show="showTest" @hide="showTest = false" />
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import { errorValidation, error, error500 } from "../../helpers/notifications";
import { useQuasar, Notify } from "quasar";
import SubscriptionTest from "./SubscriptionTest.vue";
import Vue3Recaptcha from "vue3-recaptcha2";

defineOptions({
    name: "FormSubscriptionComponent",
});

const props = defineProps({
    category: Object,
});
const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const showTest = ref(false);
const formRef = ref(null);
const recaptchaResponse = ref(null);
const form = useForm({
    email: null,
    name: null,
    surname: null,
    privated: false,
});

const google_key = import.meta.env.VITE_GOOGLE_CAPTCHA;

const onSubmit = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            if (!form.privated) {
                error(
                    "debe aceptar las condiciones generales y la politica de privacidad"
                );
            } else if (!recaptchaResponse.value) {
                error("debe confirmar que usted no es un robot");
            } else {
                submit();
            }
        } else {
            errorValidation();
        }
    });
};

const submit = () => {
    form.post("/subscribe", {
        onSuccess: (response) => {
            let d = response.props.object;
            if (
                typeof d === "string" &&
                d.indexOf("duplicate_parameter") !== -1
            ) {
                error("ya existe una subscripcion asociada a este correo");
            } else {
                Notify.create({
                    message:
                        "su subscripcion ha sido agregada correctamente, por favor ayudenos resolviendo el siguiente test",
                    position: "top-right",
                    timeout: 0,
                    textColor: "black",
                    classes: "bg-custom-blue",
                    type: "info",
                    actions: [
                        {
                            icon: "close",
                            color: "black",
                            handler: () => {
                                // Acción al cerrar la notificación
                            },
                        },
                    ],
                });
                form.reset();
                formRef.value.reset();
                showTest.value = true;
            }
        },
        onError: (errors) => {
            error500();
        },
    });
};
</script>
<style>
.mdi-asterisk {
    opacity: 0.8;
    position: absolute;
    font-size: 12px;
    z-index: 9;
    margin-top: 5px;
}

.recaptcha-container {
    width: 100%;
}
</style>
