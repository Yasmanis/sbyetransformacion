<template>
    <btn-edit-component
        :color="color"
        @click="showDialog = true"
        v-if="object"
    />
    <btn-note-component
        :disable="disable || notablesHasNotes.length === 0"
        @click="showDialog = true"
        v-else
    />
    <q-dialog v-model="showDialog" persistent @before-show="beforeShow">
        <q-card style="width: 400px; max-width: 50vw">
            <dialog-header-component
                icon="mdi-shape-square-rounded-plus"
                title="nota"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="scroll">
                <q-item
                    :style="{
                        background: formData.b_color,
                        'margin-bottom': '5px',
                        'padding-top': '15px',
                    }"
                >
                    <q-item-section
                        class="text-center q-pb-sm"
                        :style="{
                            color: formData.t_color,
                        }"
                    >
                        <q-item-label>vista previa</q-item-label>
                    </q-item-section>
                </q-item>
                <q-form class="q-col-gutter-sm q-mt-xs" ref="form" greedy>
                    <text-field
                        name="content"
                        label="contenido"
                        autogrow
                        :model-value="formData.content"
                        :others-props="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                    />
                    <color-picker-field
                        name="t_color"
                        label="color de texto"
                        :model-value="formData.t_color"
                        @change="(name, val) => (formData[name] = val)"
                    />
                    <color-picker-field
                        name="b_color"
                        label="color de fondo"
                        :model-value="formData.b_color"
                        @change="(name, val) => (formData[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnNoteComponent from "../../btn/BtnNoteComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import TextField from "../../form/input/TextField.vue";
import ColorPickerField from "../../form/input/ColorPickerField.vue";
import { useForm } from "@inertiajs/vue3";
defineOptions({
    name: "FormNoteComponent",
});

const props = defineProps({
    notables: {
        type: Array,
        default: [],
    },
    object: Object,
    model: {
        type: String,
        required: true,
    },
    disable: Boolean,
    color: String,
});

const emits = defineEmits(["created"]);

const showDialog = ref(false);
const form = ref(null);

const formData = useForm({
    content: null,
    t_color: "#fff",
    b_color: "#407492",
    model: null,
    notables: [],
});

const notablesHasNotes = computed(() => {
    return props.notables.filter((n) => !n.note);
});

const beforeShow = () => {
    let obj = props.object;
    formData.content = obj?.content ?? null;
    formData.t_color = obj?.t_color ?? "#fff";
    formData.b_color = obj?.b_color ?? "#407492";
    formData.model = props.model;
    formData.notables = notablesHasNotes.value.map((n) => n.id);
};

const save = async () => {
    form.value.validate().then((success) => {
        if (success) {
            if (props.object?.id) {
                update();
            } else {
                store();
            }
        } else {
            errorValidation();
        }
    });
};

const store = async () => {
    formData.post("/admin/notes", {
        onSuccess: () => {
            showDialog.value = false;
            emits("created");
        },
    });
};

const update = async () => {
    formData.put(`/admin/notes/${props.object.id}`, {
        onSuccess: () => {
            showDialog.value = false;
        },
    });
};
</script>
