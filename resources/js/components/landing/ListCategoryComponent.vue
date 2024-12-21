<template>
    <q-page-sticky
        position="top"
        expand
        class="bg-primary text-white q-mb-lg q-header"
        v-if="sticky"
    >
        <q-toolbar>
            <q-btn flat round dense icon="menu">
                <q-menu style="min-width: 300px">
                    <q-list separator>
                        <q-item
                            clickable
                            v-for="(c, index) in categories"
                            :key="`category-${index}`"
                            :class="
                                current?.id === c.id
                                    ? 'text-bold text-primary'
                                    : ''
                            "
                            @click="router.get(`/publicaciones/${c.id}`)"
                        >
                            <q-item-section>{{ c.name }}</q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
            </q-btn>
            <q-toolbar-title>categorias > {{ current?.name }}</q-toolbar-title>
        </q-toolbar>
    </q-page-sticky>
    <q-card class="my-card rounded shadow-4 full-width" v-else>
        <q-card-section class="q-pb-none">
            <p class="q-my-sm text-uppercase">categorias</p>
            <div style="border-bottom: 2px solid #407492"></div>
            <ul class="q-pa-none q-my-none list-unstyled">
                <li
                    v-for="(c, index) in categories"
                    :key="`category-${index}`"
                    class="q-py-md"
                    :class="
                        index === categories.length - 1
                            ? 'q-pb-none'
                            : 'border-dashed-bottom-1'
                    "
                >
                    <Link
                        :href="`/publicaciones/${c.id}`"
                        class="text-primary"
                        :style="{
                            'font-weight': current?.id === c.id ? 'bold' : '',
                        }"
                    >
                        <i
                            class="fa fa-check font-company q-mr-sm"
                            aria-hidden="true"
                        ></i
                        >{{ c.name }}
                    </Link>
                </li>
            </ul>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
defineOptions({
    name: "ListCategoryComponent",
});

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    sticky: {
        type: Boolean,
        default: false,
    },
    current: {
        type: Object,
        required: true,
    },
});
</script>
