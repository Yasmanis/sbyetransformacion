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
                            <q-scroll-area style="height: 200px">
                                <q-list>
                                    <q-item
                                        v-for="(f, indexRecent) in recent_files"
                                        :key="`recent-file-${indexRecent}`"
                                        class="q-py-md q-px-none"
                                        :class="
                                            indexRecent ===
                                            recent_files.length - 1
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
                                                ><small
                                                    class="text-lowercase"
                                                    >{{
                                                        getDate(f.public_date)
                                                    }}</small
                                                >
                                            </q-item-label>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-scroll-area>
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
                class="row container bg-primary text-white q-col-gutter-md q-ma-sm q-pa-md"
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

            <div class="row container q-mt-xl">
                <div class="row">
                    <div class="col">
                        <h6 class="q-mb-md text-lowercase text-bold">
                            empieza simplemente observando
                        </h6>
                        <p>
                            a veces una idea, una situacion cotidiana o una
                            pregunta es suficiente para empezar a descubrir algo
                            de nosotros que hasta entonces no habIamos visto
                        </p>
                        <h6 class="q-mb-sm text-lowercase">
                            videos para observarte y comprenderte
                        </h6>
                    </div>
                </div>
                <q-carousel
                    v-model="slide"
                    animated
                    padding
                    :arrows="!Screen.xs"
                    :navigation="Screen.xs"
                    :prev-icon="`img:${$page.props.public_path}images/icon/left.png`"
                    :next-icon="`img:${$page.props.public_path}images/icon/right.png`"
                    control-color="primary"
                    style="height: auto"
                >
                    <q-carousel-slide
                        v-for="(slideGroup, indexGroup) in groupedSlides"
                        :key="`slide-group-${indexGroup}`"
                        :name="`style-${indexGroup}`"
                        class="column no-wrap flex-center"
                    >
                        <div class="row q-col-gutter-md">
                            <div
                                v-for="(slide, slideIndex) in slideGroup"
                                :key="`slide-${slideIndex}`"
                                class="col-6"
                            >
                                <q-card
                                    class="my-card rounded-borders bg-primary text-white"
                                    style="border-radius: 30px !important"
                                >
                                    <q-card-section
                                        :class="Screen.xs ? '' : 'q-pa-xl'"
                                    >
                                        <div class="row q-col-gutter-lg">
                                            <div
                                                class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                                            >
                                                <h6 class="q-mb-sm text-white">
                                                    {{ slide.title }}
                                                </h6>
                                                <div
                                                    v-html="slide.description"
                                                ></div>
                                            </div>
                                            <div
                                                class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                                            >
                                                <video-player
                                                    :src="`${$page.props.public_path}media/${slide.video}`"
                                                    :poster="
                                                        slide.poster
                                                            ? `${$page.props.public_path}images/posters/${slide.poster}`
                                                            : null
                                                    "
                                                    aspectRatio="1:1"
                                                    :volume="0.6"
                                                    controls
                                                    class="full-width"
                                                    :options="{
                                                        controlBar: {
                                                            pictureInPictureToggle:
                                                                !Screen.xs,
                                                        },
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </q-card-section>
                                </q-card>
                            </div>
                        </div>
                    </q-carousel-slide>
                </q-carousel>
                <div class="column full-width">
                    <p class="text-center">
                        lo que vivimos puede mostrarnos que sigue dirigiendo
                        nuestra manera de sentir, reaccionar y <br />
                        elegir... y abrirnos la posibilidad de vivir cada vez
                        mas desde nosotros mismos
                    </p>
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
import { computed, ref } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { usePage, Head } from "@inertiajs/vue3";
import ListCategoryComponent from "../../components/landing/ListCategoryComponent.vue";
import FilesCategoryComponent from "../../components/landing/FilesCategoryComponent.vue";
import FormTestimonyComponent from "../../components/landing/FormTestimonyComponent.vue";
import PublicationsMsgComponent from "../../components/modules/pushmessage/PublicationsMsgComponent.vue";
import FormSubscriptionComponent from "../../components/landing/FormSubscriptionComponent.vue";
import { useQuasar, date, Screen } from "quasar";

import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

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

const slide = ref("style-0");

