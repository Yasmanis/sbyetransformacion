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
                            @click="
                                router.get(`/publicaciones?category_id=${c.id}`)
                            "
                        >
                            <q-item-section>{{ c.name }}</q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
            </q-btn>
            <q-toolbar-title
                >categorias > {{ current?.name }}
                {{
                    $page.props.current_subcategory
                        ? ` > ${page.props.current_subcategory.name}`
                        : null
                }}</q-toolbar-title
            >
        </q-toolbar>
    </q-page-sticky>
    <q-card class="my-card rounded shadow-4 full-width" v-else>
        <q-card-section class="q-pb-none">
            <p class="q-my-sm text-uppercase">categorias</p>
            <div style="border-bottom: 2px solid #407492"></div>
            <q-tree
                id="menu-tree"
                :nodes="$page.props.tree"
                node-key="key"
                no-connectors
                accordion
                dense
                v-model:expanded="expanded"
            >
                <template v-slot:default-header="prop">
                    <q-item
                        clickable
                        class="text-primary text-lowercase border-dashed-bottom-1 q-px-xs"
                        :class="{
                            'text-bold': prop.node.key === selectedKey,
                        }"
                        style="width: 100%"
                    >
                        <q-item-section
                            avatar
                            :style="{
                                'margin-left': `${prop.node.level * 20}px`,
                                padding: '0px !important',
                                'min-width': '30px',
                            }"
                        >
                            <q-icon
                                name="check
                            "
                            />
                        </q-item-section>
                        <q-item-section
                            class="cursor-pointer"
                            @click.stop="onClickCategory(prop.node)"
                        >
                            <q-item-label>
                                {{ prop.node.label }}
                                <q-tooltip-component
                                    title="click para ver contenido completo"
                                    v-if="prop.node.children?.length > 0"
                                />
                            </q-item-label>
                        </q-item-section>
                        <q-item-section
                            avatar
                            v-if="prop.node.children?.length > 0"
                        >
                            <q-icon
                                :name="
                                    expanded.includes(prop.node.key)
                                        ? 'expand_less'
                                        : 'expand_more'
                                "
                            />
                            <q-tooltip-component
                                :title="`click para ${
                                    expanded.includes(prop.node.key)
                                        ? 'ocultar'
                                        : 'ver'
                                } subcategorias`"
                                v-if="prop.node.children?.length > 0"
                            />
                        </q-item-section>
                    </q-item>
                </template>
            </q-tree>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";

import QTooltipComponent from "../base/QTooltipComponent.vue";

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

const expanded = ref([]);

const page = usePage();

const selectedKey = computed(() => {
    if (
        page.props.active_filter === "subcategory" &&
        page.props.current_subcategory
    )
        return "sub_" + page.props.current_subcategory.id;
    if (page.props.active_filter === "family" && page.props.current_family)
        return "fam_" + page.props.current_family.id;
    if (page.props.active_filter === "category" && page.props.current_category)
        return "cat_" + page.props.current_category.id;
    return null;
});

watch(
    selectedKey,
    (key) => {
        if (!key) return;
        console.log(key);
    },
    { immediate: true },
);

const onClickCategory = (categ) => {
    const query = {};
    if (categ.category_id) query.category_id = categ.category_id;
    else if (categ.family_id) query.family_id = categ.family_id;
    else if (categ.subcategory_id) query.subcategory_id = categ.subcategory_id;

    router.get("/publicaciones", query, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
<style>
#menu-tree .q-icon.q-tree__arrow {
    display: none;
}
#menu-tree .q-tree__node.relative-position.q-tree__node--child,
#menu-tree .q-tree__node-header,
#menu-tree .q-tree__children {
    padding-left: 0px !important;
}
</style>
