<template>
    <Layout :header="false">
        <div class="banner bg-primary q-pt-lg">
            <div class="row" v-if="landing.logo">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <img
                        :src="`${$page.props.public_path}images/logo/1.png`"
                        width="180px"
                    />
                </div>
            </div>
            <div class="row">
                <div
                    class="col-md-5 col-sm-12 col-xs-12 text-center"
                    style="z-index: 1"
                >
                    <img
                        :src="landing.image_path"
                        style="width: 50%; z-index: 9999 !important"
                    />
                </div>
                <div
                    class="col-md-7 col-sm-12 col-xs-12 text-center text-white"
                >
                    <span v-html="landing.text"></span>
                </div>
            </div>
            <div
                class="wave overflow-hidden"
                :style="{
                    'margin-top': !screen.xs && !screen.sm ? '-130px' : '',
                }"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 1000 100"
                    preserveAspectRatio="none"
                    class="d-block position-relative"
                >
                    <path
                        class="elementor-shape-fill"
                        d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
            c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
            c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"
                    ></path>
                </svg>
            </div>
        </div>

        <div
            class="row items-center container q-py-xl bg-white"
            style="margin-top: -5px"
        >
            Intercalar secciones
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import {
    ref,
    computed,
    watch,
    onMounted,
    onUnmounted,
    onBeforeMount,
} from "vue";
import { useQuasar, dom, Screen } from "quasar";

import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import { useForm, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "VivirEnPlenitud",
});

const $q = useQuasar();
const { height, css, ready } = dom;

const images = ref([
    {
        title: "🌪️ ETAPA 1: LIBERAR EMOCIONES INTENSAS",
        description:
            "aprende a soltar emociones como la rabia, la tristeza o la frustracion <br>ejercicios fisicos y expresivos para liberar lo que el cuerpo guarda",
        image: "background_1.png",
        color: "text-white",
        visible: false,
    },
    {
        title: "🌫️ ETAPA 2: LIBERAR EMOCIONES SUTILES",
        description:
            "conecta con lo que te molesta sin saber por que<br>introspeccion guiada para reconocer señales internas que suelen pasar desapercibidas",
        image: "background_2.png",
        color: "text-black",
        visible: false,
    },
    {
        title: "🧬 ETAPA 3: LIBERAR EMOCIONES INCONSCIENTES",
        description:
            "descubre lo que te duele y aun no sabias<br>herramientas de autoexploracion emocional y regresiva para liberar patrones antiguos",
        image: "background_3.png",
        color: "text-white",
        visible: false,
    },
    {
        title: "🧠 ETAPA 4: DESPROGRAMAR EL EGO",
        description:
            "identifica las creencias que sostienen tu dolor y empieza a soltarlas<br>transforma tu forma de pensar, sentir y actuar desde una mayor conciencia",
        image: "background_4.png",
        color: "text-black",
        visible: false,
    },
    {
        title: "💫 ETAPA 5: VIVIR DESDE TU ESENCIA",
        description:
            "aprende a confiar, a fluir y a vivir sin miedo ni mascaras<br>accede a tu guia interior (llamala intuicion, claridad o dios) y actua en coherencia contigo",
        image: "background_5.png",
        color: "text-black",
        visible: false,
    },
]);

const webTestimonies = ref([]);

const staticTestimonies = [
    {
        user: "Rosa",
        description:
            "me habló directo a mí, como si alguien al fin pusiera en palabras muchas cosas que había sentido pero no sabía cómo entender.",
    },
    {
        user: "Cristina",
        description:
            "desde el principio sentí que este libro hablaba de mí. ya me ha removido muchas cosas y quiero seguir con los otros tomos.",
    },
    {
        user: "Mariluz",
        description:
            "compré el libro tras una conferencia y me encantó. es diferente a todo lo que he leído. además, los vídeos ayudan muchísimo.",
    },
    {
        user: "Silvia",
        description:
            "este libro me abrió a reflexionar sobre aspectos de la vida que nunca había considerado. tengo muchas ganas de seguir con los siguientes",
    },
    {
        user: "Marcos López Garriga",
        description:
            "aunque no lo he leído entero, sé que dice la verdad. lo he vivido en carne propia, y este libro refleja esa voz que me ha transformado",
    },
    {
        user: "testimonio de sesión intensiva (video anterior)",
        description:
            "me ayudó a ver cómo mis emociones están ligadas a mi cuerpo. hoy sé reconocer lo que siento y liberarlo",
    },
];

