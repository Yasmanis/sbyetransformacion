<template>
    <q-btn-component
        label="alguna duda? preguntanos"
        class="full-width"
        :round="false"
        no-caps
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" @show="onShow">
        <q-card>
            <dialog-header-component
                icon="mdi-help"
                :title="`duda sobre ${product?.name ?? 'el producto'}`"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form ref="formRef" class="q-gutter-sm" greedy>
                    <text-field
                        name="name"
                        label="Nombre"
                        :model-value="formData.name"
                        :othersProps="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <text-field
                        name="surname"
                        label="Apellidos"
                        :model-value="formData.surname"
                        :othersProps="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <text-field
                        name="email"
                        label="Correo"
                        :model-value="formData.email"
                        :othersProps="{
                            type: 'email',
                            required: true,
                            help: [
                                'su duda sera respondida al correo que especifique',
                            ],
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <text-field
                        name="question"
                        label="Especifique su duda"
                        type="textarea"
                        :autogrow="true"
                        :model-value="formData.question"
                        :othersProps="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-card-actions align="right">
                <btn-send-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { onMounted, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "../../form/input/TextField.vue";
import BtnSendComponent from "../../btn/BtnSendComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { errorValidation } from "../../../helpers/notifications";
import { useForm, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "HelpQuestion",
});

const props = defineProps({
    product: Object,
});

const showDialog = ref(false);
const formRef = ref(null);

const formData = useForm({
    name: null,
    surname: null,
    email: null,
    question: null,
    product: props.product.id,
});

const onShow = () => {
    const user = usePage().props.auth?.user ?? null;
    if (user) {
        formData.name = user.name;
        formData.surname = user.surname;
        formData.email = user.email;
    }
};

const save = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            formData.post("/send-question", {
                onSuccess: (data) => {
                    if (data.props.flash_error === null) {
                        showDialog.value = false;
                        formData.reset();
                        formRef.value.resetValidation();
                    }
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
