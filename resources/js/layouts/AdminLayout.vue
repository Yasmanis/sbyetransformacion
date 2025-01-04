<template>
    <q-layout view="lHh Lpr lFf">
        <q-header>
            <q-toolbar
                :style="{ background: Dark.isActive ? '#1d1d1d' : '#407492' }"
            >
                <q-btn
                    flat
                    dense
                    round
                    icon="menu"
                    aria-label="Menu"
                    @click="toggleLeftDrawer"
                />

                <img
                    :src="`${$page.props.public_path}images/logo/1.png`"
                    style="width: 90px"
                    v-if="mini && !leftDrawerOpen"
                />
                <q-toolbar-title />

                <q-btn-component
                    icon="reply_all"
                    tooltips="volver a"
                    color="white"
                    class="q-mr-sm"
                >
                    <q-menu style="min-width: 300px">
                        <q-list separator>
                            <q-item
                                clickable
                                v-for="(l, indexItem) in links"
                                :key="`index-item-${indexItem}`"
                                :href="l.url"
                            >
                                <q-item-section>{{ l.title }}</q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn-component>

                <q-btn-component
                    icon="mdi-bell-outline"
                    tooltips="notificationes"
                    color="white"
                    class="q-mr-sm fa-beat"
                    v-if="notifications.length > 0"
                >
                    <q-badge color="black" floating>{{
                        notifications.length
                    }}</q-badge>
                    <q-menu style="min-width: 300px">
                        <notifications-component :messages="notifications" />
                    </q-menu>
                </q-btn-component>

                <DarkSwitcher
                    class="z-max"
                    size="md"
                    colorDark="black"
                    colorLight="white"
                />
            </q-toolbar>
        </q-header>

        <q-drawer
            :class="Dark.isActive ? '' : 'bg-primary text-white'"
            v-model="leftDrawerOpen"
            show-if-above
            :mini="true"
            v-if="mini"
        >
            <menu-component
                @change-url="(nav) => (currentNav = nav)"
                :mini="true"
            />
        </q-drawer>

        <q-drawer
            :class="Dark.isActive ? '' : 'bg-primary text-white'"
            v-model="leftDrawerOpen"
            show-if-above
            v-else
        >
            <menu-component @change-url="(nav) => (currentNav = nav)" />
        </q-drawer>

        <q-page-container :class="Dark.isActive ? '' : 'bg-primary'">
            <slot />
        </q-page-container>
    </q-layout>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import MenuComponent from "../components/navigation/MenuComponent.vue";
import DarkSwitcher from "../components/profile/DarkSwitcher.vue";
import QBtnComponent from "../components/base/QBtnComponent.vue";
import NotificationsComponent from "../components/others/NotificationsComponent.vue";
import { Dark } from "quasar";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "AdminLayout",
});

const currentNav = ref(null);
const mini = ref(false);
const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
    leftDrawerOpen.value = !leftDrawerOpen.value;
    mini.value = !leftDrawerOpen.value;
}

const links = ref([
    {
        title: "vivir en plenitud",
        url: "/",
    },
    {
        title: "consulta individual",
        url: "/consulta_individual",
    },
    {
        title: "taller online",
        url: "/taller_online",
    },
    {
        title: "publicaciones",
        url: "/publicaciones",
    },
    {
        title: "contactame",
        url: "/contactame",
    },
]);

const notifications = computed(() => {
    return usePage().props.auth.user.notifications;
});
</script>
