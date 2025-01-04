<template>
    <div class="row" style="margin-top: 10px">
        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px">
            <q-select
                ref="modelRef"
                dense
                options-dense
                v-model="perPage"
                :options="optionsPerPage"
                @update:model-value="initPaginate"
                @popup-hide="onPopupHide"
                style="width: 50px !important; margin-top: -10px !important"
            >
            </q-select>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-8">
            <q-pagination
                v-model="pagination.current"
                :max="pagination.max"
                direction-links
                flat
                active-design="unelevated"
                size="13px"
                class="absolute-right"
                @update:model-value="onChangePage"
            ></q-pagination>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";

defineOptions({
    name: "PaginationComponent",
});

const props = defineProps({
    current_list: {
        type: Array,
        default: [],
    },
});

const emits = defineEmits(["change-paginate"]);

const modelRef = ref(null);
const lists = ref([]);
const pagination = ref({
    max: 1,
    current: 1,
});
const perPage = ref(5);
const optionsPerPage = ref([5, 10, 20, 30, 50, 100]);

onMounted(() => {
    lists.value = props.current_list;
    initPaginate();
});

watch(
    () => props.current_list,
    (n, o) => {
        lists.value = n;
        initPaginate();
    }
);
const initPaginate = () => {
    pagination.value = {
        current: 1,
        max:
            perPage.value === "todos"
                ? 1
                : lists.value.length > perPage.value
                ? lists.value.length % perPage.value === 0
                    ? lists.value.length / perPage.value
                    : lists.value.length / perPage.value + 1
                : 1,
    };
    onChangePage();
};
const onChangePage = () => {
    if (perPage.value === "todos") {
        emits("change-paginate", lists.value);
    } else {
        const { current } = pagination.value;
        const startIndex = (current - 1) * perPage.value;
        const endIndex = startIndex + perPage.value;
        emits("change-paginate", lists.value.slice(startIndex, endIndex));
    }
};
const onPopupHide = (ev) => {
    modelRef.value.blur();
};
</script>
