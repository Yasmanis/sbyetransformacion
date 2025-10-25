<template>
    <q-list dense>
        <q-expansion-item
            group="somegroup"
            expand-separator
            v-for="(obj, indexObj) in subtitles"
            :key="`subtitle-${indexObj}`"
            :label="obj.name"
        >
            <template v-slot:header>
                <q-item-section>
                    <q-item-label lines="1">
                        {{ obj.name }}
                    </q-item-label>
                </q-item-section>

                <q-item-section avatar>
                    <q-btn
                        flat
                        padding="0px"
                        :icon="`img:${$page.props.public_path}images/icon/${
                            Dark.isActive ? 'white' : 'black'
                        }-edit.png`"
                        size="12px"
                        @click.stop="onEdit(obj)"
                        ><q-tooltip-component title="editar" class="bg-black"
                    /></q-btn>
                </q-item-section>
                <q-item-section avatar>
                    <q-btn
                        flat
                        padding="0px"
                        icon="mdi-trash-can-outline"
                        @click.stop="
                            () => {
                                currentSubtitle = obj;
                                confirm = true;
                            }
                        "
                        ><q-tooltip-component title="eliminar" class="bg-black"
                    /></q-btn>
                </q-item-section>
            </template>
            <q-card>
                <q-card-section>
                    <span v-html="obj.description"></span>
                </q-card-section>
            </q-card>
        </q-expansion-item>
    </q-list>
    <btn-add-component
        tooltips="añadir subtitulo"
        square
        @click="showDialog = true"
        style="border: 1px solid #000"
    />

    <q-dialog v-model="showDialog" persistent @show="onShow" @hide="onHide">
        <q-card class="scroll">
            <dialog-header-component
                :icon="currentSubtitle ? 'edit' : 'add'"
                :title="`${currentSubtitle ? 'editar' : 'adicionar'} subtitulo`"
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <q-card-section class="col q-pt-none">
                    <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                        <div class="form-field">
                            <text-field
                                label="nombre"
                                name="name"
                                :model-value="formData.name"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                        <div class="form-field">
                            <editor-field
                                label="descripcion"
                                name="description"
                                :model-value="formData.description"
                                :others-props="{
                                    required: true,
                                }"
                                @update="onUpdateField"
                            />
                        </div>
                    </q-form>
                </q-card-section>
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

    <confirm-component :show="confirm" @ok="remove" @hide="confirm = false" />
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import TextField from "./TextField.vue";
import EditorField from "./EditorField.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import { router, useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../../helpers/notifications";
import { Dark, is, uid } from "quasar";

defineOptions({
    name: "SubtitleField",
});

const props = defineProps({
    parent: Object,
    objects: {
        type: Array,
        default: [],
    },
    name: {
        type: String,
    },
    label: {
        type: String,
    },
});

const emits = defineEmits(["create", "remove"]);

const subtitles = ref([]);
const showDialog = ref(false);
const form = ref(null);
const formData = useForm({
    id: null,
    name: null,
    description: null,
    subtitlable_type: null,
    subtitlable_id: null,
});

const confirm = ref(false);
const currentSubtitle = ref(null);

onMounted(() => {
    subtitles.value = props.objects ?? [];
});

watch(
    () => props.objects,
    (n) => {
        subtitles.value = n;
    },
    {
        deep: true,
    }
);

const onShow = () => {
    formData.subtitlable_id = props.parent?.id ?? null;
    formData.subtitlable_type = props.parent?.type ?? null;
};

const onHide = () => {
    formData.name = null;
    formData.description = null;
    formData.id = null;
    currentSubtitle.value = null;
};

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const save = () => {
    form.value.validate().then((success) => {
        if (success) {
            if (props.parent?.id) {
                if (formData.id !== null) {
                    update();
                } else {
                    store();
                }
            } else {
                const {
                    id,
                    name,
                    description,
                    subtitlable_id,
                    subtitlable_type,
                } = formData;
                console.log(formData.data());

                if (id) {
                    const s = subtitles.value.find((ss) => ss.id === id);
                    s.name = name;
                    s.description = description;
                } else {
                    let s = {
                        id: uid(),
                        name,
                        description,
                        subtitlable_id,
                        subtitlable_type,
                    };
                    subtitles.value.push(s);
                }
                showDialog.value = false;
            }
        } else {
            errorValidation();
        }
    });
};

const store = async () => {
    formData.post("/admin/subtitles", {
        onSuccess: (data) => {
            subtitles.value.push(data.props.object);
            showDialog.value = false;
        },
    });
};

const update = async () => {
    formData.put(`/admin/subtitles/${formData.id}`, {
        onSuccess: (data) => {
            const subtitle = subtitles.value.find((s) => s.id === formData.id);
            Object.assign(subtitle, data.props.object);
            showDialog.value = false;
        },
    });
};

const onEdit = (obj) => {
    currentSubtitle.value = obj;
    formData.id = obj.id;
    formData.name = obj.name;
    formData.description = obj.description;
    formData.product_id = obj.product_id;
    showDialog.value = true;
};

const remove = async () => {
    const { id } = currentSubtitle.value;
    if (is.number(id)) {
        await router.delete(`/admin/subtitles/${id}`, {
            onSuccess: () => {
                subtitles.value = subtitles.value.filter((s) => s.id !== id);
                confirm.value = false;
            },
        });
    } else {
        const index = subtitles.value.findIndex((s) => s.id === id);
        subtitles.value.splice(index, 1);
        confirm.value = false;
    }
};
</script>
