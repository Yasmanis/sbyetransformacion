<template>
    <text-field dense readonly :name="name" :label="label" :model-value="model">
        <template #after
            ><q-icon
                name="colorize"
                class="cursor-pointer"
                @click="showDialog = true"
            />
        </template>
    </text-field>

    <q-dialog v-model="showDialog" persistent @show="onShowDialog">
        <q-card style="width: 300px; max-width: 40vw">
            <dialog-header-component
                icon="colorize"
                title="seleccione el color"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="height: 60vh" class="scroll">
                <q-color
                    v-model="model"
                    no-header
                    no-footer
                    class="q-mb-sm"
                    @update:model-value="onUpdateHex"
                ></q-color>

                <text-field
                    name="current"
                    :model-value="model"
                    @update="onUpdateHex"
                >
                    <template v-slot:before>
                        <q-btn
                            rounded
                            size="13px"
                            :style="{
                                background: model,
                                border: '1px solid #D9D9D9',
                            }"
                        ></q-btn>
                    </template>
                    <template v-slot:append>
                        <span style="font-size: 18px">Hex</span>
                    </template>
                </text-field>

                <div class="row q-col-gutter-md q-pt-md">
                    <div class="col">
                        <q-input
                            v-model="colorPickerR"
                            dense
                            outlined
                            @update:model-value="onUpdateRGB"
                        >
                            <template v-slot:append>
                                <span style="font-size: 18px">R</span>
                            </template>
                        </q-input>
                    </div>
                    <div class="col">
                        <q-input
                            v-model="colorPickerG"
                            dense
                            outlined
                            @update:model-value="onUpdateRGB"
                        >
                            <template v-slot:append>
                                <span style="font-size: 18px">G</span>
                            </template>
                        </q-input>
                    </div>
                    <div class="col">
                        <q-input
                            v-model="colorPickerB"
                            dense
                            outlined
                            @update:model-value="onUpdateRGB"
                        >
                            <template v-slot:append>
                                <span style="font-size: 18px">B</span>
                            </template>
                        </q-input>
                    </div>
                </div>
                <div class="row items-center q-mt-sm q-gutter-sm">
                    <div
                        class="col-2"
                        v-for="color in favoriteColors"
                        :key="color"
                        style="
                            padding-left: 0;
                            padding-right: 0;
                            padding-top: 5px;
                        "
                    >
                        <q-btn
                            round
                            size="11px"
                            :style="{
                                background: color,
                                border: '1px solid #D9D9D9',
                            }"
                            @click="model = color"
                        >
                            <q-icon
                                :color="luminance"
                                name="check"
                                v-if="color === model"
                            >
                            </q-icon>
                            <q-badge
                                floating
                                style="
                                    background-color: transparent;
                                    top: 20px;
                                    right: -17px;
                                "
                            >
                                <q-btn
                                    round
                                    flat
                                    size="11px"
                                    icon="mdi-trash-can-outline"
                                    color="black"
                                    padding="0px"
                                    @click.stop="deleteColor(color)"
                                >
                                    <q-tooltip-component title="quitar color"
                                /></q-btn>
                            </q-badge>
                        </q-btn>
                    </div>
                    <div class="col-2" v-if="favoriteColors.length < 10">
                        <btn-add-component
                            tooltips="adicionar color seleccionado"
                            @click="addColor"
                        />
                    </div>
                </div>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component
                    tooltips="aceptar"
                    @click="saveChanges"
                />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import TextField from "./TextField.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import { colors } from "quasar";
import { useForm, usePage } from "@inertiajs/vue3";
import { error, info } from "../../../helpers/notifications";

defineOptions({
    name: "ColorPickerField",
});

const props = defineProps({
    modelValue: String,
    name: String,
    label: String,
});

const emits = defineEmits(["change"]);

const showDialog = ref(false);
const model = ref(null);
const colorPickerR = ref("00");
const colorPickerG = ref("00");
const colorPickerB = ref("00");
const page = usePage();

const favoriteColors = computed(() => {
    return page.props.auth?.user?.configuration?.colors ?? [];
});

const luminance = computed(() => {
    const lum = model.value ? colors.luminosity(model.value) : null;
    return lum ? (lum > 0.5 ? "black" : "white") : null;
});

onMounted(() => {
    model.value = props.modelValue;
});

const onShowDialog = async () => {
    model.value = props.modelValue;
    await onUpdateHex();
};

const onUpdateHex = () => {
    const rgb = colors.hexToRgb(model.value);
    colorPickerR.value = rgb.r;
    colorPickerG.value = rgb.g;
    colorPickerB.value = rgb.b;
};

const onUpdateRGB = () => {
    try {
        model.value = colors.rgbToHex({
            r: colorPickerR.value,
            g: colorPickerG.value,
            b: colorPickerB.value,
        });
    } catch (e) {
        error("valor incorrecto; el rango admitido es de 0 a 255");
    }
};

const addColor = () => {
    let colors = favoriteColors.value;
    if (colors.length === 10) {
        info(
            "ha alcanzado el limite de colores permitidos; elimine al menos uno para poder adicionar otro",
        );
    } else {
        const newColor = model.value;
        if (!colors.includes(newColor)) {
            colors.push(newColor);
            saveColors(colors);
        } else {
            error("el color ya existe en la lista");
        }
    }
};

const deleteColor = (color) => {
    let colors = favoriteColors.value.filter((c) => c !== color);
    saveColors(colors);
};

const saveColors = async (colors) => {
    var form = new FormData();
    form.append("colors", JSON.stringify(colors));
    useForm({
        colors,
    }).post("/admin/users/save-colors");
};

const saveChanges = async () => {
    emits("change", props.name, model.value);
    showDialog.value = false;
};
</script>
