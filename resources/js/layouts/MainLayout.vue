<template>
    <q-layout view="hHh lpR fff">
        <q-header class="bg-primary text-white container" v-if="header">
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
            <div class="text-center q-py-lg">
                <Link href="/legal" class="text-white q-mr-md">
                    avisos legales
                </Link>
                <Link href="/private" class="text-white q-ml-md">
                    privacidad
                </Link>
                <Link href="/contracting" class="text-white q-ml-md">
                    condiciones de contratacion
                </Link>
            </div>
            <div class="row justify-around q-gutter-md">
                <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2 col-xl-2">
                    <div
                        class="column"
                        :class="Screen.xs ? 'items-center' : 'items-end'"
                    >
                        <div>
                            <Link href="" class="text-white"
                                >sbye transformacion</Link
                            ><br />
                            <Link href="/maria" class="text-white">maria</Link
                            ><br />
                            <Link href="/mi_enfoque" class="text-white"
                                >mi enfoque</Link
                            ><br />
                            <Link href="/consulta_individual" class="text-white"
                                >consulta individual</Link
                            ><br />
                            <Link href="taller_online" class="text-white"
                                >taller online</Link
                            >
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2 col-xl-2">
                    <div class="column items-center">
                        <div>
                            publicaciones <br />
                            <div class="q-ml-md">
                                <span
                                    v-for="c in allCategories"
                                    :key="`public-categ-${c.name}`"
                                >
                                    <Link
                                        :href="`/publicaciones/${c.id}`"
                                        class="text-white"
                                        v-if="c.id !== null"
                                        >{{ c.name }}</Link
                                    >
                                    <span disabled v-else> {{ c.name }} </span
                                    ><br />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2 col-xl-2">
                    <div class="column items-center">
                        <div>
                            tienda <br />
                            <div class="q-ml-md">
                                <span
                                    v-for="c in allCourses"
                                    :key="`course-${c.name}`"
                                >
                                    <Link
                                        :href="`/tienda#${c.id}`"
                                        class="text-white"
                                        v-if="c.id !== null"
                                        >{{ c.name }}</Link
                                    >
                                    <span disabled v-else> {{ c.name }} </span
                                    ><br />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="col-xs-12 col-sm-5 col-md-2 col-lg-2 col-xl-2"
                    :class="{
                        'text-center': Screen.xs || Screen.sm,
                    }"
                >
                    <Link href="/contactame" class="text-white">contacto</Link>
                </div>
            </div>
            <p class="text-center no-margin q-pt-lg">
                &#169;2024 maria garriga dominguez
            </p>
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
import { ref, computed, onBeforeMount } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Screen, useQuasar } from "quasar";
import axios from "axios";

defineOptions({
    name: "MainLayout",
});

const props = defineProps({
    title: String,
    header: {
        type: Boolean,
        default: true,
    },
});

const $q = useQuasar();

const allCategories = ref([
    {
        name: "testimonios",
        id: null,
    },
    {
        name: "medios",
        id: null,
    },
    {
        name: "conferencias",
        id: null,
    },
    {
        name: "posts",
        id: null,
    },
    {
        name: "newsletters",
        id: null,
    },
    {
        name: "vinculadas al libro",
        id: null,
    },
    {
        name: "para prensa",
        id: null,
    },
]);

const allCourses = ref([
    { name: "curso aprender a liberar emocionalmente", id: null },
    { name: "curso crear la realidad conscientemente", id: null },
]);

const activeCourses = ref([]);

onBeforeMount(async () => {
    await axios.get("/shared_data").then((response) => {
        const { categories, courses } = response.data;
        allCategories.value.forEach((c) => {
            let found = categories.find((cc) => cc.name === c.name);
            c.id = found?.id ?? null;
        });
        allCourses.value.forEach((c) => {
            let found = courses.find((cc) => `curso ${cc.name}` === c.name);
            c.id = found?.id ?? null;
        });
    });
});

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
        title: "maria",
        url: "/maria",
    },
    {
        title: "mi enfoque",
        url: "/mi_enfoque",
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
        title: "tienda",
        url: "/tienda",
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

.ck-editor h1,
.ck-editor h2,
.ck-editor h3,
.ck-editor h4 {
    line-height: inherit !important;
    margin: inherit !important;
    margin-bottom: 5px !important;
}

.rounded {
    border-radius: 25px !important;
}
</style>
