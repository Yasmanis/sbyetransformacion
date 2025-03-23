<template>
    <q-card flat>
        <q-card-section class="no-padding">
            <q-tabs
                v-model="tab"
                no-caps
                inline-label
                :class="Dark.isActive ? '' : 'bg-white text-primary'"
                align="justify"
            >
                <q-tab
                    name="comments"
                    icon="mdi-comment-processing-outline"
                    label="comentarios"
                    ><q-badge floating v-if="comments.length > 0">{{
                        comments.length
                    }}</q-badge></q-tab
                >
                <q-tab
                    name="react"
                    icon="mdi-emoticon-happy-outline"
                    label="reacciones"
                    ><q-badge floating v-if="reacts.length > 0">{{
                        reacts.length
                    }}</q-badge></q-tab
                >
                <q-tab
                    name="highligth"
                    icon="mdi-star-outline"
                    label="destacados"
                    ><q-badge floating v-if="highligths.length > 0">{{
                        highligths.length
                    }}</q-badge></q-tab
                >
            </q-tabs>
            <q-separator />
            <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="comments">
                    <q-table
                        dense
                        :columns="columns"
                        :rows="comments"
                        rows-per-page-label="filas por pagina"
                        :rows-per-page-options="[20, 30, 50, 100, 0]"
                        flat
                        wrap-cells
                    >
                        <template #body-cell-message="props">
                            <td class="text-left">
                                <span v-html="props.row.message"></span>
                            </td>
                        </template>
                        <template #body-cell-actions="props">
                            <td class="text-right">
                                <btn-go-component
                                    tooltips="ir al chat"
                                    :href="`/admin/${props.row.segment}#chat-${props.row.id}-${props.row.topic_id}-${props.row.section_id}`"
                                />
                            </td>
                        </template>
                    </q-table>
                </q-tab-panel>
                <q-tab-panel name="react">
                    <q-table
                        dense
                        :columns="columns"
                        :rows="reacts"
                        flat
                        wrap-cells
                    >
                    </q-table>
                </q-tab-panel>
                <q-tab-panel name="highligth">
                    <q-table
                        dense
                        :columns="columns"
                        :rows="highligths"
                        flat
                        wrap-cells
                    >
                    </q-table>
                </q-tab-panel>
            </q-tab-panels>

            <q-inner-loading :showing="showLoading" />
        </q-card-section>
    </q-card>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { Dark } from "quasar";
import BtnGoComponent from "../../btn/BtnGoComponent.vue";

defineOptions({
    name: "CommentsComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});

const tab = ref("comments");

const columns = ref([
    {
        name: "message",
        field: "message",
        label: "mensaje",
        align: "left",
    },
    {
        name: "topic_str",
        field: "topic_str",
        label: "tema",
        align: "left",
    },
    {
        name: "section_str",
        field: "section_str",
        label: "seccion",
        align: "left",
    },
    {
        name: "segment",
        field: "segment",
        label: "panel",
        align: "left",
        format: (val) => {
            return panels[val];
        },
    },
    {
        name: "reply_to_msg",
        field: "reply_to_msg",
        label: "respuesta a",
        align: "left",
        format: (val, row) => {
            return val ? `${val} (enviado por ${row.reply_to_user})` : "";
        },
    },
    {
        name: "created_str",
        field: "created_str",
        label: "fecha",
        align: "left",
    },
    {
        name: "actions",
        field: "actions",
        label: "",
        align: "right",
    },
]);

const comments = ref([]);
const reacts = ref([]);
const highligths = ref([]);
const panels = {
    school: "vivir en plenitud",
    conference: "conferencias",
    posts: "posts",
    newsletters: "newsletters",
    learning: "aprender a liberar",
};

const showLoading = ref(false);

onMounted(() => {
    loadComments();
});

const loadComments = async () => {
    showLoading.value = true;
    await axios
        .post(`/admin/users/comments/${props.object.id}`)
        .then((response) => {
            comments.value = response.data.comments;
            reacts.value = response.data.reacts;
            highligths.value = response.data.highligths;
        })
        .finally(() => {
            showLoading.value = false;
        });
};
</script>
