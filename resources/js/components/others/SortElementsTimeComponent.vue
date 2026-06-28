<template>
    <q-btn-component :icon="icon" :tooltips="tooltips">
        <q-menu style="min-width: 220px">
            <q-list dense>
                <q-item clickable @click="save('asc')">
                    <q-item-section avatar>
                        <q-icon name="mdi-sort-clock-descending-outline" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label> ascendente </q-item-label>
                    </q-item-section>
                    <q-item-section avatar v-if="object[sortColumn] === 'asc'">
                        <q-icon name="mdi-check" />
                    </q-item-section>
                </q-item>
                <q-item clickable @click="save('desc')">
                    <q-item-section avatar>
                        <q-icon name="mdi-sort-clock-ascending-outline" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label> descendente </q-item-label>
                    </q-item-section>
                    <q-item-section avatar v-if="object[sortColumn] === 'desc'">
                        <q-icon name="mdi-check" />
                    </q-item-section>
                </q-item>
                <q-item clickable @click="save()">
                    <q-item-section avatar>
                        <q-icon name="mdi-sort-alphabetical-variant" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label> no definido </q-item-label>
                    </q-item-section>
                    <q-item-section avatar v-if="!object[sortColumn]">
                        <q-icon name="mdi-check" />
                    </q-item-section>
                </q-item>
            </q-list>
        </q-menu>
    </q-btn-component>
</template>

<script setup>
import { computed, ref } from "vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { error } from "../../helpers/notifications.js";

defineOptions({
    name: "SortElementsTimeComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
    tooltips: {
        type: String,
        default: "establecer orden",
    },
    model: {
        type: String,
        required: true,
    },
    sortColumn: {
        type: String,
        default: "order",
    },
});

const emits = defineEmits(["save"]);

const onBeforeShow = async () => {};

const icon = computed(() => {
    let sort = props.object[props.sortColumn];
    if (sort === "asc") return "mdi-sort-clock-ascending-outline";

    if (sort === "desc") return "mdi-sort-clock-descending-outline";
    return "mdi-sort-alphabetical-variant";
});

const save = (sorted = null) => {
    const send = useForm({
        modelName: props.model,
        sortColumn: props.sortColumn,
        modelId: props.object.id,
        sorted,
    });
    send.post("/utils/change-default-order-elements", {
        onSuccess: () => {
            emits("save");
        },
    });
};
</script>
