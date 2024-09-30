<template>
    <q-layout view="lHh Lpr lFf">
        <q-header elevated>
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

                <q-img
                    :src="`${$page.props.public_path}images/logo/${
                        Dark.isActive ? '2' : '1'
                    }.png`"
                    style="width: 90px"
                    v-if="mini && !leftDrawerOpen"
                />
                <q-toolbar-title />

                <DarkSwitcher
                    class="z-max"
                    size="md"
                    colorDark="black"
                    colorLight="white"
                />
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="leftDrawerOpen"
            show-if-above
            bordered
            :mini="true"
            v-if="mini"
        >
            <menu-component
                @change-url="(nav) => (currentNav = nav)"
                :mini="true"
            />
        </q-drawer>

        <q-drawer v-model="leftDrawerOpen" show-if-above bordered v-else>
            <menu-component @change-url="(nav) => (currentNav = nav)" />
        </q-drawer>

        <q-page-container>
            <slot />
        </q-page-container>
    </q-layout>
</template>

<script setup>
import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/mdi-v6/mdi-v6.css";
import "@quasar/extras/fontawesome-v6/fontawesome-v6.css";
import "@quasar/extras/animate/animate-list.js";
import "quasar/src/css/index.sass";
import "../../css/app.css";
import { ref, onMounted } from "vue";
import MenuComponent from "../components/navigation/MenuComponent.vue";
import DarkSwitcher from "../components/profile/DarkSwitcher.vue";
import { Dark } from "quasar";

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

onMounted(() => {});
</script>
