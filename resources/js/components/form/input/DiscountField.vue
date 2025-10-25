<template>
    <text-field
        :name="percentName"
        :label="percentLabel"
        :model-value="modelPercentValue"
        :others-props="{
            required: true,
        }"
        type="number"
        @update="onUpdateField"
    />
    <text-field
        :name="incomeName"
        :label="incomeLabel"
        :model-value="modelIncomeValue"
        :others-props="{
            required: true,
        }"
        type="number"
        class="q-mt-sm"
        @update="onUpdateField"
    />
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import TextField from "./TextField.vue";
import { error } from "../../../helpers/notifications";

defineOptions({
    name: "DiscountField",
});

const props = defineProps({
    percentLabel: {
        type: String,
        default: "porciento",
    },
    incomeLabel: {
        type: String,
        default: "importe",
    },
    percentName: {
        type: String,
        default: "percent",
    },
    incomeName: {
        type: String,
        default: "income",
    },
    percentValue: Number,
    incomeValue: Number,
    totalPrice: Number,
    dense: {
        type: Boolean,
        default: true,
    },
    clearable: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["update", "error"]);

const modelPercentValue = ref(0);
const modelIncomeValue = ref(0);

onMounted(() => {
    modelPercentValue.value = props.percentValue ?? null;
    modelIncomeValue.value = props.incomeValue ?? null;
});

watch(
    () => props.percentValue,
    (n) => {
        modelPercentValue.value = n ?? 0;
    }
);

watch(
    () => props.incomeValue,
    (n) => {
        modelIncomeValue.value = n ?? 0;
    }
);

const onUpdateField = (name, val) => {
    let percentVal = 0;
    let incomeVal = 0;
    let price = props.totalPrice ?? 0;
    if (name === props.percentName) {
        incomeVal = Math.round((val / 100) * price * 100) / 100;
        percentVal = val;
    } else {
        percentVal = Math.round((val / price) * 100 * 100) / 100;
        incomeVal = val;
    }
    if (incomeVal > price) {
        incomeVal = 0;
        percentVal = 0;
        error(
            `el importe no puede ser mayor que ${price} dado que es el precio actual del producto`
        );
    }
    emits(
        "update",
        props.percentName,
        percentVal > 0 ? parseFloat(percentVal) : 0
    );
    emits(
        "update",
        props.incomeName,
        incomeVal > 0 ? parseFloat(incomeVal) : 0
    );
};
</script>
