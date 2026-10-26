<template>
    <Layout>
        <q-page>
            <q-card>
                <q-card-section class="text-center text-primary">
                    <h6 class="text-lowercase text-primary q-pb-md">
                        bienvenido a tu espacio
                    </h6>
                    <p>
                        aqui encontraras los contenidos, recursos y herramientas
                        que tengas disponibles en sbye transformacion
                    </p>
                    <p>
                        empieza por aquello que necesites y recorre el resto de
                        tu espacio a tu propio ritmo
                    </p>
                </q-card-section>
                <q-card-section v-if="modulesCodes.length !== 0">
                    <div class="row q-col-gutter-md">
                        <template
                            v-for="(c, index) in cards"
                            :key="`card-${index}`"
                        >
                            <div
                                class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 flex"
                                v-if="
                                    modulesCodes.includes(c.module) ||
                                    c.module === 'free' ||
                                    $page.props.auth.user.admin
                                "
                            >
                                <q-card class="full-height full-width">
                                    <q-card-section
                                        class="text-center text-primary q-pa-none"
                                    >
                                        <q-img
                                            :ratio="1"
                                            fit="fill"
                                            :src="`${$page.props.public_path}images/home/${c.image}`"
                                            style=""
                                            :style="{
                                                opacity:
                                                    c.href === null
                                                        ? 0.5
                                                        : null,
                                                cursor:
                                                    c.href === null
                                                        ? 'not-allowed'
                                                        : 'pointer',
                                            }"
                                            @click="openCard(c)"
                                        />
                                    </q-card-section>
                                </q-card>
                            </div>
                        </template>
                    </div>
                </q-card-section>
                <q-card-section class="text-center text-primary">
                    <p class="no-padding no-margin">
                        crecimiento • consciencia • transformacion
                    </p>
                </q-card-section>
            </q-card>
        </q-page>
    </Layout>
</template>
<script setup>
import { router, usePage } from "@inertiajs/vue3";
import Layout from "../layouts/AdminLayout.vue";
import { computed } from "vue";

const page = usePage();

const cards = [
    {
        title: "videolibro",
        subtitle: "el libro en video",
        href: "/admin/school",
        image: "tarjeta app-video libro.png",
        module: "school_code",
    },
    {
        title: "reflexiona!",
        subtitle: "comprender para dejar de sufrir",
        href: "/admin/reflexiona",
        image: "tarjeta app-curso reflexiona.png",
        module: "reflection_code",
    },
    {
        title: "aprender a liberar",
        subtitle: "dejar salir lo que todavia duele",
        href: "/admin/learning",
        image: "tarjeta app-curso aprender a liberar.png",
        module: "learning_code",
    },
    {
        title: "crear la realidad",
        subtitle: "dirigir conscientemente tu propia vida",
        href: "/admin/reality",
        image: "tarjeta app-curso crear la realidad.png",
        module: "reality_code",
    },
    {
        title: "taller online",
        subtitle: "un espacio para aprender <br/> compartir y transformar",
        href: "/taller_online",
        image: "tarjeta app-taller online.png",
        module: "free",
    },
    {
        title: "mis citas",
        subtitle: "agenta y gestiona tus citas",
        href: null,
        image: "tarjeta app-mis citas.png",
        module: null,
    },
    {
        title: "mis documentos",
        subtitle: "tus materiales siempre a mano",
        href: "/admin/documents",
        image: "tarjeta app-mis documentos personales.png",
        module: "document_code",
    },
    {
        title: "en los medios",
        subtitle: "nuestra labor en prensa",
        href: "/admin/en-los-medios",
        image: "tarjeta app-en los medios.png",
        module: "inthemedia_code",
    },
    {
        title: "conferencias",
        subtitle: "acceso a conferencias pasadas <br/> y materiales",
        href: "/admin/conference",
        image: "tarjeta app-conferencias.png",
        module: "conference_code",
    },
    {
        title: "posts",
        subtitle: "inspiracion, reflexiones y recursos <br/> tu red social",
        href: "/admin/post",
        image: "tarjeta app-posts.png",
        module: "post_code",
    },
    {
        title: "avisos",
        subtitle: "novedades e informacion <br/> importante para ti",
        href: "/admin/messages",
        image: "tarjeta app-avisos.png",
        module: "message_code",
    },
    {
        title: "newsletters",
        subtitle: "tus materiales siempre a mano",
        href: "/admin/newsletter",
        image: "tarjeta app-newsletters.png",
        module: "newsletter_code",
    },
];

const modulesCodes = computed(() => {
    return page.props.auth.menu.modules.map((m) => m.code) || [];
});

const openCard = (c) => {
    if (c.href) {
        router.get(c.href);
    }
};
</script>
