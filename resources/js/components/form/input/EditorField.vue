<template>
    <div class="column q-ml-none" v-if="label">
        <label>{{ label }}</label>
    </div>
    <ckeditor
        v-model="model"
        :editor="editorProps.editor"
        :config="editorProps.config"
        :style="{
            height: height,
            width: '100% !important',
        }"
        @ready="onReady"
        @input="onEditorInput"
    />
    <div
        class="column help-editor q-ml-none"
        v-if="othersProps?.required && !errorMsg && !modelRef?.hasError"
    >
        <span>requerido</span>
    </div>

    <q-item-label
        class="q-field--error"
        v-if="errorMsg"
        style="margin-left: -12px; margin-top: 0px"
    >
        <div class="q-field__bottom row items-start q-field__bottom--stale">
            <div class="q-field__messages col">
                <div role="alert">{{ errorMsg }}</div>
            </div>
        </div>
    </q-item-label>

    <q-item-label
        class="q-field--error"
        v-if="modelRef?.hasError"
        style="margin-left: -12px; margin-top: 0px"
    >
        <div class="q-field__bottom row items-start q-field__bottom--stale">
            <div class="q-field__messages col">
                <div role="alert">requerido</div>
            </div>
        </div>
    </q-item-label>

    <emojis-menu-component
        :target="targetEmojis"
        @hide="targetEmojis = null"
        @selected="inserText"
        v-if="targetEmojis"
    />

    <q-input
        v-model="model"
        ref="modelRef"
        :name="props.name"
        :rules="fieldRules"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        type="textarea"
        lazy-rules
        reactive-rules
        class="hidden"
    ></q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch, computed } from "vue";
import { validations } from "../../../helpers/validations";
import {
    ClassicEditor,
    Autoformat,
    Bold,
    Italic,
    Underline,
    BlockQuote,
    Base64UploadAdapter,
    CloudServices,
    Essentials,
    Heading,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    PictureEditing,
    Indent,
    IndentBlock,
    Link,
    List,
    MediaEmbed,
    Mention,
    Paragraph,
    PasteFromOffice,
    Table,
    TableColumnResize,
    TableToolbar,
    TextTransformation,
    LinkImage,
    Font,
    ButtonView,
    Plugin,
    Alignment,
    HorizontalLine,
} from "ckeditor5";
import "ckeditor5/ckeditor5.css";
import coreTranslations from "ckeditor5/translations/es.js";
import EmojisMenuComponent from "./editor/EmojisMenuComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "EditorField",
});

const props = defineProps({
    label: String,
    modelValue: String,
    height: String,
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
    autoHeight: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["update", "save", "cancel"]);
const page = usePage();
const model = ref("");
const modelRef = ref(null);
const defaultValue = ref(null);
const targetEmojis = ref(null);
const editorInstance = ref(null);
const fieldRules = ref([]);

class SaveBtn extends Plugin {
    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add("save-btn", () => {
            const button = new ButtonView();
            button.set({
                label: "guardar",
                icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM272 80v80H144V80h128zm122 352H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h42v104c0 13.255 10.745 24 24 24h176c13.255 0 24-10.745 24-24V83.882l78.243 78.243a6 6 0 0 1 1.757 4.243V426a6 6 0 0 1-6 6zM224 232c-48.523 0-88 39.477-88 88s39.477 88 88 88 88-39.477 88-88-39.477-88-88-88zm0 128c-22.056 0-40-17.944-40-40s17.944-40 40-40 40 17.944 40 40-17.944 40-40 40z"/></svg>',
                tooltip: true,
            });
            button.on("execute", () => {
                emits("save", props.name, model.value);
            });
            return props.saveBtn ? button : null;
        });

        editor.ui.componentFactory.add("cancel-btn", () => {
            const button = new ButtonView();
            button.set({
                label: "cancelar",
                icon: '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.881px" height="122.88px" viewBox="0 0 122.881 122.88" enable-background="new 0 0 122.881 122.88" xml:space="preserve"><g><path d="M61.44,0c16.966,0,32.326,6.877,43.444,17.996s17.996,26.479,17.996,43.445c0,16.966-6.878,32.325-17.996,43.444 C93.767,116.003,78.406,122.88,61.44,122.88s-32.326-6.877-43.444-17.995C6.877,93.766,0,78.406,0,61.44 c0-16.966,6.877-32.326,17.996-43.445C29.114,6.877,44.475,0,61.44,0L61.44,0z M103.653,27.788l-75.865,75.864 c9.229,7.367,20.926,11.771,33.652,11.771c14.907,0,28.403-6.043,38.172-15.812s15.812-23.265,15.812-38.172 C115.424,48.713,111.02,37.016,103.653,27.788L103.653,27.788z M22.289,98.607l76.318-76.318 C88.929,13.098,75.844,7.457,61.44,7.457c-14.908,0-28.404,6.042-38.172,15.811C13.5,33.036,7.457,46.532,7.457,61.44 C7.457,75.843,13.098,88.928,22.289,98.607L22.289,98.607z"/></g></svg>',
                tooltip: true,
            });
            button.on("execute", () => {
                let val = defaultValue.value;
                model.value = val;
                emits("cancel", props.name, val);
            });
            return props.cancelBtn ? button : null;
        });

        editor.ui.componentFactory.add("emoji-btn", () => {
            const button = new ButtonView();
            button.set({
                label: "insertar emoji",
                class: `btn-${props.name}`,
                icon: `<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88"><path d="M45.54,2.1A61.48,61.48,0,1,1,8.25,30.74,61.26,61.26,0,0,1,45.54,2.1ZM30.61,70.3a38,38,0,0,0,8.34,8,40.39,40.39,0,0,0,23.58,7.1A38.05,38.05,0,0,0,85.3,77.68a33.56,33.56,0,0,0,7.08-7.42.22.22,0,0,1,.3-.06L95,72.49a.21.21,0,0,1,0,.27A43.47,43.47,0,0,1,81.7,87.08a35.7,35.7,0,0,1-19,6,36.82,36.82,0,0,1-19.53-5.25A47.5,47.5,0,0,1,27.87,72.9a.23.23,0,0,1,0-.27l2.38-2.36a.22.22,0,0,1,.3,0l0,0ZM76.23,33.89c4.06,0,7.35,4.77,7.35,10.65s-3.29,10.64-7.35,10.64-7.35-4.77-7.35-10.64,3.29-10.65,7.35-10.65Zm-29.58,0c4.06,0,7.35,4.77,7.35,10.65s-3.29,10.64-7.35,10.64S39.3,50.41,39.3,44.54s3.29-10.65,7.35-10.65Zm42.1-19.75A54.64,54.64,0,1,0,114.18,47.3,54.46,54.46,0,0,0,88.75,14.14Z"/></svg>`,
                tooltip: true,
            });
            button.on("execute", () => {
                targetEmojis.value = `.btn-${props.name}`;
            });
            return button;
        });
    }
}

