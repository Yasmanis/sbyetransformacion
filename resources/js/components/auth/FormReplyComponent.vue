<template>
    <btn-reply-component :disable="!tiketId" @click="showDialog = true" />
    <q-dialog
        v-model="showDialog"
        persistent
        position="right"
        @before-show="onBeforeShow"
    >
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-reply-outline"
                title="responder"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <editor-field
                        name="description"
                        :othersProps="{ required: true }"
                        @update="(name, val) => (formData[name] = val)"
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
import { onMounted, ref } from "vue";
import BtnReplyComponent from "../btn/BtnReplyComponent.vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import EditorField from "../form/input/EditorField.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "FormReplyComponent",
});

const props = defineProps({
    tiketId: {
        type: Number,
        default: null,
    },
    target: {
        type: String,
        default: "tikets",
    },
});

const showDialog = ref(false);
const form = ref(null);
const formData = useForm({
    id: null,
    description: null,
    target: null,
});

const emits = defineEmits(["success"]);

onMounted(() => {});

const onBeforeShow = () => {
    formData.id = props.tiketId;
    formData.target = props.target;
};

const save = () => {
    form.value.validate().then((success) => {
        if (success) {
            formData.post("/admin/tikets/reply", {
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
