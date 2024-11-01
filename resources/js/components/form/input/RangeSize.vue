<template>
    <q-input
        v-model="model"
        :label="label"
        dense
        class="full-width"
        @click="showing = true"
    >
        <template v-slot:after>
            <q-select
                v-model="currentUnit"
                dense
                :options="units"
                @update:model-value="update"
            ></q-select>
            <q-btn-component
                round
                dense
                flat
                icon="edit"
                size="md"
                tooltips="valores"
            >
                <q-menu v-model="showing" style="width: 205px !important">
                    <q-form ref="form" greedy>
                        <q-card bordered class="my-card">
                            <q-card-section class="bg-primary text-white">
                                <div class="text-subtitle2">
                                    introduzca los valores
                                </div>
                            </q-card-section>

                            <q-card-section>
                                <q-input
                                    v-model="min"
                                    label="minimo"
                                    dense
                                    type="number"
                                    class="full-width"
                                    :rules="[
                                        (val) => !!val || 'requerido',
                                        (val) =>
                                            val >= 0 || 'debe ser mayor que 0',
                                        (val) =>
                                            val <= 1000 ||
                                            'debe ser menor que 1000',
                                    ]"
                                />
                                <q-input
                                    v-model="max"
                                    label="maximo"
                                    dense
                                    type="number"
                                    class="full-width"
                                    :rules="[
                                        (val) => !!val || 'requerido',
                                        (val) =>
                                            val >= 0 || 'debe ser mayor que 0',
                                        (val) =>
                                            val <= 1000 ||
                                            'debe ser menor que 1000',
                                    ]"
                                />
                            </q-card-section>
                            <q-card-actions>
                                <q-btn-group>
                                    <q-btn
                                        label="aceptar"
                                        icon="mdi-check"
                                        color="primary"
                                        no-caps
                                        @click="onAccept"
                                    />
                                    <q-btn
                                        label="cerrar"
                                        icon="mdi-close"
                                        no-caps
                                        color="brown-5"
                                        @click="showing = false"
                                    />
                                </q-btn-group>
                            </q-card-actions>
                        </q-card>
                    </q-form>
                </q-menu>
            </q-btn-component>
            <q-btn-component
                round
                dense
                flat
                icon="mdi-eraser"
                size="md"
                tooltips="limpiar"
                color="danger"
                @click="clear"
                v-if="model"
            />
        </template>
    </q-input>
</template>
<script setup>
import { onBeforeMount, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { errorValidation } from "../../../helpers/notifications";

defineOptions({
    name: "RangeSize",
});

const props = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});

const emits = defineEmits(["update"]);

const model = ref(null);

const min = ref(null);

const max = ref(null);

const showing = ref(false);

const form = ref(null);

const currentUnit = ref(null);

const units = ref([
    {
        label: "Tb",
        value: "tb",
    },
    {
        label: "Gb",
        value: "gb",
    },
    {
        label: "Mb",
        value: "mb",
    },
    {
        label: "Kb",
        value: "kb",
    },
    {
        label: "Bytes",
        value: "b",
    },
]);

onBeforeMount(() => {
    setDefaultValue();
});

watch(
    () => props.modelValue,
    (n, o) => {
        setDefaultValue();
    }
);

const setDefaultValue = () => {
    if (props.modelValue) {
        let v = props.modelValue;
        min.value = v.min;
        max.value = v.max;
        if (min.value && max.value) {
            model.value = `${min.value} - ${max.value}`;
        }
        currentUnit.value = v.unitOfMeasurement;
    } else {
        min.value = null;
        max.value = null;
        model.value = null;
        currentUnit.value = {
            label: "Mb",
            value: "mb",
        };
    }
};

const onAccept = () => {
    form.value.validate().then((success) => {
        if (success) {
            if (model.value !== `${min.value} - ${max.value}`) {
                model.value = `${min.value} - ${max.value}`;
                update();
            } else {
                showing.value = false;
            }
        } else {
            errorValidation();
        }
    });
};

const update = () => {
    if (model.value) {
        emits("update", props.name, {
            min: min.value,
            max: max.value,
            unitOfMeasurement: currentUnit.value,
            unitValue: valueFromUnit(currentUnit.value.value),
        });
    }
};

const clear = () => {
    model.value = null;
    min.value = null;
    max.value = null;
    currentUnit.value = {
        label: "Mb",
        value: "mb",
    };
    emits("update", props.name, null);
};

const valueFromUnit = (u) => {
    if (u === "tb") return 1024 * 1024 * 1024 * 1024;
    else if (u === "gb") return 1024 * 1024 * 1024;
    else if (u === "mb") return 1024 * 1024;
    else if (u === "kb") return 1024;
    return 1;
};
</script>
