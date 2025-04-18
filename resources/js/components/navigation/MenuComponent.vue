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
        :style="{
            height: `${Screen.height - (mini ? 60 : 140)}px`,
        }"
        :thumb-style="thumbStyle"
        :bar-style="barStyle"
    >
        <q-list>
            <q-item
                clickable
                @click="navigateTo({ name: '/admin' })"
                :class="
                    $page.component === 'home'
                        ? `${
                              Dark.isActive
                                  ? 'text-primary text-bold'
                                  : 'text-bold'
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
        </q-list>
        <q-list
            v-for="(o, indexOption) in applications_with_module"
            :key="`menu-option-${indexOption}`"
        >
            <q-item
                clickable
                :class="isActiveParent(o) ? 'text-bold' : ''"
                :id="`menu-mini-${indexOption}`"
                v-if="mini"
            >
                <q-item-section avatar>
                    <q-icon :name="o.ico" />
                </q-item-section>
                <q-tooltip-component
                    :title="o.name"
                    anchor="center right"
                    self="center left"
                    class="text-lowercase bg-primary"
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
                            <q-item-section class="text-lowercase">{{
                                o.name
                            }}</q-item-section>
                        </q-item>
                        <q-item
                            v-for="(m, indexSubOpt) in o.modules"
                            :key="`menu_suboption-${indexSubOpt}`"
                            clickable
                            class="custom-item"
                            :active="$page.url.split('?')[0] === m.base_url"
                            @click="navigateTo({ name: m.base_url })"
                        >
                            <q-item-section avatar>
                                <q-icon
                                    :name="
                                        m.ico_from_path
                                            ? `img:${$page.props.public_path}${
                                                  Dark.isActive
                                                      ? m.ico.replace(
                                                            'black',
                                                            'white'
                                                        )
                                                      : m.ico.replace(
                                                            'white',
                                                            'black'
                                                        )
                                              }`
                                            : m.ico
                                    "
                                />
                            </q-item-section>
                            <q-item-section class="text-lowercase">{{
                                m.plural_label
                            }}</q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
            </q-item>
            <q-expansion-item
                group="somegroup"
                :icon="o.ico"
                :label="o.name"
                :default-opened="isActiveParent(o)"
                :header-class="
                    isActiveParent(o)
                        ? `text-bold ${Dark.isActive ? 'text-primary' : ''}`
                        : ''
                "
                class="text-lowercase"
                expand-icon-class="text-white"
                v-else
            >
                <q-card>
                    <q-card-section style="padding: 0">
                        <q-list :class="Dark.isActive ? '' : 'bg-primary'">
                            <q-item
                                v-for="(m, indexSubOpt) in o.modules"
                                :key="`menu_suboption-${indexSubOpt}`"
                                clickable
                                class="custom-item"
                                :class="
                                    $page.url.split('?')[0] === m.base_url
                                        ? `text-bold ${
                                              Dark.isActive
                                                  ? 'text-primary'
                                                  : ''
                                          }`
                                        : 'text-white'
                                "
                                :inset-level="0.2"
                                @click="navigateTo({ name: m.base_url })"
                            >
                                <q-item-section avatar>
                                    <q-icon
                                        :name="
                                            m.ico_from_path
                                                ? `img:${$page.props.public_path}${m.ico}`
                                                : m.ico
                                        "
                                    />
                                </q-item-section>
                                <q-item-section class="text-lowercase">{{
                                    m.plural_label
                                }}</q-item-section>
                            </q-item>
                        </q-list>
                    </q-card-section>
                </q-card>
            </q-expansion-item>
        </q-list>
        <q-item
            v-for="(o, indexOption) in modules_doesnt_have_app"
            :key="`menu-doesnt-have-app-${indexOption}`"
            clickable
            :active="$page.url.split('?')[0] === o.base_url"
            @click="navigateTo({ name: o.base_url })"
            :class="Dark.isActive ? '' : 'text-white'"
        >
            <q-item-section avatar>
                <q-icon
                    :name="
                        o.ico_from_path
                            ? `img:${$page.props.public_path}${o.ico}`
                            : o.ico
                    "
                />
            </q-item-section>
            <q-item-section class="text-lowercase">{{
                o.plural_label
            }}</q-item-section>
            <q-tooltip-component
                :title="o.plural_label"
                anchor="center right"
                self="center left"
                v-if="mini"
                class="text-lowercase bg-primary"
            ></q-tooltip-component>
        </q-item>
        <q-expansion-item
            group="somegroup"
            :icon="configuration.ico"
            :label="configuration.name"
            :default-opened="isActiveParent(configuration)"
            :header-class="
                isActiveParent(configuration)
                    ? `text-bold ${Dark.isActive ? 'text-primary' : ''}`
                    : ''
            "
            expand-icon-class="text-white"
            v-if="configuration && !mini"
        >
            <q-card>
                <q-card-section style="padding: 0">
                    <q-list :class="Dark.isActive ? '' : 'bg-primary'">
                        <q-item
                            v-for="(m, indexSubOpt) in configuration.modules"
                            :key="`menu_suboption-${indexSubOpt}`"
                            clickable
                            class="custom-item"
                            :class="
                                $page.url.split('?')[0] === m.base_url
                                    ? `text-bold ${
                                          Dark.isActive ? 'text-primary' : ''
                                      }`
                                    : 'text-white'
                            "
                            :inset-level="0.2"
                            @click="navigateTo({ name: m.base_url })"
                        >
                            <q-item-section avatar>
                                <q-icon :name="m.ico" />
                            </q-item-section>
                            <q-item-section>{{
                                m.plural_label
                            }}</q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </q-expansion-item>
        <q-item clickable v-if="configuration && mini">
            <q-item-section avatar>
                <q-icon :name="configuration.ico" />
            </q-item-section>
            <q-tooltip-component
                :title="configuration.name"
                anchor="center right"
                self="center left"
                class="text-lowercase bg-primary"
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
                            <q-icon :name="configuration.ico" />
                        </q-item-section>
                        <q-item-section>{{
                            configuration.name
                        }}</q-item-section>
                    </q-item>
                    <q-item
                        v-for="(m, indexSubOpt) in configuration.modules"
                        :key="`menu_suboption-${indexSubOpt}`"
                        clickable
                        class="custom-item"
                        :active="$page.url.split('?')[0] === m.base_url"
                        @click="navigateTo({ name: m.base_url })"
                    >
                        <q-item-section avatar>
                            <q-icon :name="m.ico" />
                        </q-item-section>
                        <q-item-section class="text-lowercase">{{
                            m.plural_label
                        }}</q-item-section>
                    </q-item>
                </q-list>
            </q-menu>
        </q-item>
        <session-close-component :mini="mini" />
    </q-scroll-area>
</template>

<script setup>
import { computed } from "vue";
import QTooltipComponent from "../base/QTooltipComponent.vue";
import { router, usePage } from "@inertiajs/vue3";
import { logout } from "../../services/auth";
import { Dark, Screen } from "quasar";
import { currentModule } from "../../services/current_module";
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

const emit = defineEmits(["change-url"]);

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

const applications_with_module = computed(() => {
    return page.props.auth.menu.applications_with_module.filter(
        (m) => m.name !== "configuracion"
    );
});
const modules_doesnt_have_app = computed(() => {
    return page.props.auth.menu.modules_doesnt_have_app;
});

const configuration = computed(() => {
    return page.props.auth.menu.applications_with_module.find(
        (m) => m.name === "configuracion"
    );
});

function navigateTo(payload) {
    if (payload) {
        if (typeof payload === "string") {
            if (payload.startsWith("http") || payload.startsWith("https")) {
                window.open(payload, "_blank");
            } else {
                router.get(payload);
                emit("change-url", currentModule(payload).module);
            }
        } else if (typeof payload === "object") {
            router.get(payload.name);
            let module = currentModule(payload.name);
            if (module) {
                emit("change-url", currentModule(payload.name).module);
            }
        }
    }
}

const isActiveParent = (module) => {
    const application = currentModule(page.url.split("?")[0])?.application;
    return application && application.id === module.id;
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
</style>
