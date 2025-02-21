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
                                                ? `${
                                                      $page.props.public_path
                                                  }images/icon/${
                                                      Dark.isActive
                                                          ? 'white'
                                                          : 'black'
                                                  }-file.png`
                                                : `${$page.props.public_path}storage/${col.value}`
                                        "
                                        img-class="cursor-pointer"
                                        width="50px"
                                        height="50px"
                                        fit="fill"
                                        @click="
                                            openTicket(
                                                `${$page.props.public_path}storage/${col.value}`
                                            )
                                        "
                                        v-else
                                        ><q-tooltip-component
                                            title="click para ampliar"
                                    /></q-img> </template
                                ><template
                                    v-else-if="col.name === 'book_volumes'"
                                >
                                    <book-volumes-component
                                        :object="props.row"
                                        :label="col.value"
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
import { computed, ref, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnBookComponent from "../../btn/BtnBookComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import LockUnlockComponent from "./LockUnlockComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BookVolumesComponent from "./BookVolumesComponent.vue";
import { openURL, Dark } from "quasar";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
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
        field: "book_date",
        name: "book_date",
        label: "fecha de compra",
        align: "left",
        sortable: true,
    },
    {
        field: "other_people",
        name: "other_people",
        label: "persona en ticket",
        align: "left",
        sortable: true,
    },
    {
        field: "book_volumes",
        name: "book_volumes",
        label: "tomo",
        align: "center",
        format: (val) => {
            if (!val) {
                return "...";
            }
            let v = "";
            val.forEach((vol) => {
                v += `${bookVolumes.value[vol]}, `;
            });
            return v.substring(0, v.lastIndexOf(","));
        },
    },
]);

const bookVolumes = ref({
    tomo_1: "I",
    tomo_2: "II",
    tomo_3: "III",
});
const bookVolume_1 = ref(false);
const bookVolume_2 = ref(false);
const bookVolume_3 = ref(false);

const books = computed(() => {
    props.object.books.forEach((b) => {
        bookVolume_1.value = b.book_volumes?.includes("tomo_1") ? true : false;
        bookVolume_2.value = b.book_volumes?.includes("tomo_2") ? true : false;
        bookVolume_3.value = b.book_volumes?.includes("tomo_3") ? true : false;
    });
    return props.object.books ?? [];
});

const openTicket = (url) => {
    openURL(url, undefined);
};
</script>