const slides = [
    {
        title: "POR QUE NOS EMOCIONA TANTO QUE ALGUIEN NOS DIGA ESTOY ORGULLOSO DE TI?",
        description:
            "cuando aprendimos a buscar amor, reconocimiento y aprobacion fuera, podemos seguir necesitandolos mucho despues de haber dejado de ser niños",
        video: "la frase que todos necesitamos oír.mp4",
    },
    {
        title: "NADIE TIENE TIEMPO PARA VERTE… Y TU TAMPOCO",
        description:
            "cuando aprendemos a medir nuestro valor a traves de la mirada de los demas, podemos pasar la vida comparandonos sin llegar a mirarnos realmente",
        video: "nadie tiene tiempo para verte… y tu tampoco.mp4",
    },
    {
        title: "ASI SE PROGRAMA UN SER HUMANO",
        description:
            "como nuestras primeras experiencias van construyendo respuestas, creencias y patronesq ue pueden seguir funcionando automaticamente mucho despues de la infancia",
        video: "3. VIDEO 1 - asi se programa un ser humano.mp4",
        poster: "3. VIDEO 1 - asi se programa un ser humano.jpg",
    },
    {
        title: "CUANDO AGRADAR A LOS DEMAS HACE QUE DEJEMOS DE ESCUCHARNOS",
        description:
            "podemos aprender a adaptarnos para sentirnos queridos hasta convertir esa forma de proteger el vinculo en una manera automatica de relacionarnos y vivir",
        video: "4. minivídeo 4-    people pleasing y perdida de identidad.mp4",
        poster: "4. minivídeo 4-    people pleasing y perdida de identidad.jpg",
    },
    {
        title: "EL INCONSCIENTE: LO QUE APRENDIMOS ANTES DE PODER ELEGIR",
        description:
            "antes de poder cuestionar lo que viviamos, ya estabamos aprendiendo de las miradas, los silencios, la tension, la ternura, el miedo o la exigencia que nos rodeaban",
        video: "5. VIDEO 2 - el inconsciente el libro en blanco donde se graba todo.mp4",
        poster: "5. VIDEO 2 - el inconsciente el libro en blanco donde se graba todo.jpg",
    },
    {
        title: "CUANDO EL PASADO SIGUE REACCIONANDO EN EL PRESENTE",
        description:
            "una herida puede pertenecer al pasado y seguir apareciendo hoy en nuestras reacciones, miedos, necesidades y formas automaticas de protegernos",
        video: "6. reel 9 - herida y presente.mp4",
        poster: "6. reel 9 - herida y presente.jpg",
    },
    {
        title: "TU CUERPO RECUERDA LO QUE TU MENTE OLVIDA",
        description:
            "podemos haber olvidado o comprendido una experiencia y seguir reaccionando a ella a traves de emociones, tension corporal y respuestas automaticas",
        video: "7. reel 5 - tu cuerpo recuerda lo que tu mente olvida.mp4",
        poster: "7. reel 5 - tu cuerpo recuerda lo que tu mente olvida.jpg",
    },
    {
        title: "LO QUE VIVISTE EXPLICA, NO DETERMINA",
        description:
            "comprender de donde vienen nuestras reacciones no las transforma automaticamente, pero nos permite empezar a ver aquello que antes actuaba sin que nos dieramos cuenta",
        video: "8. video 4 - lo que viviste explica, no determina.mp4",
        poster: "8. video 4 - lo que viviste explica, no determina.jpg",
    },
    {
        title: "POR QUE COMPRENDER LO QUE TE PASA NO SIEMPRE BASTA",
        description:
            "podemos saber de donde vienen nuestras reacciones y seguir respondiendo desde ellas: transformar implica comprender, sentir y empezar a vivir fuera del programa",
        video: "Narcisismo y dependencia emocional.mp4",
    },
    {
        title: "LO QUE VIVES TAMBIEN PUEDE HABLARTE DE TI",
        description:
            "nuestras reacciones, relaciones y elecciones pueden convertirse en espejos desde los que descubrir lo que todavia nos gobierna y ampliar nuestra forma de mirar la vida",
        video: "10. el espejo del mundo lo que el alma quiere recordar.mp4",
        poster: "10. el espejo del mundo.jpg",
    },
    {
        title: "TE SIENTES MARAVILLOSO?",
        description:
            "puede parecernos arrogante siquiera pensarlo, pero dejar de necesitar que otros confirmen nuestro valor puede llevarnos a recuperar el asombro por quienes somos",
        video: "sentirse maravilloso el destino del alma.mp4",
        poster: "11. sentirse maravilloso el destino del alma.jpg",
    },
];

const groupedSlides = computed(() => {
    const groups = [];
    let increment = Screen.xs || Screen.sm ? 1 : 2;
    for (let i = 0; i < slides.length; i += increment) {
        groups.push(slides.slice(i, i + increment));
    }
    return groups;
});
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
