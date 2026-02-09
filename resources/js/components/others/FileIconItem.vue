<template>
    <q-icon
        :name="fileConfig.icon"
        :class="fileConfig.colorClass"
        size="xs"
        style="padding: 5px; border-radius: 5px"
    />
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    fileName: {
        type: String,
        required: true,
    },
});

const fileConfig = computed(() => {
    const extension = props.fileName.split(".").pop().toLowerCase();

    const map = {
        pdf: { icon: "fas fa-file-pdf", colorClass: "bg-red-100 text-red-600" },
        doc: {
            icon: "fas fa-file-word",
            colorClass: "bg-blue-100 text-blue-600",
        },
        docx: {
            icon: "fas fa-file-word",
            colorClass: "bg-blue-100 text-blue-600",
        },
        xlsx: {
            icon: "fas fa-file-excel",
            colorClass: "bg-green-100 text-green-600",
        },
        jpg: {
            icon: "fas fa-file-image",
            colorClass: "bg-purple-100 text-purple-600",
        },
        png: {
            icon: "fas fa-file-image",
            colorClass: "bg-purple-100 text-purple-600",
        },
        zip: {
            icon: "fas fa-file-archive",
            colorClass: "bg-yellow-100 text-yellow-600",
        },
        default: {
            icon: "fas fa-file-alt",
            colorClass: "bg-gray-100 text-gray-600",
        },
    };

    return map[extension] || map.default;
});
</script>
