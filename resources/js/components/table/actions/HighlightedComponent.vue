<template>
    <q-btn-component
        tooltips="resaltar"
        :icon="`img:${$page.props.public_path}images/icon/${
            Dark.isActive ? 'white' : 'black'
        }-highlight.png`"
        :size="size"
        :class="{
            'fa-beat': active,
        }"
        @click="active = !active"
    />
    <color-picker-field
        name="color"
        label="color de texto"
        :model-value="color"
        :has-input="false"
        :show="showPicker"
        default-view="palette"
        @change="save"
        @hide="emits('hide')"
    >
        <template #actions v-if="props.column?.highlighted?.bColor">
            <q-btn-component
                tooltips="quitar resaltado"
                :icon="`img:${$page.props.public_path}images/icon/${
                    Dark.isActive ? 'white' : 'black'
                }-highlighted-clear.png`"
                :size="size"
                @click="removeHighlighted"
            />
        </template>
    </color-picker-field>
</template>

<script setup>
import { ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import ColorPickerField from "../../form/input/ColorPickerField.vue";
import { useForm } from "@inertiajs/vue3";
import { colors, Dark } from "quasar";

defineOptions({
    name: "HighlightedComponent",
});

const props = defineProps({
    column: Object,
    show: Boolean,
    size: String,
    tooltips: {
        type: String,
        default: "resaltar",
    },
});

const emits = defineEmits(["created", "hide"]);

const showPicker = ref(false);
const active = ref(false);
const color = ref("#fff");

watch(
    () => props.show,
    (n) => {
        if (n && (active.value || props.column.highlighted)) {
            color.value = props.column.highlighted?.bColor ?? "#fff";
            showPicker.value = true;
        } else {
            showPicker.value = false;
            emits("hide");
        }
    },
);

const save = async (name, color) => {
    const lum = colors.luminosity(color);
    const send = useForm({
        highlight: {
            bColor: color,
            tColor: lum ? (lum > 0.5 ? "black" : "white") : "black",
        },
        ...props.column,
    });
    send.post("/utils/highlight");
};

const removeHighlighted = async () => {
    const send = useForm({
        ...props.column,
    });
    send.post("/utils/remove-highlighted", {
        onSuccess: () => {
            showPicker.value = false;
        },
    });
};
</script>
