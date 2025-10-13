<template>
    <btn-edit-component
        @click="showDialog = true"
        tooltips="editar datos de la compra"
    />

    <q-dialog v-model="showDialog" persistent>
        <q-card>
            <dialog-header-component
                icon="mdi-store-edit-outline"
                title="direccion de envio"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll">
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "AddressSendSales",
});

const props = defineProps({
    object: Object,
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);

const user = computed(() => {
    return usePage().props.auth.user;
});
</script>
