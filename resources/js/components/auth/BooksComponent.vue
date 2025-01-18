<template>
    <div class="row">
        <template
            v-for="(b, indexB) in $page.props.books"
            :key="`book-volume-${indexB}`"
        >
            <div
                class="col-lg-4 col-md-4 col-sm-6 col-xs-12"
                :class="screen.xs ? '' : 'q-pa-sm'"
            >
                <q-card>
                    <q-card-section>
                        <q-list>
                            <q-item
                                v-for="(c, indexC) in columns"
                                :key="`column-${indexC}`"
                            >
                                <q-item-section>
                                    <q-item-label> {{ c.label }}</q-item-label>
                                    <q-item-label caption>
                                        {{
                                            b[c.name] ? b[c.name] : "..."
                                        }}</q-item-label
                                    >
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label> ticket</q-item-label>
                                </q-item-section>
                                <q-item-section avatar style="width: 160px">
                                    <q-img
                                        :src="`${$page.props.public_path}${
                                            b.ticket
                                                ? `storage/${b.ticket}`
                                                : 'images/icon/emoji-duda.jpg'
                                        }`"
                                        fit="fill"
                                    />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-card-section>
                    <q-separator />
                    <q-card-section>
                        <q-item>
                            <q-item-section>
                                <q-item-label> tomo asignado</q-item-label>
                                <q-item-label caption>
                                    {{
                                        getBookVolumes(b.book_volumes)
                                    }}</q-item-label
                                >
                            </q-item-section>
                        </q-item>
                    </q-card-section>
                </q-card>
            </div>
        </template>
    </div>
    <q-dialog
        v-model="showDialog"
        persistent
        position="right"
        full-hight
        @show="emits('show')"
        @hide="onHide"
    >
        <q-card class="scroll" style="max-width: 300px">
            <dialog-header-component
                icon="mdi-plus"
                title="nueva compra"
                closable
            />
            <q-card-section>
                <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                    <text-field
                        v-model="formData.msg_title"
                        name="msg_title"
                        label="titulo"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <text-field
                        v-model="formData.message"
                        name="message"
                        label="mensaje"
                        :others-props="{
                            required: true,
                        }"
                        type="textarea"
                        @update="onUpdateField"
                    />
                    <text-field
                        v-model="formData.book_number"
                        name="book_number"
                        label="numero de pedido"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <date-field
                        v-model="formData.book_date"
                        name="book_date"
                        label="fecha de compra"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                    />
                    <checkbox-field
                        v-model="iAmNot"
                        name="iAmNot"
                        label="la persona que aparece en el ticket no soy yo"
                        @update="(name, val) => (iAmNot = val)"
                    />
                    <text-field
                        v-model="formData.other_people"
                        name="other_people"
                        label="nombre de la persona"
                        :others-props="{
                            required: true,
                        }"
                        @update="onUpdateField"
                        v-if="iAmNot"
                    />
                    <image-field
                        v-model="formData.ticket"
                        height="100px"
                        name="ticket"
                        label="foto del ticket"
                        :others-props="{
                            required: true,
                            help: ['solo se aceptan imagenes'],
                        }"
                        :reset="formData.ticket == null"
                        @change="onUpdateField"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save(true)" />
                <btn-save-and-new-component @click="save(false)" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnSaveAndNewComponent from "../btn/BtnSaveAndNewComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import TextField from "../form/input/TextField.vue";
import ImageField from "../form/input/ImageField.vue";
import DateField from "../form/input/DateField.vue";
import CheckboxField from "../form/input/CheckboxField.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation, error } from "../../helpers/notifications";
import { useQuasar } from "quasar";
defineOptions({
    name: "BooksComponent",
});

const props = defineProps({
    newBook: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["show"]);

const $q = useQuasar();
const form = ref(null);
const iAmNot = ref(false);
const formData = useForm({
    book_number: null,
    book_date: null,
    msg_title: null,
    message: null,
    other_people: null,
    attachments: null,
    ticket: null,
});
const showDialog = ref(false);

const columns = ref([
    {
        name: "msg_title",
        label: "titulo",
    },
    {
        name: "message",
        label: "mensaje",
    },
    {
        name: "book_number",
        label: "# pedido",
    },
    {
        name: "book_date",
        label: "fecha de compra",
    },
    {
        name: "other_people",
        label: "persona en ticket",
    },
]);

const screen = computed(() => {
    return $q.screen;
});

watch(iAmNot, (n, o) => {
    formData.reset("other_people");
});

watch(
    () => props.newBook,
    (n, o) => {
        if (n) showDialog.value = true;
    }
);

const onUpdateField = (name, val) => {
    formData[name] = val;
};

const save = async (hide) => {
    form.value.validate().then((success) => {
        if (success) {
            if (formData.ticket === null) {
                error("debe especificar el ticket de la compra");
            } else {
                formData.post("/auth/store-new-book", {
                    onSuccess: () => {
                        if (hide) {
                            showDialog.value = false;
                        } else {
                            onHide();
                        }
                    },
                });
            }
        } else {
            errorValidation();
        }
    });
};

const getBookVolumes = (volumes) => {
    if (!volumes) return "...";
    return volumes.map((v) => v.substring(5)).toString();
};

const onHide = () => {
    formData.reset();
    form.value?.resetValidation();
    iAmNot.value = false;
};
</script>
