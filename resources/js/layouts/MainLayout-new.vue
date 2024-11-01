<template>
    <q-layout view="hHh lpR fff">
        <q-header class="bg-primary text-white">
            <q-toolbar>
                <q-toolbar-title>
                    <img
                        :src="`${$page.props.public_path}images/logo/1.png`"
                        class="q-ma-md"
                        width="250px"
                    />
                </q-toolbar-title>
                <q-btn-group flat push unelevated class="group-btn-header">
                    <q-btn
                        no-caps
                        color="primary"
                        label="vivir en plenitud"
                        @click="router.get('/')"
                    />
                    <q-btn
                        no-caps
                        color="primary"
                        label="consulta individual"
                        @click="router.get('/consulta_individual')"
                    />
                    <q-btn
                        no-caps
                        color="primary"
                        label="taller online"
                        @click="router.get('/taller_online')"
                    />
                    <q-btn
                        no-caps
                        color="primary"
                        label="publicaciones"
                        @click="router.get('/publicaciones')"
                    />
                    <q-btn
                        no-caps
                        color="primary"
                        label="contactame"
                        @click="router.get('/contactame')"
                    />
                </q-btn-group>
                <q-btn
                    no-caps
                    color="black"
                    label="area privada"
                    rounded
                    @click="router.get('/login')"
                >
                    <q-icon
                        name="fa fa-long-arrow-right"
                        size="xs"
                        class="q-ml-md"
                    />
                </q-btn>
            </q-toolbar>
        </q-header>

        <q-page-container>
            <slot />
        </q-page-container>

        <q-footer class="bg-black text-white q-pa-xl">
            <div class="rows text-center">
                <q-btn-component size="md" color="grey-9">
                    <q-icon name="fa fa-facebook" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    color="grey-9"
                    style="margin-left: 10px; margin-right: 10px"
                >
                    <q-icon name="fa fa-youtube-play" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    color="grey-9"
                    style="margin-right: 10px"
                >
                    <q-icon name="fa fa-instagram" size="xs" />
                </q-btn-component>
                <q-btn-component size="md" color="grey-9">
                    <q-icon
                        :name="`img:${$page.props.public_path}images/icon/tiktok.png`"
                        size="xs"
                    />
                </q-btn-component>
            </div>
            <div class="row items-center q-pa-md">
                <div class="col text-right">
                    <a
                        href=""
                        class="text-white"
                        style="margin-right: 10px; text-decoration: none"
                        >avisos legales</a
                    >
                </div>
                <div class="col">
                    <a
                        href=""
                        class="text-white"
                        style="margin-left: 10px; text-decoration: none"
                        >privacidad</a
                    >
                </div>
            </div>
            <div class="column items-center">&#169;2024 sbye salud s.l.</div>
        </q-footer>
    </q-layout>
</template>
<script setup>
import QBtnComponent from "../components/base/QBtnComponent.vue";
import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/mdi-v6/mdi-v6.css";
import "../assets/css/font-awesome.min.css";
import "@quasar/extras/animate/animate-list.js";
import "quasar/src/css/index.sass";
import "../../css/app.css";
import { router } from "@inertiajs/vue3";
import { computed } from "vue";

defineOptions({
    name: "MainLayout",
});

const logo = computed(() => {
    return ``;
});
</script>
<style scope>
.group-btn-header .q-focus-helper {
    display: none;
}
</style>
