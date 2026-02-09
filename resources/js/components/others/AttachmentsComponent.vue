<template>
    <q-item v-for="t in attachments" :key="`attachment-${t.id}`">
        <q-item-section avatar top>
            <file-icon-item :file-name="t.name" />
        </q-item-section>
        <q-item-section>
            <q-item-label
                caption
                class="cursor-pointer text-primary"
                @click="openURL(`${$page.props.public_path}storage/${t.path}`)"
                >{{ t.name }}</q-item-label
            >
            <q-item-label caption>{{ t.humans_size }}</q-item-label>
        </q-item-section>
        <q-item-section avatar>
            <btn-show-hide-component
                :public="false"
                @click="openURL(`${$page.props.public_path}storage/${t.path}`)"
            />
        </q-item-section>
        <q-item-section avatar v-if="baseUrl">
            <btn-download-component
                size="12px"
                @click="openURL(`${baseUrl}/${t.id}`)"
            />
        </q-item-section>
    </q-item>
</template>

<script setup>
import { computed } from "vue";
import FileIconItem from "./FileIconItem.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import BtnDownloadComponent from "../btn/BtnDownloadComponent.vue";
import { openURL } from "quasar";

const props = defineProps({
    attachments: {
        type: Array,
        default: [],
    },
    baseUrl: String,
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

<style scoped>
.file-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 8px;
    transition: background 0.2s;
    cursor: default;
}

.file-item:hover {
    background-color: #f3f4f6;
}

.icon-wrapper {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    margin-right: 12px;
    font-size: 1.2rem;
}

.file-name {
    font-family: sans-serif;
    font-size: 14px;
    color: #374151;
    font-weight: 500;
}

.bg-red-100 {
    background-color: #fee2e2;
    color: #dc2626;
}
.bg-blue-100 {
    background-color: #dbeafe;
    color: #2563eb;
}
.bg-green-100 {
    background-color: #dcfce7;
    color: #16a34a;
}
.bg-purple-100 {
    background-color: #f3e8ff;
    color: #9333ea;
}
.bg-yellow-100 {
    background-color: #fef9c3;
    color: #ca8a04;
}
.bg-gray-100 {
    background-color: #f3f4f6;
    color: #4b5563;
}
</style>
