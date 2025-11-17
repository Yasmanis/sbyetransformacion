<template>
    <Head>
        <title>
            María Garriga Domínguez – Sbye Transformación | Liberación emocional
            y consciencia
        </title>
        <meta
            name="description"
            content="Conoce la historia real detrás del libro Liberación emocional. María Garriga comparte su proceso de transformación interior y cómo aprendió a escuchar la voz de Dios a través de la vida.
"
        />
        <meta
            name="keywords"
            content="maría garriga domínguez, liberación emocional, historia real, consciencia, dios nos habla"
        />
    </Head>
    <Layout title="maria">
        <div class="row container bg-primary items-center text-white">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                <div class="container-img-right">
                    <img
                        :src="`${$page.props.public_path}images/team/maria-maria.png`"
                        alt="group-image"
                        style="width: 50%"
                    />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                <p class="text-center header-subtitle">
                    no soy lo importante aqui...<br />
                    lo importante es el mensaje<br />
                    que dios quiere darte<br />
                    a traves de mi
                </p>
            </div>
        </div>
        <div class="row q-pt-xl container">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="column">
                    <p class="text-justify">hola! soy maria garriga</p>
                    <p class="text-justify">
                        no creo que lo mas importante en esta web sea hablar de
                        mi, pero se que es lo que esperas encontrar aqui. lo
                        verdaderamente relevante es el libro que dios ha
                        inspirado en mi para escribir. mi vida ha sido el camino
                        que me llevo a poder contarlo, porque dios me creo con
                        esta intencion: vivirlo para poder transmitirlo
                    </p>
                    <p class="text-justify">
                        no soy mas especial que tu, todos somos dios en accion,
                        todos somos instrumentos suyos para experimentarse a si
                        mism@. simplemente, mi diseño tiene este proposito
                    </p>
                    <p class="text-justify">
                        naci en carballiño, ourense, en 1973, en una familia
                        tradicional y con una educacion dividida entre colegios
                        religiosos y un entorno ateo. creci entre contrastes y
                        experiencias que marcaron mi camino. fui directora
                        bancaria, estudie diversas disciplinas desde economia
                        hasta naturopatia y sanacion, y mi vocacion siempre ha
                        sido comprender la vida en profundidad
                    </p>
                    <p class="text-justify">
                        pero lo realmente importante no es lo que he hecho, sino
                        lo que he descubierto: la certeza absoluta de que dios
                        existe y nos habla todo el tiempo. hoy vivo plenamente,
                        con la conviccion de que podemos recordar quienes somos
                        y transformar nuestra realidad
                    </p>
                    <p class="text-justify">
                        si quieres conocer mas, te invito a ver mi historia
                    </p>
                </div>
            </div>
            <div
                class="col-md-6 col-lg-6 col-sm-12 col-xs-12 q-pa-lg text-center"
            >
                <video-player
                    :src="`${$page.props.public_path}media/asi fue mi despertar.mp4`"
                    controls
                    aspectRatio="4:3"
                    :volume="0.6"
                />
            </div>
        </div>
        <div
            class="row container bg-primary q-pt-lg"
            v-if="groupedSlides.length === 0"
        >
            <div class="row">
                <h6 class="text-center text-white q-mb-sm">
                    UNA MUESTRA DE LO QUE QUIERO COMPARTIR CONTIGO
                </h6>
                <p class="text-white">
                    durante años vivi creyendo que la suerte y las
                    circunstancias decidian por mi pero <br />
                    cuando descubri que mis heridas y creencias eran las que
                    realmente estaban creando mi realidad, todo cambio<br />
                    aprender a soltar, liberar y confiar me llevo a crear desde
                    el alma, sin miedo, sin autoengaño <br />hoy acompaño a
                    otros a hacer lo mismo: a crear su vida conscientemente, con
                    sentido, alegria y verdad
                </p>
            </div>
            <q-carousel
                v-model="slide"
                swipeable
                animated
                arrows
                padding
                navigation
                :prev-icon="`img:${$page.props.public_path}images/icon/left.png`"
                :next-icon="`img:${$page.props.public_path}images/icon/right.png`"
                class="bg-primary"
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
                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                        >
                            <q-card
                                class="my-card rounded-borders"
                                style="border-radius: 30px !important"
                            >
                                <q-card-section class="q-pa-xl">
                                    <div class="row q-col-gutter-lg">
                                        <div
                                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-primary"
                                        >
                                            <h6 class="q-mb-sm text-primary">
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
                                                controls
                                                aspectRatio="1:1"
                                                :volume="0.6"
                                                class="full-width"
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
                <p class="text-center text-white">
                    cada experiencia, cada vinculo y cada sombra nos invita a
                    recordar <br />
                    que el verdadero amor comienza en nosotros
                </p>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { computed, ref } from "vue";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

defineOptions({
    name: "Maria",
});

const slide = ref("style-0");

const slides = [
    {
        title: "DEPENDENCIA EMOCIONAL",
        description:
            "por qué nacemos dependientes cómo se nos programa y por qué cortar ese “cordón invisible” es clave para amarnos",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "NADIE TIENE TIEMPO PARA VERTE… Y TU TAMPOCO",
        description:
            "a raíz de la comparacion y la busqueda de reconocimiento que nos aleja de nosotros mismos",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "REMEMBRAR: DE LA DEPENDENCIA A LA UNION DIVINA",
        description:
            "cuando dejamos de buscar dios habita en nosotros y en los demas",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "SENTIRSE MARAVILLOSO: EL DESTINO DEL ALMA",
        description:
            "el reencuentro con la propia divinidad y la aceptación profunda de lo que somos",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "EL ESPEJO DEL MUNDO: LO QUE EL ALMA QUIERE RECORDAR",
        description:
            "la comprensión más alta: lo que vivimos fuera refleja lo que aún no hemos recordado dentro",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "COMO ACTUA UN NARCISISTA (Y POR QUE CAEMOS EN SU JUEGO)",
        description:
            "como se forma su personalidad y por qué atrae a quienes dudan de sí mismos",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "COMO ES UN NARCISISTA",
        description:
            "las señales que lo delatan, la fragilidad que esconde y la herida que lo origina <br> cuando entiendes su vacío, dejas de tomarte su conducta como algo personal",
        video: "asi fue mi despertar.mp4",
    },
    {
        title: "AMARSE NO ES SER NARCISISTA",
        description:
            "diferenciar entre el amor propio y el ego inflado <br> amarte es escucharte, respetarte y vivir desde el alma, no desde la herida",
        video: "asi fue mi despertar.mp4",
    },
];

const groupedSlides = computed(() => {
    const groups = [];
    for (let i = 0; i < slides.length; i += 2) {
        groups.push(slides.slice(i, i + 2));
    }
    return groups;
});
</script>
<style scope>
.bg-mariposas {
    background-image: url("images/others/cambio-transformacion.png");
    background-repeat: no-repeat;
    background-size: 66%;
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
