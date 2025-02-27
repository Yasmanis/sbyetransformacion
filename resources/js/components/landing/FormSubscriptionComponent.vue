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
                                v-model="form.conditions"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="acepto las condiciones y recibir tus newsletters"
                            />
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
                            <vue3-recaptcha
                                sitekey=""
                                @verify="
                                    (response) => (recaptchaResponse = response)
                                "
                                @expire="recaptchaResponse = null"
                            ></vue3-recaptcha>
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-card-actions class="q-pa-none">
                <q-btn
                    label="me apunto!"
                    rounded
                    color="black"
                    no-caps
                    class="q-mb-md"
                    @click="onSubmit"
                />
            </q-card-actions>
        </q-card>
    </div>

    <subscription-test :show="showTest" @hide="showTest = false" />
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
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
    conditions: false,
});

const onSubmit = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            if (!form.conditions) {
                error("debe especificar las condiciones");
            } /*else if (!recaptchaResponse.value) {
                error("debe especificar las condiciones");
            }*/ else {
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
                showTest.value = true;
                formRef.value.reset();
            }
        },
        onError: (errors) => {
            error500();
        },
    });
};
</script>
<style>
.q-checkbox__bg {
    border-radius: 10px;
    border-color: #fff;
}

.q-checkbox__icon-container i {
    font-size: 0.6em;
}

.q-checkbox__label {
    width: 100%;
}

.mdi-asterisk {
    opacity: 0.8;
    position: absolute;
    font-size: 12px;
    z-index: 9;
    margin-top: 5px;
}
</style>
