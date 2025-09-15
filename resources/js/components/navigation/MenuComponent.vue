<template>
    <q-item
        clickable
        style="min-height: 50px"
        :class="Dark.isActive ? '' : 'bg-primary'"
        @click="navigateTo({ name: '/' })"
    >
        <q-item-section :avatar="mini">
            <img
                :src="`${$page.props.public_path}images/logo/1.png`"
                :style="{
                    width: mini ? '55px' : '100%',
                    height: mini ? '' : '120px',
                }"
            />
        </q-item-section>
    </q-item>
    <q-scroll-area
        ref="scroll"
        :style="{
            height: `${Screen.height - (mini ? 60 : 140)}px`,
        }"
        :thumb-style="thumbStyle"
        :bar-style="barStyle"
    >
        <q-item
            clickable
            @click="navigateTo('/admin')"
            :class="
                $page.component === 'home'
                    ? `${
                          Dark.isActive ? 'text-primary text-bold' : 'text-bold'
                      }`
                    : ''
            "
        >
            <q-item-section avatar>
                <q-icon name="mdi-home" />
            </q-item-section>
            <q-item-section class="text-lowercase">Inicio</q-item-section>
            <q-tooltip-component
                title="Inicio"
                anchor="center right"
                self="center left"
                class="text-lowercase bg-primary"
                v-if="mini"
            ></q-tooltip-component>
        </q-item>
        <q-tree
            ref="treeRef"
            :nodes="menu"
            dense
            no-connectors
            accordion
            selected-color="primary"
            node-key="id"
            id="menu-tree"
            v-model:expanded="expanded"
        >
            <template v-slot:default-header="prop">
                <q-item
                    class="text-white text-lowercase"
                    :class="
                        active?.id === prop.node.id ||
                        activePath.includes(prop.node.id)
                            ? 'text-bold'
                            : null
                    "
                    clickable
                    style="width: 100%"
                    :id="`menu-${prop.node.id}`"
                    @click="navigateTo(prop.node)"
                >
                    <q-item-section
                        avatar
                        :style="{
                            'margin-left': `${prop.node.level * 20}px`,
                        }"
                    >
                        <q-icon
                            :name="
                                prop.node.ico_from_path
                                    ? `img:${$page.props.public_path}${prop.node.icon}`
                                    : prop.node.icon
                            "
                        />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label lines="1">
                            {{ prop.node.plural_label }}
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar v-if="prop.node.children.length > 0">
                        <q-icon
                            :name="
                                expanded.includes(prop.node.id)
                                    ? 'expand_less'
                                    : 'expand_more'
                            "
                        />
                    </q-item-section>
                </q-item>
            </template>
        </q-tree>
        <session-close-component :mini="mini" />
    </q-scroll-area>
</template>

<script setup>
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";
import QTooltipComponent from "../base/QTooltipComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { logout } from "../../services/auth";
import { Dark, Screen } from "quasar";
import {
    getActiveModule,
    getChildrenFromParent,
    modules,
} from "../../services/current_module";
import SessionCloseComponent from "../base/SessionCloseComponent.vue";

defineOptions({
    name: "MenuComponent",
});

const props = defineProps({
    title: {
        type: String,
    },
    class: { type: String, default: "bg-primary" },
    mini: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const scroll = ref(null);

const emit = defineEmits(["change-url"]);
const treeRef = ref(null);
const active = ref(null);
const activePath = ref([]);
const expanded = ref([]);
const currentMenu = ref(null);

const thumbStyle = {
    borderRadius: "5px",
    backgroundColor: "#fff",
    width: "8px",
    opacity: 0.8,
};

const barStyle = {
    right: "2px",
    borderRadius: "9px",
    backgroundColor: "transparent",
    width: "9px",
    opacity: 0.2,
};

watch(
    () => page.url,
    () => {
        updateMenu();
    }
);

onBeforeMount(() => {
    updateMenu();
});

const updateMenu = () => {
    const module = getActiveModule();
    if (module) {
        active.value = module;
        setExpanded(module);
        currentMenu.value = module;
    } else {
        currentMenu.value = null;
    }
};

const setExpanded = (node) => {
    if (node.parent_id !== null) {
        const n = modules().find((m) => m.id === node.parent_id);
        if (n) {
            activePath.value.push(n.id);
            expanded.value.push(n.id);
            setExpanded(n);
        }
    }
};

const menu = computed(() => {
    const list = page.props.auth.menu.tree;
    list.forEach((m) => {
        m["level"] = 0;
        setLevelToChildren(m);
    });
    return page.props.auth.menu.tree;
});

const setLevelToChildren = async (node, level = 1) => {
    node.children.forEach((n) => {
        n["level"] = level;
        setLevelToChildren(n, level + 1);
    });
};

const navigateTo = (payload) => {
    if (payload) {
        if (typeof payload === "string") {
            if (payload.startsWith("http") || payload.startsWith("https")) {
                window.open(payload, "_blank");
            } else {
                router.get(payload);
            }
        } else if (
            typeof payload === "object" &&
            payload.children.length === 0
        ) {
            if (payload.exclude_childs) {
                const modules = getChildrenFromParent(payload);
                if (modules.length > 0) {
                    payload = modules[0];
                }
            }
            router.get(
                payload.base_url,
                {},
                { preserveScroll: true, preserveState: true }
            );
            emit("change-url", payload);
        }
    }
};
</script>

<style scope>
.q-item__section--avatar {
    min-width: 20px;
}

.link-menu {
    text-decoration: none;
    color: #000;
}

.link-menu:hover {
    color: #407492;
}

.q-item--active {
    font-weight: bold;
}
#menu-tree .q-icon.q-tree__arrow {
    display: none;
}
#menu-tree .q-tree__node.relative-position.q-tree__node--child,
#menu-tree .q-tree__children {
    padding-left: 0px !important;
}
</style>
