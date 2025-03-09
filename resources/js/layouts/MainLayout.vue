<template>
    <q-layout view="hHh lpR fff">
        <q-header class="bg-primary text-white container">
            <q-toolbar class="q-px-none q-pt-md">
                <q-toolbar-title :shrink="!screen.xs && !screen.sm">
                    <img
                        :src="`${$page.props.public_path}images/logo/1.png`"
                        width="180px"
                    />
                </q-toolbar-title>
                <div
                    class="q-gutter-lg"
                    style="flex: 1; display: flex; justify-content: center"
                    v-if="!screen.xs && !screen.sm"
                >
                    <Link
                        v-for="(l, index) in links"
                        :key="`index-link-${index}`"
                        :href="l.url"
                        class="text-white"
                        >{{ l.title }}</Link
                    >
                </div>
                <q-btn
                    flat
                    round
                    dense
                    icon="menu"
                    v-if="screen.xs || screen.sm"
                >
                    <q-menu style="min-width: 300px">
                        <q-list separator>
                            <q-item
                                clickable
                                v-for="(l, indexItem) in links"
                                :key="`index-item-${indexItem}`"
                                @click="router.get(l.url)"
                            >
                                <q-item-section>{{ l.title }}</q-item-section>
                            </q-item>
                            <q-item
                                clickable
                                @click="
                                    router.get(
                                        authenticated ? '/admin' : '/login'
                                    )
                                "
                            >
                                <q-item-section> area privada </q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn>
                <q-btn
                    no-caps
                    color="black"
                    rounded
                    label="area privada"
                    :href="authenticated ? '/admin' : '/login'"
                    v-else
                >
                    <q-icon
                        name="fa fa-long-arrow-right"
                        size="xs"
                        class="q-ml-md"
                    />
                </q-btn>
            </q-toolbar>
            <p
                class="text-center text-uppercase"
                style="font-size: 24px"
                v-if="title"
            >
                {{ title }}
            </p>
        </q-header>

        <q-page-container>
            <slot />
        </q-page-container>

        <q-footer class="bg-black text-white q-pa-xl">
            <div class="text-center">
                <q-btn-component
                    size="md"
                    color="grey-9"
                    href="https://www.facebook.com/profile.php?id=61563937152210"
                    target="blank"
                    :flat="false"
                    padding="8px"
                >
                    <q-icon name="fab fa-facebook-f" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    color="grey-9"
                    style="margin-left: 10px; margin-right: 10px"
                    href="https://www.youtube.com/@sbyetransformacion"
                    target="blank"
                    :flat="false"
                    padding="8px"
                >
                    <q-icon name="fab fa-youtube" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    color="grey-9"
                    style="margin-right: 10px"
                    href="https://www.instagram.com/sbyetransformacion/"
                    target="blank"
                    :flat="false"
                    padding="8px"
                >
                    <q-icon name="fab fa-instagram" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    color="grey-9"
                    href="https://www.tiktok.com/@sbyetransformacion"
                    target="blank"
                    :flat="false"
                    padding="8px"
                >
                    <q-icon name="fab fa-tiktok" size="xs" />
                </q-btn-component>
            </div>
            <div class="text-center q-pa-md">
                <Link href="/legal" class="text-white q-mr-md">
                    avisos legales
                </Link>
                <Link href="/private" class="text-white q-ml-md">
                    privacidad
                </Link>
            </div>
            <div class="text-center">&#169;2024 sbye salud s.l.</div>
        </q-footer>

        <q-page-scroller
            position="bottom-right"
            :scroll-offset="150"
            :offset="[18, 18]"
        >
            <q-btn fab icon="mdi-arrow-up" color="primary" padding="sm" />
        </q-page-scroller>
    </q-layout>
</template>
<script setup>
import QBtnComponent from "../components/base/QBtnComponent.vue";
import { router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import { Screen } from "quasar";

defineOptions({
    name: "MainLayout",
});

const props = defineProps({
    title: String,
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const authenticated = computed(() => {
    return usePage().props.auth;
});

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
        title: "maria",
        url: "/maria",
    },
    {
        title: "contactame",
        url: "/contactame",
    },
]);
</script>
<style scope>
a {
    text-decoration: none;
}

.container {
    padding-left: 8%;
    padding-right: 8%;
}

.header-title,
.header-subtitle {
    font-size: 24px;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    color: #223645;
    font-weight: 400;
    font-size: 21px;
    text-transform: uppercase;
    margin: 0;
    line-height: 1.22;
}

.rounded {
    border-radius: 25px !important;
}
</style>
