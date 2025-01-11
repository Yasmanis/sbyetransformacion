<template>
    <div class="q-gutter-md flex" v-if="$q.screen.gt.sm">
        <q-select
            v-model="currentColumn"
            dense
            options-dense
            :options="columns"
            label="columna"
            emit-value
            map-options
            option-value="name"
            hide-bottom-space
            :class="columns.length == 1 ? 'hidden' : ''"
            @update:model-value="onChangeSelect"
        />
        <q-select
            v-model="currentCondition"
            dense
            options-dense
            :options="conditions"
            :label="columns.length == 1 ? columns[0].label : 'condicion'"
            emit-value
            map-options
            hide-bottom-space
            style="min-width: 80px"
            @update:model-value="onChangeSelect"
        />
        <q-input
            bottom-slots
            v-model="currentQuery"
            :error="querySearchError"
            :error-message="querySearchMsg"
            label="frase"
            dense
            hide-bottom-space
            @keyup.enter="search"
            @update:model-value="onChangeQuery"
        >
            <template v-slot:append>
                <q-icon
                    v-if="$page.props.search"
                    name="close"
                    class="cursor-pointer"
                    @click="reset"
                >
                    <q-tooltip class="bg-brown">limpiar</q-tooltip>
                </q-icon>
            </template>
            <template v-slot:after>
                <q-btn-component
                    :round="false"
                    tooltips="buscar"
                    flat
                    dense
                    size="md"
                    icon="search"
                    @click="search"
                />
            </template>
        </q-input>
    </div>
    <q-btn-group v-else outline>
        <q-btn-component
            :round="false"
            tooltips="buscar"
            outline
            icon="search"
            size="md"
            @click="showDialog = true"
        />
        <q-btn
            color="brown"
            icon="close"
            v-if="$page.props.search"
            @click="reset"
        >
            <q-tooltip class="bg-brown">limpiar</q-tooltip>
        </q-btn>
    </q-btn-group>

    <q-dialog v-model="showDialog" @before-show="querySearchError = false">
        <q-card>
            <dialog-header-component
                icon="search"
                title="configuracion de busqueda"
                closable
            />
            <q-card-section class="q-gutter-md">
                <q-select
                    v-model="currentColumn"
                    dense
                    options-dense
                    :options="columns"
                    label="columna"
                    emit-value
                    map-options
                    style="min-width: 150px"
                    :class="columns.length == 1 ? 'hidden' : ''"
                    @update:model-value="onChangeSelect"
                />
                <q-select
                    v-model="currentCondition"
                    dense
                    options-dense
                    :options="conditions"
                    :label="
                        columns.length == 1 ? columns[0].label : 'condicion'
                    "
                    emit-value
                    map-options
                    style="min-width: 150px"
                    @update:model-value="onChangeSelect"
                />
                <q-input
                    v-model="currentQuery"
                    label="frase"
                    dense
                    style="min-width: 150px"
                    :error="querySearchError"
                    :error-message="querySearchMsg"
                    @keyup.enter="search"
                    @update:model-value="onChangeQuery"
                />
            </q-card-section>
            <q-card-actions align="right">
                <q-btn
                    flat
                    color="secondary"
                    label="buscar"
                    @click="search()"
                />
                <q-btn
                    flat
                    label="limpiar"
                    color="brown"
                    @click="reset"
                    v-if="searched"
                />
                <q-btn flat label="cerrar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, onBeforeMount, computed, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { useQuasar } from "quasar";
import { errorValidation } from "../../../helpers/notifications";
import { usePage } from "@inertiajs/vue3";
defineOptions({
    name: "SearchComponent",
});

const props = defineProps({
    fields: {
        type: Array,
        required: true,
        default: () => [],
    },
});

const $q = useQuasar();

const emit = defineEmits(["refresh-data"]);

const searched = ref(false);

const showDialog = ref(false);

const page = usePage();

const conditions = [
    {
        label: "igual",
        value: "=",
    },
    {
        label: "diferente",
        value: "!=",
    },
    {
        label: "comienza con",
        value: "start",
    },
    {
        label: "termina en",
        value: "end",
    },
    {
        label: "contiene",
        value: "like",
    },
    {
        label: "no contiene",
        value: "not like",
    },
];
const columns = ref([]);
const currentColumn = ref(null);
const currentCondition = ref({
    label: "contiene",
    value: "like",
});
const currentQuery = ref(null);

const querySearchError = ref(false);
const querySearchMsg = ref("requerido");

const searchProps = computed(() => {
    return page.props.search;
});

watch(searchProps, (n) => {
    setValuesOnLoad();
});

onBeforeMount(() => {
    columns.value = props.fields.map((f) => {
        return {
            label: f.label,
            value: f.name,
        };
    });
    setValuesOnLoad();
});

const initDefaultValue = () => {
    currentColumn.value = columns.value[0];
    currentQuery.value = null;
    querySearchError.value = false;
    currentCondition.value = {
        label: "contiene",
        value: "like",
    };
};

const setValuesOnLoad = () => {
    if (page.props.search) {
        const { column, condition, query } = page.props.search;
        currentColumn.value = columns.value.find((c) => c.value === column);
        console.log(query);
        currentQuery.value = query.toString().replaceAll("%", "");
        currentCondition.value = conditions.find((c) => c.value === condition);
    } else {
        initDefaultValue();
    }
};

const onChangeQuery = () => {
    querySearchError.value = false;
};

const onChangeSelect = () => {
    if (
        page.props.search &&
        currentQuery.value &&
        currentQuery.value.trim() !== ""
    ) {
        search();
    }
};

function search() {
    if (currentQuery.value && currentQuery.value.trim() !== "") {
        let c = currentCondition.value.value
            ? currentCondition.value.value
            : currentCondition.value;
        let q = currentQuery.value;
        if (c === "start") {
            c = "like";
            q = `${q}%`;
        } else if (c === "end") {
            c = "like";
            q = `%${q}`;
        } else if (c === "like" || c === "not like") {
            q = `%${q}%`;
        }
        emit("refresh-data", "search", {
            column: currentColumn.value.value
                ? currentColumn.value.value
                : currentColumn.value,
            condition: c,
            fullCondition: currentCondition.value,
            query: `${q}`,
        });
        searched.value = true;
    } else {
        querySearchError.value = true;
        errorValidation();
    }
}
function reset() {
    initDefaultValue();
    emit("refresh-data", "search");
}
</script>
