<template>
    <Head>
        <title>
            Reflexiones, conferencias y testimonios | Sbye Transformación
        </title>
        <meta
            name="description"
            content="Explora las publicaciones de María Garriga Domínguez sobre consciencia, liberación emocional y vida en plenitud. Encuentra inspiración en testimonios, conferencias y mensajes de transformación."
        />
        <meta
            name="keywords"
            content="reflexiones, conferencias, testimonios, liberación emocional, María Garriga Domínguez"
        />
    </Head>
    <Layout title="publicaciones">
        <div
            class="row container q-mt-xl"
            :style="{ 'padding-top': screen.xs || screen.sm ? '40px' : '' }"
        >
            <div class="col-12 q-pb-md">
                <h4 class="q-mb-sm">{{ currentCategory.name }}</h4>
                <h6
                    class="text-lowercase q-mb-md"
                    v-if="currentCategory.subtitle"
                >
                    {{ currentCategory.subtitle }}
                </h6>
                <span
                    v-if="currentCategory.description"
                    v-html="currentCategory.description"
                >
                </span>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <files-category-component :category="currentCategory" />
                <div
                    class="row q-pa-md"
                    v-if="currentCategory?.name === 'testimonios'"
                >
                    <form-testimony-component />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="column items-center q-px-sm">
                    <list-category-component
                        :categories="categories"
                        :current="currentCategory"
                        :sticky="screen.xs || screen.sm"
                    />
                    <q-card
                        class="my-card rounded shadow-4 full-width q-mt-lg"
                        v-if="recent_files.length > 0"
                    >
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">mas recientes</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <q-list>
                                <q-item
                                    v-for="(f, indexRecent) in recent_files"
                                    :key="`recent-file-${indexRecent}`"
                                    class="q-py-md q-px-none"
                                    :class="
                                        indexRecent === recent_files.length - 1
                                            ? 'q-pb-none'
                                            : 'border-dashed-bottom-1'
                                    "
                                    :href="
                                        f.type === 'link'
                                            ? f.link
                                            : `${$page.props.public_path}storage/${f.path}`
                                    "
                                    target="_blank"
                                    clickable
                                >
                                    <q-item-section
                                        avatar
                                        style="width: 70px"
                                        class="q-pr-none"
                                    >
                                        <q-img
                                            :src="`${$page.props.public_path}images/others/publicaciones-recientes.png`"
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label
                                            lines="3"
                                            class="text-lowercase text-primary text-weight-bold"
                                            >{{ f.name }}</q-item-label
                                        >
                                        <q-item-label
                                            ><small class="text-lowercase">{{
                                                getDate(f.public_date)
                                            }}</small>
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>

                    <q-card class="my-card rounded shadow-4 full-width q-my-lg">
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">redes sociales</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <div class="row">
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-facebook-f"
                                        label="facebook"
                                        class="full-width"
                                        no-caps
                                        href="https://www.facebook.com/profile.php?id=61563937152210"
                                        target="_blank"
                                        align="left"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-youtube"
                                        label=" youtube"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.youtube.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-instagram"
                                        label="instagram"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.instagram.com/sbyetransformacion/"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-tiktok"
                                        label="tiktok"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.tiktok.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-linkedin"
                                        label="linkedin"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.linkedin.com/in/maría-garriga-domínguez-25173233a/"
                                        target="_blank"
                                    />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
        <template
            v-if="
                currentCategory?.name?.toLowerCase() == 'newsletter' ||
                currentCategory?.name?.toLowerCase() == 'newsletters'
            "
        >
            <div
                class="row container bg-primary text-white q-col-gutter-md q-mt-xl q-py-xl"
                id="suscribe"
            >
                <div class="col-md-6">
                    <h6 class="q-my-none text-white">
                        DESCUBRE LAS CLAVES PARA VIVIR EN PLENITUD
                    </h6>
                    <p class="q-mx-sm q-mt-md text-justify">
                        📩 suscribete a mi newsletter exclusiva y accede a
                        reflexiones profundas, enseñanzas ineditas y
                        herramientas practicas para liberarte emocionalmente y
                        conectar con tu plenitud
                    </p>
                    <p class="q-mx-sm q-mt-md">
                        <b>que recibiras?</b><br />
                        nuevas perspectivas sobre los temas de mi libro<i>
                            liberacion emocional</i
                        ><br />
                        mensajes y enseñanzas que no comparto en redes<br />
                        claves esenciales para vivir en plenitud y reconocer la
                        intervencion de dios en tu vida
                    </p>
                    <p class="q-mx-sm q-mt-md">
                        <b>regalo por suscripcion</b><br />
                        🎁 un <b>test rapido</b> para identificar tus enemigos
                        del aprendizaje<br />
                        🎁 una <b>guia en PDF</b> con estrategias para liberar
                        tu mente y aprender sin miedo<br />
                        🎁 acceso exclusivo a
                        <b>contenido inedito de mi libro</b>
                        <i> liberacion emocional</i>
                    </p>
                    <p class="q-mx-sm q-mt-md">
                        unete ahora y empieza tu camino hacia la plenitud!
                    </p>
                </div>
                <div class="col-md-6">
                    <form-subscription-component />
                </div>
            </div>
        </template>
    </Layout>

    <publications-msg-component
        v-if="
            currentCategory.name === 'libro' ||
            currentCategory.name === 'libros'
        "
    />
</template>

<script setup>
import { computed } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { usePage, Head } from "@inertiajs/vue3";
import ListCategoryComponent from "../../components/landing/ListCategoryComponent.vue";
import FilesCategoryComponent from "../../components/landing/FilesCategoryComponent.vue";
import FormTestimonyComponent from "../../components/landing/FormTestimonyComponent.vue";
import PublicationsMsgComponent from "../../components/modules/pushmessage/PublicationsMsgComponent.vue";
import FormSubscriptionComponent from "../../components/landing/FormSubscriptionComponent.vue";
import { useQuasar, date } from "quasar";

defineOptions({
    name: "Publicaciones",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const page = usePage();

const currentCategory = computed(() => {
    return page.props.current_category;
});

const categories = computed(() => {
    return page.props.categories;
});

const recent_files = computed(() => {
    return page.props.recent_files;
});

const getDate = (dd) => {
    let d = date.extractDate(dd, "YYYY/MM/DD");
    console.log(d, dd);

    return date.formatDate(dd, "MMMM D, YYYY");
};
</script>

<style scope>
.border-dashed-bottom-1 {
    border-bottom: 1px dashed #70707057;
}

.list-unstyled {
    padding-left: 0;
    list-style: none;
}

.mdi-asterisk {
    opacity: 0.8;
    position: absolute;
    font-size: 12px;
    z-index: 9;
    margin-top: 5px;
}

.img-aster-msg {
    margin-top: 5px !important;
    margin-left: 83px;
    z-index: 9;
}

.q-textarea .q-field__native {
    resize: none !important;
}

.q-field__messages {
    font-size: 14px;
}

.rounded-top {
    border-top-left-radius: 20px !important;
    border-top-right-radius: 20px;
}

.q-carousel__control.q-carousel__arrow button i img {
    height: 50px !important;
    width: 50px !important;
    padding: 20px !important;
}

.q-carousel__arrow button .q-focus-helper {
    display: none;
}

.q-carousel__arrow.q-carousel__next-arrow {
    right: 5px !important;
}

.q-carousel__arrow.q-carousel__prev-arrow {
    left: 5px !important;
}
</style>
