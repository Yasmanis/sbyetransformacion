<template>
    <btn-sort-component :tooltips="tooltips" @click="showDialog = true" />

    <q-dialog v-model="showDialog" persistent @before-show="onBeforeShow">
        <q-card style="width: 800px">
            <dialog-header-component
                icon="mdi-sort"
                :title="tooltips ? tooltips : 'ordenar'"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="scroll" style="max-height: 50vh">
                <draggable
                    v-model="list"
                    group="people"
                    @start="drag = true"
                    @end="drag = false"
                    item-key="id"
                    id="items"
                >
                    <template #item="{ element }">
                        <q-item class="cursor-pointer">
                            <q-item-section>
                                <q-item-label>
                                    {{ element.name }}
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar v-if="hasFixed">
                                <fixed-component
                                    :data="element"
                                    model="File"
                                    @reload="onBeforeShow"
                                />
                            </q-item-section>
                        </q-item>
                    </template>
                </draggable>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
            <q-inner-loading :showing="loading" color="primary" size="xs" />
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import BtnSortComponent from "../btn/BtnSortComponent.vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import BtnPinComponent from "../btn/BtnPinComponent.vue";
import FixedComponent from "./FixedComponent.vue";
import draggable from "vuedraggable";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { error } from "../../helpers/notifications.js";

defineOptions({
    name: "SortElementsComponent",
});

const props = defineProps({
    items: {
        type: Array,
        default: [],
    },
    tooltips: {
        type: String,
        default: "ordenar",
    },
    model: {
        type: String,
        required: true,
    },
    sortColumn: {
        type: String,
        default: "order",
    },
    sortedColumns: {
        type: Object,
        default: {
            order: "asc",
        },
    },
    hasFixed: Boolean,
    parentColumn: String,
    parentId: String | Number,
});

const emits = defineEmits(["save"]);

const showDialog = ref(false);
const loading = ref(false);

const list = ref([]);

const onBeforeShow = async () => {
    loading.value = true;
    await axios
        .post("/utils/sorted-elements", {
            modelName: props.model,
            sortedColumns: props.sortedColumns,
            parentId: props.parentId,
            parentColumn: props.parentColumn,
        })
        .then((d) => {
            let response = d.data;
            list.value = response.rows;
            if (!response.success) {
                error(response.message);
            }
        })
        .finally(() => {
            loading.value = false;
        });
};

const save = () => {
    let sorteds = {},
        index = 1;

    list.value.forEach((el) => {
        sorteds[el.id] = index;
        index++;
    });

    const send = useForm({
        modelName: props.model,
        sortColumn: props.sortColumn,
        sorteds: sorteds,
    });
    send.post("/utils/sort-elements", {
        onSuccess: () => {
            emits("save");
            showDialog.value = false;
        },
    });
};
</script>
<style scoped>
#items > li {
    padding: 10px;
    list-style: none;
    cursor: pointer;
}

#items > .q-item:hover {
    background-color: #cdcdcd;
}
</style>
