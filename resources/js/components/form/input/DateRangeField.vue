<template>
    <div class="row">
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pr-xs' : ''"
        >
            <date-field
                :name="startName"
                :label="startLabel"
                v-model="startDate"
                start-now
                :end-date="maxStartDate"
                :others-props="othersProps?.start ?? { required: true }"
            />
        </div>
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pl-xs' : ''"
        >
            <date-field
                :name="endName"
                :label="endLabel"
                v-model="endDate"
                :start-date="minEndDate"
                :others-props="othersProps?.end ?? { required: false }"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
import { date } from "quasar";
import DateField from "./DateField.vue";
import { useQuasar } from "quasar";
import { error } from "../../../helpers/notifications";
import { start } from "nprogress";

defineOptions({
    name: "DateRangeField",
});

const props = defineProps({
    startName: {
        type: String,
        default: "start_at",
    },
    endName: {
        type: String,
        default: "end_at",
    },
    startLabel: {
        type: String,
        default: "inicio",
    },
    endLabel: {
        type: String,
        default: "fin",
    },
    othersProps: Object,
});

const emits = defineEmits(["update"]);

const $q = useQuasar();

const startDate = defineModel("start");
const endDate = defineModel("end");

const screen = computed(() => {
    return $q.screen;
});

const minEndDate = computed(() => startDate.value || null);

// Limita el selector de la fecha inicial para que no sea mayor a endDate
const maxStartDate = computed(() => endDate.value || null);

const onUpdateDates = () => {
    if (startDate.value !== null && endDate.value !== null) {
        let s = date.extractDate(startDate.value, "DD/MM/YYYY");
        s = date.adjustDate(s, { hours: 23, seconds: 0, milliseconds: 0 });
        let e = date.extractDate(endDate.value, "DD/MM/YYYY");
        e = date.adjustDate(e, { hours: 23, seconds: 0, milliseconds: 0 });
        if (s > e) {
            endDate.value = null;
            error(
                `la ${props.startLabel} debe ser mayor o igual a la ${props.endLabel}`,
            );
        }
    }
    emits("update", props.startName, startDate.value);
    emits("update", props.endName, endDate.value);
};
</script>
