<template>
    <btn-sort-component
        :tooltips="tooltips"
        :disable="items.length === 0"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent @before-show="onBeforeShow">
        <q-card style="width: 800px">
            <dialog-header-component
                icon="mdi-sort"
                :title="tooltips ? tooltips : 'ordenar'"
                closable
            />
            <q-card-section>
                <draggable
                    v-model="list"
                    group="people"
                    @start="drag = true"
                    @end="drag = false"
                    item-key="id"
                    id="items"
                >
                    <template #item="{ element }">
                        <li>{{ element.name }}</li>
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
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import BtnSortComponent from "../btn/BtnSortComponent.vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import draggable from "vuedraggable";
import { useForm } from "@inertiajs/vue3";

defineOptions({
    name: "SortElementsComponent",
});

const props = defineProps({
    items: {
        type: Array,
        defaul: [],
    },
    tooltips: {
        type: String,
        default: "ordenar",
    },
    url: {
        type: String,
        required: true,
    },
});

const emits = defineEmits(["save"]);

const showDialog = ref(false);

const list = ref([]);

const onBeforeShow = () => {
    list.value = props.items;
};

const save = () => {
    let sorted = [];
    let index = 1;
    list.value.forEach((el) => {
        sorted.push({
            id: el.id,
            order: index,
        });
        index++;
    });
    const send = useForm({
        ids: JSON.stringify(sorted),
    });
    send.post(props.url, {
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

#items > li:hover {
    background-color: #cdcdcd;
}
</style>
