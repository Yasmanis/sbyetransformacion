<template>
    <q-input
        v-model="displayValue"
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="defaultError || errorMsg"
        :error-message="defaultError ? defaultError : errorMsg"
        readonly
        dense
        class="full-width"
        cleareable
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
    >
        <template #label v-if="label">
            {{ label }}
            <span class="text-red" v-if="othersProps?.required">*</span>
        </template>
        <template #hint v-if="fieldHelp?.length > 0">
            <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                <li
                    v-for="(h, index) in fieldHelp"
                    :key="`help-${index}`"
                    style="list-style: none"
                >
                    {{ h }}
                </li>
            </ul>
        </template>
        <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                    @before-show="onBeforeShowProxy"
                >
                    <q-date
                        v-model="proxy"
                        :today-btn="todayBtn"
                        :today-btn-label="todayBtn ? 'hoy' : null"
                        :options="options"
                    >
                        <div class="row items-center justify-end q-gutter-sm">
                            <q-btn-component
                                icon="check"
                                v-close-popup
                                :tooltips="$q.lang.label.ok"
                                @click="ok(proxy)"
                                v-if="proxy"
                            />
                            <q-btn-component
                                icon="mdi-calendar"
                                v-close-popup
                                tooltips="hoy"
                                @click="setNow"
                            />
                            <q-btn-component
                                icon="mdi-cancel"
                                color="brown-5"
                                :tooltips="$q.lang.label.cancel"
                                v-close-popup
                            />

                            <q-btn-component
                                icon="mdi-eraser"
                                color="red"
                                :tooltips="$q.lang.label.clear"
                                v-close-popup
                                @click="clear"
                                v-if="proxy"
                            />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-icon>
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, computed, watch, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";
import { date as useDate } from "quasar";

defineOptions({
    name: "DateField",
});

const props = defineProps({
    modelValue: {
        type: String,
        default: null,
    },
    startDate: String,
    endDate: String,
    startNow: {
        type: Boolean,
        default: false,
    },
    endNow: {
        type: Boolean,
        default: false,
    },
    todayBtn: {
        type: Boolean,
        default: true,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    defaultError: String,
    othersProps: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update"]);
const page = usePage();
const model = defineModel({
    type: String,
    default: null,
});
const proxy = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);

const { formatDate, extractDate } = useDate;

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

const displayValue = computed({
    get: () => toDisplay(model.value),
    set: (val) => {
        // Convierte a ISO (YYYY-MM-DD) para el modelo
        const iso = toISO(val);
        model.value = iso;
        // Actualiza el proxy con el formato que espera q-date
        proxy.value = toProxyFormat(iso);
    },
});

const toISO = (dateStr) => {
    if (!dateStr) return null;

    // 1. Si es YYYY/MM/DD (formato que devuelve q-date)
    if (/^\d{4}\/\d{2}\/\d{2}$/.test(dateStr)) {
        const [year, month, day] = dateStr.split("/").map(Number);
        const d = new Date(year, month - 1, day);
        if (!isNaN(d)) {
            return formatDate(d, "YYYY-MM-DD");
        }
    }

    // 2. Si ya es YYYY-MM-DD, validar y devolver
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
        const parts = dateStr.split("-").map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        if (!isNaN(d)) return dateStr;
    }

    // 3. Si es DD/MM/YYYY (entrada manual)
    if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr)) {
        const [day, month, year] = dateStr.split("/").map(Number);
        const d = new Date(year, month - 1, day);
        if (!isNaN(d)) {
            return formatDate(d, "YYYY-MM-DD");
        }
    }

    // 4. Fallback: intentar con extractDate para otros formatos
    const fallback = extractDate(dateStr);
    if (fallback && !isNaN(fallback)) {
        return formatDate(fallback, "YYYY-MM-DD");
    }

    return null;
};

