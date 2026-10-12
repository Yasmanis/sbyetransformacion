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
                <!-- <q-card-section>
                    <div class="row q-col-gutter-md">
                        <div
                            v-for="(c, index) in cards"
                            :key="`card-${index}`"
                            class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 flex"
                        >
                            <q-card class="full-height full-width">
                                <q-card-section
                                    class="text-center text-primary q-pa-none"
                                >
                                    <q-img
                                        :ratio="1"
                                        fit="fill"
                                        :src="`${$page.props.public_path}images/enfoque/${c.image}`"
                                        width="50%"
                                    />
                                    <p class="text-h6 text-bold no-margin">
                                        {{ c.title }}
                                    </p>
                                    <div
                                        style="min-height: 38px"
                                        class="flex flex-center"
                                    >
                                        <p
                                            v-html="c.subtitle"
                                            class="text-uppercase q-mb-none"
                                            style="font-size: 12px"
                                        ></p>
                                    </div>
                                </q-card-section>

                                <q-card-actions align="center" class="q-pa-md">
                                    <q-btn
                                        rounded
                                        color="primary"
                                        label="entrar"
                                        no-caps
                                        :href="c.href"
                                    >
                                        <q-icon
                                            name="fa fa-long-arrow-right"
                                            class="q-ml-md"
                                        />
                                    </q-btn>
                                </q-card-actions>
                            </q-card>
                        </div>
                    </div>
                </q-card-section> -->
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
import Layout from "../layouts/AdminLayout.vue";

const cards = [
    {
        title: "videolibro",
        subtitle: "el libro en video",
        href: "#",
        image: "enfoque_14.png",
    },
    {
        title: "reflexiona!",
        subtitle: "comprender para dejar de sufrir",
        href: "/admin/reflexiona",
        image: "enfoque_14.png",
    },
    {
        title: "aprender a liberar",
        subtitle: "dejar salir lo que todavia duele",
        href: "/admin/learning",
        image: "enfoque_14.png",
    },
    {
        title: "crear la realidad",
        subtitle: "dirigir conscientemente tu propia vida",
        href: "/admin/reality",
        image: "enfoque_14.png",
    },
    {
        title: "taller online",
        subtitle: "un espacio para aprender <br/> compartir y transformar",
        href: "/taller_online",
        image: "enfoque_14.png",
    },
    {
        title: "mis citas",
        subtitle: "agenta y gestiona tus citas",
        href: "",
        image: "enfoque_14.png",
    },
    {
        title: "mis documentos",
        subtitle: "tus materiales siempre a mano",
        href: "/admin/documents",
        image: "enfoque_14.png",
    },
    {
        title: "en los medios",
        subtitle: "nuestra labor en prensa",
        href: "/admin/en-los-medios",
        image: "enfoque_14.png",
    },
    {
        title: "conferencias",
        subtitle: "acceso a conferencias pasadas <br/> y materiales",
        href: "/admin/conference",
        image: "enfoque_14.png",
    },
    {
        title: "posts",
        subtitle: "inspiracion, reflexiones y recursos <br/> tu red social",
        href: "/admin/post",
        image: "enfoque_14.png",
    },
    {
        title: "avisos",
        subtitle: "novedades e informacion <br/> importante para ti",
        href: "#",
        image: "enfoque_14.png",
    },
    {
        title: "newsletters",
        subtitle: "tus materiales siempre a mano",
        href: "/admin/newsletter",
        image: "enfoque_14.png",
    },
];
</script>
