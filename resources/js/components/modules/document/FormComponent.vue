<template>
    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        @show="setDefault = !setDefault"
        @hide="onHide"
    >
        <q-card class="scroll">
            <dialog-header-component
                :icon="object ? 'edit' : 'add'"
                :title="
                    object
                        ? `editar ${object.type === 'folder' ? 'carpeta' : 'archivo'}`
                        : 'adicionar carpeta/archivo'
                "
                closable
                @close="showDialog = false"
            />
            <form-body
                :object="object"
                :user="user"
                :parent="parent"
                @created="showDialog = false"
                @updated="showDialog = false"
                @cancel="showDialog = false"
            />
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import FormBody from "./FormBody.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    object: Object,
    user: Object,
    parent: Object,
    show: Boolean,
});

const emits = defineEmits(["reload-data", "hide"]);

const showDialog = ref(false);
const setDefault = ref(false);

const page = usePage();

watch(
    () => props.show,
    (n) => {
        showDialog.value = n;
    },
);

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
    emits("hide");
};
</script>
