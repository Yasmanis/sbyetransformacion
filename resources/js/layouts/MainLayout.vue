<template>
    <q-layout view="hHh lpR fff">
        <q-header class="bg-primary container text-white" v-if="header">
            <q-toolbar class="no-wrap">
                <q-toolbar-title shrink class="q-py-sm">
                    <img
                        :src="`${$page.props.public_path}images/logo/1.png`"
                        width="180px"
                        style="display: block"
                    />
                </q-toolbar-title>
                <div
                    class="row no-wrap items-center justify-end"
                    style="flex: 1; overflow: hidden"
                >
                    <q-resize-observer @resize="calculateVisible" />

                    <div class="row no-wrap q-gutter-x-xs justify-end">
                        <q-btn
                            v-for="(link, index) in visibleLinks"
                            :key="index"
                            no-wrap
                            no-caps
                            :flat="link.flat"
                            :color="link.color"
                            :label="link.label"
                            :rounded="link.rounded"
                            @click="router.get(link.url)"
                        >
                            <q-icon
                                :name="link.icon"
                                size="xs"
                                class="q-ml-md"
                                v-if="link.icon"
                            />
                        </q-btn>

                        <q-btn-dropdown
                            v-if="hiddenLinks.length > 0"
                            flat
                            auto-close
                            no-caps
                            dropdown-icon="menu"
                        >
                            <q-list style="min-width: 150px">
                                <q-item
                                    v-for="(link, index) in hiddenLinks"
                                    :key="index"
                                    clickable
                                    @click="router.get(link.url)"
                                >
                                    <q-item-section>{{
                                        link.label
                                    }}</q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </div>
                </div>
            </q-toolbar>
            <q-item class="bg-primary text-white" v-if="title">
                <q-item-section>
                    <q-item-label
                        class="text-center text-uppercase"
                        style="font-size: 24px"
                        >{{ title }}
                    </q-item-label>
                </q-item-section>
            </q-item>
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
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 col-xl-3">
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
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 col-xl-3">
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
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3 col-xl-3">
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
                            <br />
                            <Link href="/contactame" class="text-white"
                                >contacto</Link
                            >
                        </div>
                    </div>
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
import { ref, computed, onBeforeMount, onMounted } from "vue";
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

const allCategories = ref([]);

const allCourses = ref([
    { name: "curso aprender a liberar emocionalmente", id: null },
    { name: "curso crear la realidad conscientemente", id: null },
]);

const activeCourses = ref([]);

onBeforeMount(async () => {
    await axios.get("/shared_data").then((response) => {
        const { categories, courses } = response.data;
        allCategories.value = categories;
        allCourses.value.forEach((c) => {
            let found = courses.find((cc) => `curso ${cc.name}` === c.name);
            c.id = found?.id ?? null;
        });
    });
});

onMounted(() => {
    const dummy = document.createElement("div");
    dummy.style.cssText =
        "visibility:hidden; position:absolute; display:flex; white-space:nowrap;";
    document.body.appendChild(dummy);

    links.forEach((link) => {
        const el = document.createElement("button");
        el.className = "q-btn q-btn--flat q-btn--no-uppercase q-py-none";
        el.innerHTML = `<span class="q-btn__content">${link.label}</span>`;
        dummy.appendChild(el);
        buttonWidths.push(el.offsetWidth + 8);
    });
    document.body.removeChild(dummy);
    setTimeout(() => {
        const initialWidth = document.querySelector(".justify-end").offsetWidth;
        calculateVisible({ width: initialWidth });
    }, 100);
});

const authenticated = computed(() => {
    return usePage().props.auth;
});

const links = [
    {
        label: "sbye transformacion",
        url: "/",
        flat: true,
        rounded: false,
    },
    {
        label: "maria",
        url: "/maria",
        flat: true,
        rounded: false,
    },
    {
        label: "mi enfoque",
        url: "/mi_enfoque",
        flat: true,
        rounded: false,
    },
    {
        label: "consulta individual",
        url: "/consulta_individual",
        flat: true,
        rounded: false,
    },
    {
        label: "taller online",
        url: "/taller_online",
        flat: true,
        rounded: false,
    },
    {
        label: "publicaciones",
        url: "/publicaciones",
        flat: true,
        rounded: false,
    },
    {
        label: "tienda",
        url: "/tienda",
        flat: true,
        rounded: false,
    },
    {
        label: "contactame",
        url: "/contactame",
        flat: true,
        rounded: false,
    },
    {
        label: "area privada",
        url: authenticated.value ? "/admin" : "/login",
        color: "black",
        flat: false,
        rounded: true,
        icon: "fa fa-long-arrow-right",
    },
];

const visibleCount = ref(links.length);
const buttonWidths = [];

const visibleLinks = computed(() => links.slice(0, visibleCount.value));
const hiddenLinks = computed(() => links.slice(visibleCount.value));

const calculateVisible = (size) => {
    const containerWidth = size.width;
    let totalWidthNeeded = 0;
    let count = 0;
    const moreBtnWidth = 90;

    for (let i = 0; i < buttonWidths.length; i++) {
        totalWidthNeeded += buttonWidths[i];
        if (totalWidthNeeded + moreBtnWidth > containerWidth) break;
        count++;
    }

    if (count === links.length - 1) {
        const totalWithoutDropdown = totalWidthNeeded;
        if (totalWithoutDropdown <= containerWidth) count = links.length;
    }

    visibleCount.value = count;
};
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
