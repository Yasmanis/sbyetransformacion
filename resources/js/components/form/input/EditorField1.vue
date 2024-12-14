<template>
    <div class="column q-ml-none" v-if="label">
        <label>{{ label }}</label>
    </div>
    <q-editor
        v-model="model"
        ref="editorRef"
        :readonly="readonly"
        :max-height="maxHeight"
        :definitions="{
            image: {
                tip: 'subir imagen',
                icon: 'mdi-image-outline',
                handler: saveImage,
            },
            table: {
                tip: 'agregar tabla',
                icon: 'mdi-table',
                handler: saveImage,
            },
        }"
        :toolbar="[
            [
                {
                    icon: $q.iconSet.editor.font,
                    fixedIcon: true,
                    fixedLabel: true,
                    list: 'no-icons',
                    options: [
                        'default_font',
                        'arial',
                        'arial_black',
                        'comic_sans',
                        'courier_new',
                        'impact',
                        'lucida_grande',
                        'times_new_roman',
                        'verdana',
                    ],
                },
                {
                    icon: $q.iconSet.editor.formatting,
                    fixedLabel: true,
                    fixedIcon: true,
                    list: 'no-icons',
                    options: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'code'],
                },
                {
                    icon: $q.iconSet.editor.fontSize,
                    fixedLabel: true,
                    fixedIcon: true,
                    list: 'no-icons',
                    options: [
                        'size-1',
                        'size-2',
                        'size-3',
                        'size-4',
                        'size-5',
                        'size-6',
                        'size-7',
                    ],
                },
                'removeFormat',
            ],
            ['bold', 'italic', 'strike', 'underline'],
            ['subscript', 'superscript'],
            ['backcolor', 'forecolor'],
            [
                'unordered',
                'ordered',
                'outdent',
                'indent',
                {
                    icon: $q.iconSet.editor.align,
                    fixedLabel: true,
                    fixedLabel: true,
                    list: 'only-icons',
                    options: ['left', 'center', 'right', 'justify'],
                },
            ],
            ['quote', 'hr', 'link', 'image', 'table', 'emoji'],
            ['undo', 'redo'],
            ['print', 'fullscreen'],
        ]"
        :fonts="{
            arial: 'Arial',
            arial_black: 'Arial Black',
            comic_sans: 'Comic Sans MS',
            courier_new: 'Courier New',
            impact: 'Impact',
            lucida_grande: 'Lucida Grande',
            times_new_roman: 'Times New Roman',
            verdana: 'Verdana',
        }"
        @update:model-value="(val) => emits('update', name, val)"
    >
        <template v-slot:forecolor>
            <q-btn-dropdown dense ref="fColorRef" flat size="sm" icon="edit">
                <q-color
                    v-model="fColor"
                    default-view="palette"
                    no-header
                    no-footer
                    class="my-picker"
                    @update:model-value="foreColor"
                />
            </q-btn-dropdown>
        </template>
        <template v-slot:backcolor>
            <q-btn-dropdown
                dense
                ref="bColorRef"
                flat
                size="sm"
                icon="mdi-pencil-box"
                @before-hide="editorRef.focus()"
            >
                <q-color
                    v-model="bColor"
                    default-view="palette"
                    no-header
                    no-footer
                    class="my-picker"
                    @update:model-value="backColor"
                />
            </q-btn-dropdown>
        </template>
        <template v-slot:emoji>
            <emojis-component
                @selected="
                    (e) => {
                        editorRef.runCmd('insertText', e);
                    }
                "
            />
        </template>
    </q-editor>
    <div class="column help-editor q-ml-none" v-if="othersProps?.required">
        <span>requerido</span>
    </div>

    <q-file
        class="hidden"
        ref="fileRef"
        accept="image/*"
        @update:model-value="onImageChange"
    />

    <menu-image
        :target="targetImage"
        @change-position="setImagePosition"
        @show="onShowMenu"
        @hide="onHideMenu"
        v-if="targetImage"
    />

    <q-menu target="#btn-emoji" />
</template>

