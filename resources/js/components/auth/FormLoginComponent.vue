<template>
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
                dense
                clearable
                v-model="form.password"
                :type="isPwd ? 'password' : 'text'"
                label="contrase&ntilde;a"
                :error="errors.password !== undefined"
                :error-message="errors.password"
                :rules="[
                    (val) =>
                        (val && val.length > 0) || 'la contraseña es requerido',
                ]"
                @keydown.enter.prevent="submit"
            >
                <template v-slot:append>
                    <q-icon
                        class="cursor-pointer"
                        :name="isPwd ? 'visibility_off' : 'visibility'"
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
    <q-card-section class="q-px-lg q-pt-none">
        <q-btn
            size="md"
            color="black"
            class="full-width text-white"
            label="acceder"
            @click="submit"
        />
    </q-card-section>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "FormLoginComponent",
});

const props = defineProps({
    email: String,
});

const emits = defineEmits(["show", "cancel"]);

const form = useForm({
    email: null,
    password: null,
    rememberme: false,
});

const formRef = ref(null);

const isPwd = ref(true);

onMounted(() => {
    usePage().props.errors = {};
    form.email = props.email;
});

const submit = async () => {
    formRef.value.validate().then(async (success) => {
        if (success) {
            form.post("/authenticate");
        } else {
            errorValidation();
        }
    });
};

const errors = computed(() => {
    return usePage().props.errors;
});
</script>
