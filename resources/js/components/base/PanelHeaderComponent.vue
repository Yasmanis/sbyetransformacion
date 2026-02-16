<template>
    <q-toolbar>
        <section class="q-my-xs q-mr-sm cursor-pointer text-subtitle1">
            <div class="doc-card-title bg-primary text-white">
                <q-icon :name="icon" size="22px" />
                {{ title }}
            </div>
        </section>
        <q-space />
        <div class="col-auto">
            <slot actions></slot>
        </div>
    </q-toolbar>
</template>

<script setup>
defineOptions({
    name: "DialogHeaderComponent",
});

const props = defineProps({
    separator: {
        type: Boolean,
        default: true,
    },
    title: String,
    icon: {
        type: String,
    },
});
</script>
