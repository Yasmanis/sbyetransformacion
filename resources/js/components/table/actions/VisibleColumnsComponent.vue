<template>
    <q-btn-component class="btn-show-hide-columns" tooltips="columnas"
        :icon="`img:${$page.props.public_path}images/icon/show-hide-columns.png`" v-if="fullVisibleColums.length > 0">
        <q-menu transition-show="scale" transition-hide="scale" :offset="[0, 5]">
            <q-list dense>
                <q-item clickable v-for="(c, index) in fullVisibleColums" :key="`visible-columns-${index}`"
                    @click="onChange(c)">
                    <q-item-section :class="c.checked ? 'text-primary' : ''">
                        <q-item-label class="text-lowercase">{{
                            c.label
                            }}</q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <q-icon name="check" size="xs" class="text-primary" v-if="c.checked"></q-icon>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-menu>
    </q-btn-component>
</template>

<script setup>
defineOptions({
    name: "VisibleColumnsComponent",
});

import { ref, onMounted, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";

const props = defineProps({
    columns: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const emit = defineEmits(["change"]);

const visibleColumns = ref([]);
const fullVisibleColums = ref([]);

onMounted(() => {
    fullVisibleColums.value = props.columns.filter(
        (c) => c.type !== "hidden" && !c.required
    );
    fullVisibleColums.value.forEach((c) => {
        c["checked"] = true;
    });
    visibleColumns.value = fullVisibleColums.value.map((c) => c.field);
});

const onChange = (c) => {
    c.checked = !c.checked;
    if (c.checked) {
        visibleColumns.value.push(c.name);
    } else {
        visibleColumns.value = visibleColumns.value.filter((v) => v !== c.name);
    }
    emit("change", visibleColumns.value);
};
</script>
<style>
.btn-show-hide-columns img {
    height: 14px !important;
    width: 14px !important;
}
</style>