const toDisplay = (iso) => {
    if (!iso) return null;

    // 1. MANEJO ESPECÍFICO PARA EL FORMATO DE LARAVEL: 2026-07-17T00:00:00.000000Z
    if (typeof iso === "string" && iso.includes("T") && iso.includes("Z")) {
        // Extraer solo la parte de la fecha (YYYY-MM-DD)
        const datePart = iso.split("T")[0];
        if (/^\d{4}-\d{2}-\d{2}$/.test(datePart)) {
            const parts = datePart.split("-").map(Number);
            const d = new Date(parts[0], parts[1] - 1, parts[2]);
            if (!isNaN(d)) {
                return formatDate(d, "DD/MM/YYYY");
            }
        }
    }

    // 2. Si es YYYY-MM-DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(iso)) {
        const parts = iso.split("-").map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 3. Si es YYYY/MM/DD
    if (/^\d{4}\/\d{2}\/\d{2}$/.test(iso)) {
        const parts = iso.split("/").map(Number);
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 4. Si es DD/MM/YYYY
    if (/^\d{2}\/\d{2}\/\d{4}$/.test(iso)) {
        const [day, month, year] = iso.split("/").map(Number);
        const d = new Date(year, month - 1, day);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    }

    // 5. Fallback con extractDate
    const fallback = extractDate(iso);
    if (fallback && !isNaN(fallback)) {
        return formatDate(fallback, "DD/MM/YYYY");
    }

    // 6. Último intento: crear Date directamente
    try {
        const d = new Date(iso);
        if (!isNaN(d)) {
            return formatDate(d, "DD/MM/YYYY");
        }
    } catch (e) {
        // Ignorar error
    }

    return null;
};

// Conversión para q-date (YYYY/MM/DD)
const toProxyFormat = (iso) => {
    if (!iso) return null;

    // Si ya está en formato YYYY/MM/DD, devolverlo
    if (/^\d{4}\/\d{2}\/\d{2}$/.test(iso)) {
        return iso;
    }

    // Si está en YYYY-MM-DD, convertirlo a YYYY/MM/DD
    if (/^\d{4}-\d{2}-\d{2}$/.test(iso)) {
        return iso.replace(/-/g, "/");
    }

    // Si es formato Laravel (2026-07-17T00:00:00.000000Z), extraer la fecha
    if (typeof iso === "string" && iso.includes("T") && iso.includes("Z")) {
        const datePart = iso.split("T")[0];
        if (/^\d{4}-\d{2}-\d{2}$/.test(datePart)) {
            return datePart.replace(/-/g, "/");
        }
    }

    // Intentar extraer la fecha de cualquier otro formato
    const date = extractDate(iso);
    if (date && !isNaN(date)) {
        return formatDate(date, "YYYY/MM/DD");
    }

    return null;
};

const options = (date) => {
    const today = formatDate(Date.now(), "YYYY/MM/DD");
    if (props?.startNow && props?.endNow) return date === today;
    if (props?.startNow) return date >= today;
    if (props?.endNow) return date <= today;
    if (props?.startDate && props?.endDate) {
        return date >= props.startDate && date <= props.endDate;
    }
    if (props?.startDate) return date >= props.startDate;
    if (props?.endDate) return date <= props.endDate;
    return true;
};

const onBeforeShowProxy = () => {
    proxy.value = toProxyFormat(model.value);
};

const setNow = () => {
    const now = formatDate(Date.now(), "YYYY/MM/DD");
    proxy.value = now;
    ok(now);
};

const ok = (val) => {
    // val viene en formato YYYY/MM/DD desde q-date
    const iso = toISO(val); // Esto convierte a YYYY-MM-DD
    model.value = iso; // El modelo siempre guarda YYYY-MM-DD
    // Guardamos en proxy el formato que espera q-date
    proxy.value = toProxyFormat(iso);
};

const clear = () => {
    proxy.value = null;
    model.value = null;
    emits("update", props.name, null);
};

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
