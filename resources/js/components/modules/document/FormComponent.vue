<template>
    <btn-add-component @click="showDialog = true" v-if="!object" />
    <btn-edit-component @click="showDialog = true" v-else />

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
                @created="onCreated"
                @updated="onUpdated"
                @cancel="showDialog = false"
            />
        </q-card>
    </q-dialog>
</template>

<script setup>
defineOptions({
    name: "FormComponent",
});

import { ref, onMounted, computed } from "vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import FormBody from "./FormBody.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    object: Object,
    user: Object,
});

const emits = defineEmits(["reload-data"]);

const showDialog = ref(false);
const setDefault = ref(false);

const page = usePage();

const onHide = () => {
    setDefault.value = !setDefault.value;
    page.props.errors = {};
};

const onCreated = () => {
    showDialog.value = false;
    emits("reload-data");
};

const onUpdated = (object, close) => {
    if (close) {
        showDialog.value = false;
    }
};
</script>
