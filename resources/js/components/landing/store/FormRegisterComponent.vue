<template>
    <p class="text-center">
        ES LA PRIMERA VEZ <br />
        QUE CONTRATO EN SBYE DIETAPP
    </p>
    <q-btn
        label="INICIAR REGISTRO"
        color="primary"
        @click="showDialog = true"
    />
    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 900px; max-width: 90vw">
            <dialog-header-component
                closable
                title="acceso a sbye-transformacion para formalizar la compra"
            />
            <q-card-section>
                <q-form class="">
                    <div class="row q-gutter-md">
                        <div class="col">
                            <text-field
                                label="nombre"
                                :name="formData.name"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                label="apellidos"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <select-field
                                label="genero"
                                :name="formData.genre"
                                :filterable="false"
                                :options="[
                                    {
                                        label: 'Masculino',
                                        value: 'M',
                                    },
                                    {
                                        label: 'Femenino',
                                        value: 'F',
                                    },
                                ]"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <date-field
                                label="fecha de nacimiento"
                                :name="formData.birth_date"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-gutter-md">
                        <div class="col">
                            <text-field
                                label="localidad"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                label="pais"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                label="codigo postal"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-gutter-md">
                        <div class="col">
                            <text-field
                                label="tipo via"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                label="nombre via, numero, portal, piso, puerta"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-gutter-md">
                        <div class="col">
                            <text-field
                                label="telefono"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                label="email"
                                :name="formData.surname"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                    <div class="row q-gutter-md">
                        <div class="col">
                            <text-field
                                type="password"
                                label="contraseña"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                        <div class="col">
                            <text-field
                                type="password"
                                label="confirmar contraseña"
                                :others-props="{
                                    required: true,
                                }"
                            />
                        </div>
                    </div>
                </q-form>
            </q-card-section>
            <q-card-actions align="right" class="q-mb-sm">
                <btn-confirm-component tooltips="registrarme" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DateField from "../../form/input/DateField.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { useQuasar } from "quasar";
import { router, useForm, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "FormRegisterComponent",
});

const emits = defineEmits(["showing"]);

const formData = useForm({
    name: null,
    surname: null,
    genre: null,
    birth_date: null,
    country: null,
    postal_code: null,
    phone: null,
    email: null,
});

const screen = computed(() => {
    return useQuasar().screen;
});

const showDialog = ref(false);

const page = usePage();

onMounted(() => {
    if (!page.props.auth.user.subscripted && page.props.show_msg_subscription) {
        showDialog.value = true;
    }
});

const subscribe = () => {
    router.post(
        "/auth/subscribe",
        {},
        {
            onSuccess: () => (showDialog.value = false),
        }
    );
};
</script>
