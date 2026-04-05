<template>
    <q-btn-component
        tooltips="restaurar"
        icon="mdi-delete-restore"
        @click="restore"
    />
</template>

<script setup>
import QBtnComponent from "../../base/QBtnComponent.vue";
import { useForm } from "@inertiajs/vue3";

defineOptions({
    name: "RestoreComponent",
});

const props = defineProps({
    objects: { type: Array, default: [] },
});

const emits = defineEmits(["restored"]);

const restore = () => {
    const send = useForm({
        ids: props.objects.map((o) => o.id),
    });
    send.post("/admin/recycle-bin/restore", {
        onSuccess: () => {
            emits("restored");
        },
    });
};
</script>
