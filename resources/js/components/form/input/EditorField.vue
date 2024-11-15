<template>
    <div class="column q-ml-none" v-if="label">
        <label>{{ label }}</label>
    </div>
    <ckeditor
        v-model="model"
        :editor="editorProps.editor"
        :config="editorProps.config"
        @ready="onReady"
        @input="onEditorInput"
    />
    <div class="column help-editor q-ml-none" v-if="othersProps?.required">
        <span>requerido</span>
    </div>
</template>

<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { useQuasar } from "quasar";
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
    rows: {
        type: Number,
        default: 0,
    },
    othersProps: Object,
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const emits = defineEmits(["update", "save"]);

const model = ref("");

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
                emits("save");
            });
            return props.saveBtn ? button : null;
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
        toolbar: [
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
        ],
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

onMounted(() => {
    setModelValue();
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

const onReady = (editor) => {
    editor.editing.view.change((writer) => {
        writer.setStyle(
            "height",
            `${props.rows > 0 ? props.rows * 45 : screen.value.height - 115}px`,
            editor.editing.view.document.getRoot()
        );
    });
};

const onEditorInput = (editor) => {
    emits("update", props.name, editor);
};
</script>
<style scope>
.ck-powered-by {
    display: none;
}
.help-editor {
    font-size: 11px;
    color: rgba(0, 0, 0, 0.54);
}
</style>
