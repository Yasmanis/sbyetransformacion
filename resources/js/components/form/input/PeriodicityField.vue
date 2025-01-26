<template>
    <div class="row q-mb-sm">
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pr-sm' : ''"
        >
            <date-field
                v-model="startDate"
                :start-date="date.formatDate(new Date(), 'YYYY/MM/DD')"
                label="fecha y hora de inicio"
                name="start_date"
                time
                :othersProps="{ required: true }"
                @update="
                    (n, v) => {
                        startDate = v;
                        onUpdateField(n, v);
                    }
                "
            />
        </div>
        <div
            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
            :class="!screen.xs ? 'q-pl-sm' : ''"
        >
            <date-field
                v-model="endDate"
                label="fecha y hora de terminacion"
                name="end_date"
                time
                :start-date="
                    startDate
                        ? date.formatDate(
                              date.extractDate(startDate, 'DD/MM/YYYY'),
                              'YYYY/MM/DD'
                          )
                        : null
                "
                @update="
                    (n, v) => {
                        endDate = v;
                        onUpdateField(n, v);
                    }
                "
            />
        </div>
    </div>
    <checkbox-field
        label="periodicidad"
        name="hasPeriodicity"
        v-model="hasPeriodicity"
        @update="onUpdatePeriodicity"
    />
    <div class="row" v-if="hasPeriodicity">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <radio-group-field
                name="repeatTo"
                :options="[
                    {
                        label: 'diariamente',
                        value: 'day',
                    },
                    {
                        label: 'semanalmente',
                        value: 'week',
                    },
                    {
                        label: 'mensualmente',
                        value: 'month',
                    },
                ]"
                @update="onUpdateRepeatTo"
            />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <q-input
                dense
                type="number"
                v-model="repeatAlways"
                v-if="repeatTo === 'day'"
                ><template #before>
                    <span class="text-subtitle1">repetir cada:</span> </template
                ><template #after>
                    <span class="text-subtitle1">dias</span>
                </template></q-input
            >
            <div class="column" v-if="repeatTo === 'week'">
                <q-input type="number" v-model="repeatAlways" dense
                    ><template #before>
                        <span class="text-subtitle1"
                            >repetir cada:</span
                        > </template
                    ><template #after>
                        <span class="text-subtitle1">semanas en</span>
                    </template></q-input
                >
                <checkbox-group-field
                    dense
                    name="week_day"
                    :options="[
                        {
                            label: 'domingo',
                            value: '0',
                        },
                        {
                            label: 'lunes',
                            value: '1',
                        },
                        {
                            label: 'martes',
                            value: '2',
                        },
                        {
                            label: 'miercoles',
                            value: '3',
                        },
                        {
                            label: 'jueves',
                            value: '4',
                        },
                        {
                            label: 'viernes',
                            value: '5',
                        },
                        {
                            label: 'sabado',
                            value: '6',
                        },
                    ]"
                    @update="
                        (n, v) =>
                            (periodicity.week_days =
                                v && v.length > 0 ? v : null)
                    "
                />
            </div>
            <div class="column" v-if="repeatTo === 'month'">
                <select-field
                    label="meses"
                    name="months"
                    :options="months"
                    multiple
                    :filterable="false"
                    @update="
                        (n, v) =>
                            (periodicity.months = v && v.length > 0 ? v : null)
                    "
                    class="q-mb-md"
                />
                <radio-group-field
                    name="monthday"
                    inline
                    dense
                    :options="[
                        {
                            label: 'dias',
                            value: 'day',
                        },
                        {
                            label: 'el',
                            value: 'el',
                        },
                    ]"
                    @update="
                        (n, v) => {
                            monthday = v;
                            periodicity.week_days = null;
                            periodicity.days = null;
                        }
                    "
                />
                <select-field
                    name="days"
                    :options="days"
                    multiple
                    :filterable="false"
                    @update="
                        (n, v) =>
                            (periodicity.days = v && v.length > 0 ? v : null)
                    "
                    v-if="monthday === 'day'"
                />
                <div class="row q-mt-md" v-else-if="monthday === 'el'">
                    <div class="col">
                        <checkbox-group-field
                            name="days"
                            dense
                            :options="[
                                {
                                    label: 'primer',
                                    value: 0,
                                },
                                {
                                    label: 'segundo',
                                    value: 1,
                                },
                                {
                                    label: 'tercer',
                                    value: 2,
                                },
                                {
                                    label: 'cuarto',
                                    value: 3,
                                },
                                {
                                    label: 'ultimo',
                                    value: -1,
                                },
                            ]"
                            @update="
                                (n, v) =>
                                    (periodicity.days =
                                        v && v.length > 0 ? v : null)
                            "
                        />
                    </div>
                    <div class="col">
                        <checkbox-group-field
                            dense
                            name="week_days"
                            :options="[
                                {
                                    label: 'domingo',
                                    value: '0',
                                },
                                {
                                    label: 'lunes',
                                    value: '1',
                                },
                                {
                                    label: 'martes',
                                    value: '2',
                                },
                                {
                                    label: 'miercoles',
                                    value: '3',
                                },
                                {
                                    label: 'jueves',
                                    value: '4',
                                },
                                {
                                    label: 'viernes',
                                    value: '5',
                                },
                                {
                                    label: 'sabado',
                                    value: '6',
                                },
                            ]"
                            @update="
                                (n, v) =>
                                    (periodicity.week_days =
                                        v && v.length > 0 ? v : null)
                            "
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import DateField from "./DateField.vue";
import CheckboxField from "./CheckboxField.vue";
import SelectField from "./SelectField.vue";
import RadioGroupField from "./RadioGroupField.vue";
import CheckboxGroupField from "./CheckboxGroupField.vue";
import { useQuasar, date } from "quasar";

