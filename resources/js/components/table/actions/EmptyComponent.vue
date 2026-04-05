<template>
    <q-btn-component
        icon="mdi-delete-outline"
        :disable="disable"
        tooltips="vaciar"
        @click="confirm = true"
    />
    <confirm-component
        :show="confirm"
        :cancel="true"
        title="confirmar"
        message="seguro que desea vaciar la papelera"
        @ok="empty"
        @hide="confirm = false"
    />
</template>

<script setup>
import { ref } from "vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { router } from "@inertiajs/vue3";
defineOptions({
    name: "EmptyComponent",
});

const props = defineProps({
    size: {
        type: String,
        default: "sm",
    },
    disable: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["deleted"]);

const confirm = ref(false);

const empty = () => {
    router.post(
        "/admin/recycle-bin/empty-all",
        {},
        {
            onSuccess: () => {
                confirm.value = false;
            },
        }
    );
};
</script>
