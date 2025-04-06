<template>
    <q-btn-component
        :class="
            filteredBy && filteredBy.length > 0 ? 'animated pulse infinite' : ''
        "
        tooltips="filtrar"
        icon="filter_alt"
        @click="showDialog = true"
    >
        <q-badge
            color="primary"
            floating
            transparent
            v-if="currentFilters.length > 0"
        >
            {{ currentFilters.length }}
        </q-badge>
    </q-btn-component>

    <q-dialog
        v-model="showDialog"
        position="right"
        full-height
        @before-show="onBeforeShow"
    >
        <q-card style="width: 320px">
            <dialog-header-component
                icon="filter_alt"
                title="filtrar"
                closable
            />
            <q-card-section>
                <div
                    class="row"
                    v-for="(f, index) in filters"
                    :key="`filter-${index}`"
                    style="padding-bottom: 10px"
                >
                    <select-field
                        :name="f.name"
                        :label="f.label"
                        :options="f.options"
                        :othersProps="f.othersProps"
                        :modelValue="f.value"
                        :filterable="f.filterable"
                        @update="onUpdate"
                        v-if="f.type === 'select'"
                    />
                    <state-field
                        :country="f.country"
                        :state="f.state"
                        @update="onUpdateState"
                        v-else-if="f.type === 'state'"
                    />
                    <hidden-field
                        :name="f.name"
                        :model-value="f.value"
                        @update="onUpdate"
                        v-else-if="f.type === 'hidden'"
                    />
                    <boolean-select-field
                        :name="f.name"
                        :label="f.label"
                        :modelValue="f.value"
                        @update="onUpdate"
                        v-else-if="f.type === 'boolean'"
                    />
                    <range-size
                        :name="f.name"
                        :label="f.label"
                        :modelValue="f.value"
                        :min="f.min"
                        :max="f.max"
                        :unitOfMeasurement="f.unitOfMeasurement"
                        @update="onUpdate"
                        v-else-if="f.type === 'range_size'"
                    />
                    <date-range-component
                        :name="f.name"
                        :label="f.label"
                        :modelValue="f.value"
                        @update="onUpdate"
                        v-else-if="f.type === 'date'"
                    />
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn
                    flat
                    label="limpiar"
                    color="brown"
                    @click="clear"
                    v-if="currentFilters.length > 0"
                />
                <q-btn flat label="cerrar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import SelectField from "../../form/input/SelectField.vue";
import StateField from "../../form/input/StateField.vue";
import HiddenField from "../../form/input/HiddenField.vue";
import BooleanSelectField from "../../form/input/BooleanSelectField.vue";
import RangeSize from "../../form/input/RangeSize.vue";
import DateRangeComponent from "../../form/input/DateRangeComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "FilterComponent",
});

const props = defineProps({
    fields: {
        type: Array,
        required: true,
        default: () => [],
    },
    filteredBy: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["refresh-data"]);

const page = usePage();

const showDialog = ref(false);

const filters = ref([]);

const currentFilters = computed(() => {
    return page.props.filters
        ? page.props.filters.filter((f) => f.name !== "id")
        : [];
});

const onBeforeShow = () => {
    filters.value = props.fields;
    if (currentFilters.value.length > 0) {
        filters.value.forEach((f) => {
            if (f.type === "hidden") {
                setExcludesValue(f);
            } else {
                let exist = currentFilters.value.find(
                    (ff) => ff.name === f.name
                );
                f.value = exist ? exist.value : null;
            }
        });
    } else {
        let state = filters.value.find((ff) => ff.type === "state");
        if (state) {
            state.country.modelValue = null;
            state.state.modelValue = null;
        }
    }
};

const setExcludesValue = (f) => {
    let state = filters.value.find((ff) => ff.type === "state");
    if (f.name === "country_id") {
        state.country.modelValue = f.value;
    } else if (f.name === "state_id") {
        state.state.modelValue = f.value;
    }
};

function clear() {
    filters.value.forEach((f) => {
        f.value = null;
    });
    emit("refresh-data", "filters");
}

const onUpdateState = (name, val, full) => {
    let current = filters.value.find((f) => f.name === name);
    current.value = val;
    if (val === null && name === "country_id") {
        filters.value.find((f) => f.name === "state_id").value = null;
        filters.value.find((ff) => ff.type === "state").state.modelValue = null;
    }
    setFilters();
};

const onUpdate = (name, val, full) => {
    let current = filters.value.find((f) => f.name === name);
    current["value"] = val
        ? current.type === "select"
            ? Array.isArray(val)
                ? val
                : [val]
            : val
        : null;
    if (current.type !== "hidden") {
        setFilters();
    }
};

const setFilters = () => {
    let currentFilters = filters.value.filter(
        (f) => f.value !== undefined && f.value !== null
    );
    if (currentFilters.length > 0) {
        currentFilters = currentFilters.map((f) => {
            return {
                name: f.name,
                type: f.type,
                value: f.value,
                scope: f.scope,
            };
        });
    }
    emit(
        "refresh-data",
        "filters",
        currentFilters.length > 0 ? currentFilters : null
    );
};
</script>
