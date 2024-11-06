<template>
    <div class="q-gutter-md flex" v-if="$q.screen.gt.sm">
        <q-select v-model="column" dense options-dense :options="fields" label="columna" emit-value map-options
            option-value="name" hide-bottom-space :class="fields.length == 1 ? 'hidden' : ''"
            @update:model-value="onChangeSelect" />
        <q-select v-model="condition" dense options-dense :options="conditions"
            :label="fields.length == 1 ? fields[0].label : 'condicion'" emit-value map-options hide-bottom-space
            style="min-width: 80px" @update:model-value="onChangeSelect" />
        <q-input bottom-slots v-model="query" :error="querySearchError" :error-message="querySearchMsg" label="frase" dense
            hide-bottom-space @keyup.enter="search" @update:model-value="onChangeQuery">
            <template v-slot:append>
                <q-icon v-if="$page.props.search" name="close" class="cursor-pointer" @click="reset">
                    <q-tooltip class="bg-brown">limpiar</q-tooltip>
                </q-icon>
            </template>
            <template v-slot:after>
                <q-btn-component :round="false" tooltips="buscar" flat dense size="md" icon="search" @click="search" />
            </template>
        </q-input>
    </div>
    <q-btn-group v-else outline>
        <q-btn-component :round="false" tooltips="buscar" outline icon="search" size="md" @click="showDialog = true" />
        <q-btn color="brown" icon="close" v-if="$page.props.search" @click="reset">
            <q-tooltip class="bg-brown">limpiar</q-tooltip>
        </q-btn>
    </q-btn-group>

    <q-dialog v-model="showDialog" @before-show="querySearchError = false">
        <q-card>
            <dialog-header-component icon="search" title="configuracion de busqueda" closable />
            <q-card-section class="q-gutter-md">
                <q-select v-model="column" dense options-dense :options="fields" label="columna" emit-value map-options
                    style="min-width: 150px" :class="fields.length == 1 ? 'hidden' : ''" />
                <q-select v-model="condition" dense options-dense :options="conditions"
                    :label="fields.length == 1 ? fields[0].label : 'condicion'" emit-value map-options
                    style="min-width: 150px" />
                <q-input v-model="query" label="frase" dense style="min-width: 150px" :error="querySearchError"
                    :error-message="querySearchMsg" @keyup.enter="search" @update:model-value="onChangeQuery" />
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat color="secondary" label="buscar" @click="search()" />
                <q-btn flat label="limpiar" color="brown" @click="reset" v-if="searched" />
                <q-btn flat label="cerrar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, onBeforeMount } from "vue";
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
const column = ref(null);
const condition = ref({
    label: "contiene",
    value: "like",
});

const query = ref(null);

const querySearchError = ref(false);
const querySearchMsg = ref("requerido");

onBeforeMount(() => {
    let search = page.props.search;
    if (search) {
        column.value = search.column;
        query.value = search.query.replaceAll("%", "");
        condition.value = search.fullCondition;
    } else {
        column.value = props.fields[0];
        condition.value = {
            label: "contiene",
            value: "like",
        };
        query.value = "";
    }
});

const onChangeQuery = () => {
    querySearchError.value = false;
};

const onChangeSelect = () => {
    if (page.props.search) {
        search();
    }
};

function search() {
    if (query.value && query.value.trim() !== "") {
        let c = condition.value.value ? condition.value.value : condition.value;
        let q = query.value;
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
            column: column.value.name,
            condition: c,
            fullCondition: condition.value,
            query: `${q}`,
        });
        searched.value = true;
    } else {
        querySearchError.value = true;
        errorValidation();
    }
}
function reset() {
    query.value = null;
    querySearchError.value = false;
    condition.value = {
        label: "contiene",
        value: "like",
    };
    emit("refresh-data", "search");
}
</script>
