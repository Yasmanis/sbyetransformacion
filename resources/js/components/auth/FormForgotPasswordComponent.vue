<template>
    <q-card-section v-if="!reset">
        <div class="text-h5 text-center">¿Olvidaste tu contraseña?</div>
        <div class="text-subtitle2 text-center q-mt-sm">
            ingrese su correo electronico y le enviaremos un token para
            restablecer su contraseña
        </div>
    </q-card-section>
    <q-card-section v-if="!reset">
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
                    (val) => !!val || 'el correo es requerido',
                    (val, rules) => rules.email(val) || 'correo no valido',
                ]"
                @keydown.enter.prevent="submit"
            >
                <template v-slot:prepend>
                    <q-icon name="email" />
                </template>
            </q-input>
        </q-form>
    </q-card-section>
    <q-card-section class="q-px-lg q-pt-none" v-if="!reset">
        <q-btn
            size="md"
            color="black"
            class="full-width text-white"
            label="enviar token"
            @click="submit"
        />
    </q-card-section>

    <q-card-section class="text-center q-pt-none cursor-pointer" v-if="!reset">
        <q-item-label class="text-primary" @click="reset = true"
            >ya tengo el token</q-item-label
        >
    </q-card-section>

    <form-reset-password-component
        :email="form.email"
        @reset="(val) => emits('reset', val)"
        v-if="reset"
    />
</template>

<script setup>
import { computed, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

import FormResetPasswordComponent from "./FormResetPasswordComponent.vue";

defineOptions({
    name: "FormForgotPasswordComponent",
});

const emits = defineEmits(["show", "reset", "cancel"]);

const form = useForm({
    email: null,
});

const reset = ref(false);

const formRef = ref(null);

const submit = async () => {
    formRef.value.validate().then(async (success) => {
        if (success) {
            form.post("/forgot-password", {
                onSuccess: (data) => {
                    if (
                        Object.keys(data.props.errors).length === 0 &&
                        data.props.flash_error === null
                    ) {
                        reset.value = true;
                    }
                },
                onError: () => {},
            });
        } else {
            errorValidation();
        }
    });
};

const errors = computed(() => {
    return usePage().props.errors;
});
</script>
