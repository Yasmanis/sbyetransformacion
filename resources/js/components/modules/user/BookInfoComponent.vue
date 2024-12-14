<template>
    <btn-book-component
        :disabled="books.length === 0"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" full-width persistent>
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-book-open-page-variant-outline"
                title="informacion"
                closable
            />
            <q-card-section class="scroll q-pa-none">
                <q-table
                    row-key="id"
                    :columns="columns"
                    :rows="books"
                    hide-pagination
                >
                    <template v-slot:header="props">
                        <q-tr :props="props">
                            <q-th auto-width />
                            <q-th
                                v-for="col in props.cols"
                                :key="col.name"
                                :props="props"
                            >
                                {{ col.label }}
                            </q-th>
                        </q-tr>
                    </template>

                    <template v-slot:body="props">
                        <q-tr :props="props">
                            <q-td
                                auto-width
                                v-if="props.row.attachments.length > 0"
                            >
                                <q-btn-component
                                    size="sm"
                                    color="primary"
                                    round
                                    dense
                                    @click="props.expand = !props.expand"
                                    :icon="props.expand ? 'remove' : 'add'"
                                    :tooltips="
                                        props.expand
                                            ? 'ocultar adjuntos'
                                            : 'mostrar adjuntos'
                                    "
                                />
                            </q-td>
                            <q-td v-else />
                            <q-td
                                v-for="col in props.cols"
                                :key="col.name"
                                :props="props"
                            >
                                <template v-if="col.name === 'ticket'">
                                    <q-icon
                                        name="mdi-help-circle-outline"
                                        size="50px"
                                        v-if="col.value === null"
                                    />
                                    <q-img
                                        :src="
                                            col.value
                                                .substring(
                                                    col.value.lastIndexOf('.') +
                                                        1
                                                )
                                                .toLowerCase() === 'pdf'
                                                ? `${$page.props.public_path}images/icon/black-file.png`
                                                : `${$page.props.public_path}storage/${col.value}`
                                        "
                                        width="50px"
                                        height="50px"
                                        fit="fill"
                                        v-else
                                    />
                                </template>

                                <template v-else>
                                    {{ col.value }}
                                </template>
                            </q-td>
                        </q-tr>
                        <q-tr
                            v-show="props.expand"
                            :props="props"
                            no-hover
                            v-if="props.row.attachments.length > 0"
                        >
                            <q-td colspan="100%">
                                <div class="text-left">
                                    <q-list dense>
                                        <q-item
                                            v-for="(a, indexAttach) in props.row
                                                .attachments"
                                            :key="`attach-${indexAttach}`"
                                            clickable
                                            target="_blank"
                                            :href="`${$page.props.public_path}storage/${a.path}`"
                                        >
                                            <q-item-section>
                                                <q-item-label>
                                                    {{ a.name }}
                                                </q-item-label>
                                            </q-item-section>
                                        </q-item>
                                    </q-list>
                                </div>
                            </q-td>
                        </q-tr>
                    </template>
                </q-table>
            </q-card-section>
            <q-card-actions align="right">
                <lock-unlock-component
                    :object="object"
                    @success="showDialog = false"
                    v-if="has_edit"
                ></lock-unlock-component>
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnBookComponent from "../../btn/BtnBookComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import LockUnlockComponent from "./LockUnlockComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { date } from "quasar";
defineOptions({
    name: "BookInfoComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);

const columns = ref([
    {
        field: "ticket",
        name: "ticket",
        label: "ticket",
        align: "center",
    },
    {
        field: "msg_title",
        name: "msg_title",
        label: "titulo",
        align: "left",
        sortable: true,
    },
    {
        field: "message",
        name: "message",
        label: "mensaje",
        align: "left",
        sortable: true,
    },
    {
        field: "book_number",
        name: "book_number",
        label: "# pedido",
        align: "left",
        sortable: true,
    },
    {
        field: "book_date",
        name: "book_date",
        label: "fecha de compra",
        align: "left",
        sortable: true,
        format: (val) => {
            return val ? date.formatDate(val, "DD/MM/YYYY") : null;
        },
    },
    {
        field: "other_people",
        name: "other_people",
        label: "persona en ticket",
        align: "left",
        sortable: true,
    },
]);

const books = computed(() => {
    return props.object.books ?? [];
});
</script>
