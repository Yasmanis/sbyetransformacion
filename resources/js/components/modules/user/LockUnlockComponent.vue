<template>
    <q-btn-component
        :tooltips="status ? 'dar alta' : 'dar baja'"
        :icon="status ? 'mdi-check-circle-outline' : 'mdi-cancel'"
        :disable="objects.length === 0"
        @click="
            router.post(
                '/admin/users/lock-unlock',
                {
                    users: objects.map((o) => o.id),
                    status,
                },
                {
                    onSuccess: () => emits('success'),
                },
            )
        "
    />
</template>

<script setup>
import QBtnComponent from "../../base/QBtnComponent.vue";
import { router } from "@inertiajs/vue3";
defineOptions({
    name: "LockUnlockComponent",
});

const props = defineProps({
    objects: {
        type: Array,
        default: [],
    },
    disable: Boolean,
    status: Boolean,
});

const emits = defineEmits(["success"]);
</script>