<script setup>
import { onBeforeMount, onMounted, ref, computed, watch } from "vue";
import MenuImage from "./editor/MenuImage.vue";
import EmojisComponent from "../../others/EmojisComponent.vue";

defineOptions({
    name: "EditorField",
});

const props = defineProps({
    label: String,
    modelValue: String,
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
    },
    saveBtn: {
        type: Boolean,
        default: false,
    },
    cancelBtn: {
        type: Boolean,
        default: false,
    },
    rows: {
        type: Number,
        default: 0,
    },
    othersProps: Object,
    readonly: {
        type: Boolean,
        default: false,
    },
    maxHeight: String,
});

const emits = defineEmits(["update", "save", "cancel"]);

const model = ref("");
const editorRef = ref(null);
const fileRef = ref(null);
const bColor = ref("#ffffff");
const bColorRef = ref(null);
const fColor = ref("#000000");
const fColorRef = ref(null);
const targetImage = ref(null);
const imageMenu = ref(false);
const propertiesImage = ref({});
const imageIndex = ref(0);
const imageSelected = ref(null);
const emojis = ref(null);

const width = ref(200);
const height = ref(200);
const isResizing = ref(false);
const startX = ref(0);
const startY = ref(0);

const saveImage = () => {
    fileRef.value.pickFiles();
};

const setImagePosition = (position) => {
    document.getElementById(
        targetImage.value.substring(1)
    ).parentNode.className = position;
};

const onImageChange = (f) => {
    const image = URL.createObjectURL(f);
    executeCmd(
        "insertHTML",
        `&nbsp;<div class="text-center"><img src="${image}" id="image-editor-${imageIndex.value}" class="image-editor resizable"/>&nbsp;</div>&nbsp;`
    );

    let img = document.getElementById(`image-editor-${imageIndex.value}`);
    img.addEventListener("click", function (ev) {
        targetImage.value = false;
        targetImage.value = `#${this.id}`;
        imageSelected.value = this.id;
    });
    //targetImage.value = `#image-editor-${imageIndex.value}`;
    imageIndex.value++;
};

const resize = (event) => {
    if (isResizing) {
        width.value += event.clientX - startX.value;
        height.value += event.clientY - startY.value;
        startX.value = event.clientX;
        startY.value = event.clientY;
    }
};
const stopResize = () => {
    isResizing.value = false;
    window.removeEventListener("mousemove", resize);
    window.removeEventListener("mouseup", stopResize);
};

const backColor = () => {
    bColorRef.value.hide();
    executeCmd("backColor", bColor.value);
};

const foreColor = () => {
    fColorRef.value.hide();
    executeCmd("foreColor", fColor.value);
};

const executeCmd = (cmd, val) => {
    const edit = editorRef.value;
    edit.caret.restore();
    edit.runCmd(cmd, val);
    edit.focus();
};

onBeforeMount(() => {
    setModelValue();
});

onMounted(() => {
    let images = document.getElementsByClassName("image-editor");
    for (let img of images) {
        img.addEventListener("click", function (ev) {
            targetImage.value = false;
            targetImage.value = `#${this.id}`;
            imageSelected.value = this.id;
        });
    }
});

watch(
    () => props.modelValue,
    (n, o) => {
        setModelValue();
    }
);

const setModelValue = async () => {
    model.value = props.modelValue ?? "";
};

const onHideMenu = () => {
    let el = document.getElementById(imageSelected.value);
    el.classList.remove("image-selected");
};

const onShowMenu = () => {
    let el = document.getElementById(imageSelected.value);
    console.log(el);

    el.classList.add("image-selected");
};
</script>
<style>
.q-btn-group .q-btn:eq(1) {
    padding: 0px !important;
}
.resizable {
    position: relative;
    border: 1px solid #ccc;
    cursor: nwse-resize; /* Cambia el cursor al redimensionar */
}
.image-editor:hover {
    border: 2px solid lightblue;
}
.image-selected {
    border: 2px solid cadetblue !important;
}
.q-btn-dropdown--current {
    padding-right: 0px !important;
    margin-right: 0px !important;
}
</style>
