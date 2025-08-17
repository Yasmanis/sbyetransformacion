<template>
    <div class="row">
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pr-xs' : ''"
        >
            <date-field
                :name="startName"
                :label="startLabel"
                :modelValue="startDate"
                start-now
                :end-date="
                    endDate
                        ? date.formatDate(
                              date.extractDate(endDate, 'DD/MM/YYYY'),
                              'YYYY/MM/DD'
                          )
                        : null
                "
                :others-props="othersProps?.start ?? { required: true }"
                @update="onStartUpdate"
            />
        </div>
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pl-xs' : ''"
        >
            <date-field
                :name="endName"
                :label="endLabel"
                :modelValue="endDate"
                :start-date="
                    startDate
                        ? date.formatDate(
                              date.extractDate(startDate, 'DD/MM/YYYY'),
                              'YYYY/MM/DD'
                          )
                        : null
                "
                :others-props="othersProps?.end ?? { required: false }"
                @update="onEndUpdate"
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
    startValue: String,
    endValue: String,
    othersProps: Object,
});

const emits = defineEmits(["update"]);

const $q = useQuasar();

const startDate = ref(null);
const endDate = ref(null);

onMounted(() => {
    startDate.value = props.startValue ?? null;
    endDate.value = props.endValue ?? null;
});

watch(
    () => props.startValue,
    (n) => {
        startDate.value = n;
    }
);

watch(
    () => props.endValue,
    (n) => {
        endDate.value = n;
    }
);

const screen = computed(() => {
    return $q.screen;
});

const onStartUpdate = (name, val) => {
    startDate.value = val;
    onUpdateDates();
};

const onEndUpdate = (name, val) => {
    endDate.value = val;
    onUpdateDates();
};

const onUpdateDates = () => {
    if (startDate.value !== null && endDate.value !== null) {
        let s = date.extractDate(startDate.value, "DD/MM/YYYY");
        s = date.adjustDate(s, { hours: 23, seconds: 0, milliseconds: 0 });
        let e = date.extractDate(endDate.value, "DD/MM/YYYY");
        e = date.adjustDate(e, { hours: 23, seconds: 0, milliseconds: 0 });
        if (s > e) {
            endDate.value = null;
            error(
                `la ${props.startLabel} debe ser mayor o igual a la ${props.endLabel}`
            );
        }
    }
    emits("update", props.startName, startDate.value);
    emits("update", props.endName, endDate.value);
};
</script>