const imageContainers = ref([]);
const arrowsContainer = ref(null);
const arrowsVisible = ref(false);
const slide = ref(0);
const slidesPerView = ref(4);
const rowsTestimonies = ref(0);

const landing = ref(null);
const product = ref(null);

onBeforeMount(() => {
    landing.value = usePage().props.landing;
    product.value = landing.value.product;
});

onMounted(() => {
    const observer = setupObservers();
    const arrows = arrowsObservers();
    setTestimonyWidth();
    webTestimonies.value = usePage().props.testimonies;

    onUnmounted(() => {
        observer.disconnect();
        arrows.disconnect();
    });
});

watch(
    () => $q.screen.width,
    (w) => {
        setImagesSize();
        setTestimonyWidth();
    }
);

const setTestimonyWidth = () => {
    slidesPerView.value =
        $q.screen.width < 350 ? 1 : parseInt($q.screen.width / 350);
};

const groupedSlides = computed(() => {
    const groups = [];
    for (let i = 0; i < staticTestimonies.length; i += slidesPerView.value) {
        groups.push(staticTestimonies.slice(i, i + slidesPerView.value));
    }
    return groups;
});

ready(function () {
    let div, image;
    for (let i = 1; i <= 5; i++) {
        div = document.getElementById(`background-${i}`);
        image = document.getElementById(`image-${i}`);
        if (div) {
            css(image, {
                height: `${height(div) + 50}px !important`,
            });
        }
    }
});

const setupObservers = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const index =
                    [...entry.target.parentElement.children].indexOf(
                        entry.target
                    ) - 4;
                if (index !== -1) {
                    if (entry.isIntersecting) {
                        images.value[index].visible = true;
                    }
                }
            });
        },
        { threshold: 0.1 }
    );

    imageContainers.value.forEach((el) => {
        if (el) observer.observe(el);
    });

    return observer;
};

const arrowsObservers = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const index =
                    [...entry.target.parentElement.children].indexOf(
                        entry.target
                    ) - 4;
                if (index !== -1) {
                    if (entry.isIntersecting) {
                        arrowsVisible.value = true;
                    }
                }
            });
        },
        { threshold: 0.1 }
    );

    observer.observe(arrowsContainer.value);

    return observer;
};

const screen = computed(() => {
    return $q.screen;
});

function setImagesSize() {
    let div, image;
    for (let i = 1; i <= 5; i++) {
        div = document.getElementById(`background-${i}`);
        image = document.getElementById(`image-${i}`);
        if (div) {
            css(image, {
                height: `${height(div) + 50}px !important`,
            });
        }
    }
}

const getHeight = (id) => {
    let div = document.getElementById(`background-${id}`);
    return div ? `${height(div) + 50}px` : "160px";
};
</script>
<style scoped>
.wave {
    left: 0;
    line-height: 0;
    bottom: -1px;
}

.wave svg {
    width: calc(100% + 1.3px);
    left: 50%;
    transform: translateX(-50%);
}

.position-relative {
    position: relative !important;
}

.d-block {
    display: block !important;
}

svg {
    vertical-align: middle;
}

.z-0 {
    z-index: 0 !important;
}

.w-100 {
    width: 100% !important;
}

.overflow-hidden {
    overflow: hidden !important;
}

.wave .elementor-shape-fill {
    fill: #fff;
    transform-origin: center;
    transform: rotateY(0deg);
}

.image-with-text-container {
    position: relative;
    width: 100%;
}

.responsive-image {
    width: 100%;
    display: block;
}

.text-overlay {
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    padding: 16px;
    background: transparent !important;
}

.text-overlay-centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    width: 80%;
}

.animate__slideInLeft.opacity-animation {
    animation-name: customSlideInLeft;
}

@keyframes customSlideInLeft {
    from {
        transform: translate3d(-100%, 0, 0);
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }
}

/* Para la animación slideInRight con opacidad */
.animate__slideInRight.opacity-animation {
    animation-name: customSlideInRight;
}

@keyframes customSlideInRight {
    from {
        transform: translate3d(100%, 0, 0);
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }
}
</style>
