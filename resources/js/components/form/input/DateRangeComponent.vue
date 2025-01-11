<template>
    <q-input
        outlined
        dense
        v-model="date"
        readonly
        :label="label"
        clearable
        class="full-width"
    >
        <template v-slot:append>
            <q-btn-component
                icon="mdi-close-circle"
                style="opacity: 0.6"
                @click="clearSelection"
                v-if="date !== null"
            />
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                    ref="proxyRef"
                    @before-show="updateProxy"
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                >
                    <q-date v-model="proxyDate" range mask="DD/MM/YYYY">
                        <div class="row items-center justify-end q-gutter-sm">
                            <q-btn-component
                                icon="mdi-check-circle-outline"
                                tooltips="aceptar"
                                @click="save"
                            />

                            <btn-cancel-component
                                cancel
                                @click="proxyRef.hide()"
                            />

                            <btn-delete-component
                                @click="clearSelection"
                                v-if="date"
                            />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-icon>
        </template>
    </q-input>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { date as dateQuasar } from "quasar";
import BtnSaveAndNewComponent from "../../btn/BtnSaveAndNewComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import BtnClearComponent from "../../btn/BtnClearComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";

defineOptions({
    name: "DateRangeComponent",
});

const props = defineProps({
    name: String,
    label: String,
    modelValue: {
        type: Array,
        default: null,
    },
});

const emits = defineEmits(["update"]);
const date = ref(null);
const proxyDate = ref(null);
const proxyRef = ref(false);
onMounted(() => {
    if (props.modelValue && props.modelValue.length === 2) {
        date.value = `${normalizeDate(
            props.modelValue[0],
            "YYYY-MM-DD",
            "DD/MM/YYYY"
        )} - ${normalizeDate(props.modelValue[1], "YYYY-MM-DD", "DD/MM/YYYY")}`;
    }
});
watch(props, () => {
    if (!props.modelValue && date.value) {
        date.value = null;
        proxyDate.value = null;
    }
});
const updateProxy = () => {
    if (date && date.value) {
        const val = date.value.split(" - ");
        proxyDate.value =
            val[0] === val[1]
                ? date.value
                : {
                      from: val[0],
                      to: val[1],
                  };
    }
};
const clearSelection = () => {
    proxyDate.value = null;
    date.value = null;
    emits("update", props.name, null);
    proxyRef.value.hide();
};
const save = () => {
    if (proxyDate && proxyDate.value) {
        const { from, to } = proxyDate.value;
        date.value = from
            ? `${from} - ${to}`
            : `${proxyDate.value} - ${proxyDate.value}`;
        const temp = date.value.split(" - ");
        const dateToSend = [
            normalizeDate(temp[0], "DD/MM/YYYY", "YYYY-MM-DD"),
            normalizeDate(temp[1], "DD/MM/YYYY", "YYYY-MM-DD"),
        ];
        emits("update", props.name, dateToSend);
    } else {
        emits("update", props.name, null);
    }
    proxyRef.value.hide();
};
const normalizeDate = (d, currentFormat, outputFormat) => {
    const newDate = dateQuasar.extractDate(d, currentFormat);
    return dateQuasar.formatDate(newDate, outputFormat);
};
</script>
