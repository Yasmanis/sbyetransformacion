<template>
    <q-list separator>
        <q-item
            style="min-height: 49px; font-size: 21px"
            :class="Dark.isActive ? '' : 'bg-primary'"
        >
            <q-item-section :avatar="mini">
                <q-img :src="logo" :style="{ width: mini ? '55px' : '100%' }" />
            </q-item-section>
        </q-item>
        <q-item
            clickable
            :active="$page.component === 'home'"
            @click="navigateTo({ name: '/admin' })"
        >
            <q-item-section avatar>
                <q-icon name="home" />
            </q-item-section>
            <q-item-section>Inicio</q-item-section>
            <q-tooltip-component
                title="Inicio"
                anchor="center right"
                self="center left"
                v-if="mini"
            ></q-tooltip-component>
        </q-item>
    </q-list>
    <q-list
        separator
        v-for="(o, indexOption) in current_modules"
        :key="`menu-option-${indexOption}`"
    >
        <q-item
            clickable
            :active="isActive(o.url)"
            @click="navigateTo({ name: o.url })"
            v-if="!o.modules"
        >
            <q-item-section avatar>
                <q-icon :name="o.ico" />
            </q-item-section>
            <q-item-section>{{ o.name }}</q-item-section>
            <q-tooltip-component
                title="name"
                anchor="center right"
                self="center left"
                v-if="mini"
            ></q-tooltip-component>
        </q-item>
        <q-item
            clickable
            :class="isActiveParent(o) ? 'text-primary' : ''"
            :id="`menu-mini-${indexOption}`"
            v-else-if="o.modules && mini"
        >
            <q-item-section avatar>
                <q-icon :name="o.ico" />
            </q-item-section>
            <q-tooltip-component
                :title="o.name"
                anchor="center right"
                self="center left"
            ></q-tooltip-component>
            <q-menu
                anchor="top right"
                self="top left"
                :offset="[5, 0]"
                transition-show="scale"
                transition-hide="scale"
            >
                <q-list>
                    <q-item class="bg-primary text-white">
                        <q-item-section avatar>
                            <q-icon :name="o.ico" />
                        </q-item-section>
                        <q-item-section>{{ o.name }}</q-item-section>
                    </q-item>
                    <q-item
                        v-for="(m, indexSubOpt) in o.modules"
                        :key="`menu_suboption-${indexSubOpt}`"
                        clickable
                        class="custom-item"
                        :active="$page.url === m.url"
                        @click="navigateTo({ name: m.url })"
                    >
                        <q-item-section avatar>
                            <q-icon :name="m.ico" />
                        </q-item-section>
                        <q-item-section>{{ m.name }}</q-item-section>
                    </q-item>
                </q-list>
            </q-menu>
        </q-item>
        <q-expansion-item
            group="somegroup"
            :icon="o.ico"
            :label="o.name"
            :default-opened="isActiveParent(o)"
            :header-class="isActiveParent(o) ? 'text-primary' : ''"
            class="custom-expansion"
            v-else
        >
            <q-card>
                <q-card-section style="padding: 0">
                    <q-list>
                        <q-item
                            v-for="(m, indexSubOpt) in o.modules"
                            :key="`menu_suboption-${indexSubOpt}`"
                            clickable
                            class="custom-item"
                            :active="$page.url === m.url"
                            :inset-level="0.2"
                            @click="navigateTo({ name: m.url })"
                        >
                            <q-item-section avatar>
                                <q-icon :name="m.ico" />
                            </q-item-section>
                            <q-item-section>{{ m.name }}</q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </q-expansion-item>
    </q-list>
    <q-item clickable class="custom-item" @click="logout">
        <q-item-section avatar>
            <q-icon name="mdi-logout" />
        </q-item-section>
        <q-item-section>Salir</q-item-section>
    </q-item>
</template>

<script setup>
import { onBeforeMount, ref, computed } from "vue";
import QTooltipComponent from "../base/QTooltipComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { logout } from "../../services/auth";
import { Dark } from "quasar";
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

const emit = defineEmits(["change-url"]);

const current_modules = ref([]);

const page = usePage();

onBeforeMount(() => {
    current_modules.value = page.props.auth.app_list;
});

const logo = computed(() => {
    return Dark.isActive ? page.props.darkLogo : page.props.lightLogo;
});

function navigateTo(payload) {
    if (payload) {
        if (typeof payload === "string") {
            if (payload.startsWith("http") || payload.startsWith("https")) {
                window.open(payload, "_blank");
            } else {
                router.get(payload);
                emit("change-url", getCurrentModuleByRoute(payload));
            }
        } else if (typeof payload === "object") {
            router.get(payload.name);
            emit("change-url", getCurrentModuleByRoute(payload.name));
        }
    }
}

const isActive = (name) => {
    console.log(router);
    return true; //$router.currentRoute.value.name === name;
};

const isActiveParent = (module) => {
    let routes = [];
    module.modules.forEach((m) => {
        routes.push(m.url);
    });
    return routes.includes(router.page.url);
};

const getCurrentModuleByRoute = (route) => {
    if (route === "crud") return null;
    let modules = current_modules.value;
    for (let i = 0; i < modules.length; i++) {
        if (modules[i].url === route) {
            return modules[i];
        } else if (modules[i].modules) {
            for (let j = 0; j < modules[i].modules.length; j++) {
                if (modules[i].modules[j].url === route) {
                    return modules[i].modules[j];
                }
            }
        }
    }
    return null;
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
</style>
