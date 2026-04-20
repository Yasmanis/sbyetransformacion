<template>
    <q-btn-component
        icon="mdi-file-account-outline"
        color="white"
        tooltips="documentos"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" full-width persistent>
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-file-account-outline"
                :title="`documentos de ${$page.props.user.full_name}`"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="scroll q-pa-none">
                <table-component
                    :user="$page.props.user"
                    :documents="$page.props.documents"
                />
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <lock-unlock-component
                    :object="object"
                    @success="showDialog = false"
                    v-if="has_edit"
                ></lock-unlock-component>
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import LockUnlockComponent from "./LockUnlockComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import TableComponent from "../document/TableComponent.vue";

defineOptions({
    name: "DocumentsComponent",
});

const props = defineProps({
    has_edit: {
        type: Boolean,
        default: false,
    },
    color: {
        type: String,
        default: "black",
    },
});

const showDialog = ref(false);
</script>