const editorProps = ref({
    editor: ClassicEditor,
    config: {
        plugins: [
            Autoformat,
            BlockQuote,
            Bold,
            CloudServices,
            Essentials,
            Heading,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            LinkImage,
            Base64UploadAdapter,
            Indent,
            IndentBlock,
            Italic,
            Link,
            List,
            MediaEmbed,
            Mention,
            Paragraph,
            PasteFromOffice,
            PictureEditing,
            Table,
            TableColumnResize,
            TableToolbar,
            TextTransformation,
            Underline,
            Font,
            SaveBtn,
            Alignment,
            HorizontalLine,
        ],
        toolbar: {
            items: [
                "undo",
                "redo",
                "|",
                "heading",
                "|",
                "bold",
                "italic",
                "underline",
                "|",
                "link",
                "uploadImage",
                "insertTable",
                "blockQuote",
                "mediaEmbed",
                "emoji-btn",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "outdent",
                "indent",
                "|",
                "fontSize",
                "fontFamily",
                "fontColor",
                "fontBackgroundColor",
                "alignment",
                "horizontalLine",
                "|",
                "save-btn",
                "cancel-btn",
            ],
            shouldNotGroupWhenFull: true,
        },
        heading: {
            options: [
                {
                    model: "paragraph",
                    title: "parrafo",
                    class: "ck-heading_paragraph",
                },
                {
                    model: "heading1",
                    view: "h1",
                    title: "encabezado 1",
                    class: "ck-heading_heading1",
                },
                {
                    model: "heading2",
                    view: "h2",
                    title: "encabezado 2",
                    class: "ck-heading_heading2",
                },
                {
                    model: "heading3",
                    view: "h3",
                    title: "encabezado 3",
                    class: "ck-heading_heading3",
                },
                {
                    model: "heading4",
                    view: "h4",
                    title: "encabezado 4",
                    class: "ck-heading_heading4",
                },
            ],
        },
        image: {
            resizeOptions: [
                {
                    name: "resizeImage:original",
                    label: "tamaño por defecto",
                    value: null,
                },
                {
                    name: "resizeImage:50",
                    label: "50% del tamaño original",
                    value: "50",
                },
                {
                    name: "resizeImage:75",
                    label: "75% del tamaño original",
                    value: "75",
                },
            ],
            toolbar: [
                "imageTextAlternative",
                "toggleImageCaption",
                "|",
                "imageStyle:inline",
                "imageStyle:wrapText",
                "imageStyle:breakText",
                "|",
                "resizeImage",
            ],
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: "https://",
        },
        table: {
            contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"],
        },
        translations: [coreTranslations],
    },
});

onBeforeMount(() => {
    const { rules } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
});

onMounted(() => {
    model.value = props.modelValue ?? "";
    defaultValue.value = model.value;
});

watch(
    () => props.modelValue,
    (n, o) => {
        model.value = n ?? "";
    }
);

watch(
    () => props.readonly,
    (n, o) => {
        if (n) editorInstance.value.enableReadOnlyMode("editor");
        else editorInstance.value.disableReadOnlyMode("editor");
    }
);

const onReady = (editor) => {
    editorInstance.value = editor;

    // editor.editing.view.change((writer) => {
    //     if (!props.autoHeight) {
    //         writer.setStyle(
    //             "height",
    //             `${
    //                 props.rows > 0 ? props.rows * 45 : screen.value.height - 115
    //             }px`,
    //             editor.editing.view.document.getRoot()
    //         );
    //     }
    // });

    const toolbar = editor.ui.view.toolbar.element;

    editor.on("change:isReadOnly", (evt, name, val, olVal) => {
        toolbar.parentNode.style.display = val ? "none" : "flex";
    });

    if (props.readonly) {
        editorInstance.value.enableReadOnlyMode("editor");
    }

    editor.focus();
};

const inserText = (e) => {
    const editor = editorInstance.value;
    editor.model.change((writer) => {
        writer.insertText(
            e,
            editor.model.document.selection.getFirstPosition()
        );
    });
    editor.focus();
};

const onEditorInput = (editor) => {
    emits("update", props.name, editor);
};

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
<style>
.ck-powered-by {
    display: none;
}
.help-editor {
    font-size: 11px;
    color: rgba(0, 0, 0, 0.54);
}
:root {
    --ck-z-default: 9999 !important;
}
.ck-read-only {
    border-color: transparent !important;
}
</style>