defineOptions({
    name: "PeriodicityField",
});

const $q = useQuasar();

const props = defineProps({
    name: {
        type: String,
        defaul: "periodicity",
    },
});

const emits = defineEmits(["update", "update-periodicity"]);

const hasPeriodicity = ref(false);
const startDate = ref(null);
const endDate = ref(null);
const repeatTo = ref(null);
const monthday = ref(null);
const repeatAlways = ref(null);
const periodicity = ref(null);

const months = ref([
    {
        label: "enero",
        value: 0,
    },
    {
        label: "febrero",
        value: 1,
    },
    {
        label: "marzo",
        value: 2,
    },
    {
        label: "abril",
        value: 3,
    },
    {
        label: "mayo",
        value: 4,
    },
    {
        label: "junio",
        value: 5,
    },
    {
        label: "julio",
        value: 6,
    },
    {
        label: "agosto",
        value: 7,
    },
    {
        label: "septiembre",
        value: 8,
    },
    {
        label: "octubre",
        value: 9,
    },
    {
        label: "noviembre",
        value: 10,
    },
    {
        label: "diciembre",
        value: 11,
    },
]);

const days = ref([]);

onMounted(() => {
    for (let i = 1; i <= 31; i++) {
        days.value.push({
            label: i < 10 ? `0${i}` : i,
            value: i,
        });
    }
    days.value.push({
        label: "ultimo",
        value: "last",
    });
});

const screen = computed(() => {
    return $q.screen;
});

const onUpdateField = (name, val) => {
    emits("update", name, val);
};

const initPeriodicity = (n) => {
    periodicity.value = n
        ? {
              repeat: n,
              every: null,
              days: null,
              months: null,
              week_days: null,
          }
        : null;
};

watch(repeatTo, (n) => {
    initPeriodicity(n);
});

watch(repeatAlways, (n) => {
    if (periodicity.value) {
        periodicity.value.every = n;
    }
});

watch(
    periodicity,
    (n) => {
        onUpdateField("periodicity", n);
    },
    {
        deep: true,
    }
);

const onUpdatePeriodicity = (name, value) => {
    repeatTo.value = null;
    hasPeriodicity.value = value;
};

const onUpdateRepeatTo = (name, value) => {
    repeatTo.value = value;
    monthday.value = null;
    repeatAlways.value = null;
};
</script>
