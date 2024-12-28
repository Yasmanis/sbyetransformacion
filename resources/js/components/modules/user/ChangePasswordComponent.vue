<template>
    <q-btn-component
        tooltips="cambiar contraseña"
        icon="mdi-account-key-outline"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent position="right">
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-account-key-outline"
                title="cambiar contraseña"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <password-field
                        label="nueva contraseña"
                        name="password"
                        :othersProps="{ required: true }"
                        @update="onUpdateField"
                        @confirm="onUpdateField"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import PasswordField from "../../form/input/PasswordField.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../../helpers/notifications";
defineOptions({
    name: "ChangePasswordComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});

const showDialog = ref(false);
const form = ref(null);
const data = useForm({
    password: null,
});

const emits = defineEmits(["success"]);

const onUpdateField = (name, val) => {
    data.password = val;
};

const save = () => {
    form.value.validate().then((success) => {
        if (success) {
            data.post(`/admin/users/change-password/${props.object.id}`, {
                onSuccess: () => {
                    showDialog.value = false;
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
