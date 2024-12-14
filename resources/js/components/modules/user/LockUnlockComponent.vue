<template>
    <q-btn-component
        :tooltips="object.active ? 'dar baja' : 'dar alta'"
        :icon="
            object.active
                ? 'mdi-account-cancel-outline'
                : 'mdi-account-check-outline'
        "
        @click="
            router.post(
                `/admin/users/lockUnlock/${object.id}`,
                {},
                {
                    onSuccess: () => emits('success'),
                }
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
    object: {
        type: Object,
        required: true,
    },
});

const emits = defineEmits(["success"]);
</script>
