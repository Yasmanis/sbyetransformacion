<template>
    <q-card-section>
        <div class="text-subtitle2 text-center q-mt-sm">
            ingrese el token obtenido asi como su nueva contraseña
        </div>
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
                    (val) => !!val || 'el correo es requerido',
                    (val, rules) => rules.email(val) || 'correo no valido',
                ]"
                @keydown.enter.prevent="submit"
            >
                <template v-slot:prepend>
                    <q-icon name="email" />
                </template>
            </q-input>
            <q-input
                square
                clearable
                dense
                v-model="form.token"
                type="text"
                label="token"
                :error="errors.token !== undefined"
                :error-message="errors.token"
                :rules="[(val) => !!val || 'el token es requerido']"
                @keydown.enter.prevent="submit"
            >
                <template v-slot:prepend>
                    <q-icon name="key" />
                </template>
            </q-input>
            <q-input
                square
                clearable
                dense
                v-model="form.password"
                label="nueva contraseña"
                :type="isPwd ? 'password' : 'text'"
                :rules="[
                    (val) => !!val || 'la contraseña es requerida',
                    (val) => val.length >= 8 || 'minimo 8 caracteres',
                ]"
            >
                <template v-slot:append>
                    <q-icon
                        class="cursor-pointer"
                        :name="isPwd ? 'visibility_off' : 'visibility'"
                        @click="isPwd = !isPwd"
                    />
                </template>
                <template v-slot:prepend> <q-icon name="lock" /> </template
            ></q-input>

            <q-input
                square
                clearable
                dense
                v-model="form.password_confirmation"
                :type="isPwdConfirm ? 'password' : 'text'"
                label="confirmar contraseña"
                :rules="[
                    (val) => !!val || 'la confirmacion es requerida',
                    (val) =>
                        val === form.password || 'las contraseñas no coinciden',
                ]"
                @keydown.enter.prevent="submit"
            >
                <template v-slot:append>
                    <q-icon
                        class="cursor-pointer"
                        :name="isPwdConfirm ? 'visibility_off' : 'visibility'"
                        @click="isPwdConfirm = !isPwdConfirm"
                    />
                </template>
                <template v-slot:prepend> <q-icon name="lock" /> </template
            ></q-input>
        </q-form>
    </q-card-section>
    <q-card-section class="q-px-lg q-pt-none">
        <q-btn
            size="md"
            color="black"
            class="full-width text-white"
            label="restablecer contraseña"
            @click="submit"
        />
    </q-card-section>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "FormResetPasswordComponent",
});

const props = defineProps({
    email: String,
});

const emits = defineEmits(["reset", "cancel"]);

const form = useForm({
    email: null,
    password: null,
    password_confirmation: null,
    token: null,
});

const formRef = ref(null);

const isPwd = ref(true);
const isPwdConfirm = ref(true);

onMounted(() => {
    usePage().props.errors = {};
    form.email = props.email;
});

const submit = async () => {
    formRef.value.validate().then(async (success) => {
        if (success) {
            form.post("/reset-password", {
                onSuccess: (data) => {
                    if (Object.keys(data.props.errors).length === 0) {
                        emits("reset", form.email);
                    }
                },
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
