<template>
    <Layout>
        <div class="banner bg-primary">
            <div class="row">
                <div
                    class="col-md-5 col-sm-12 col-xs-12 text-center"
                    style="z-index: 1"
                >
                    <img
                        :src="`${$page.props.public_path}images/team/maria-vivir-en-plenitud.png`"
                        style="width: 50%; z-index: 9999 !important"
                    />
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12 text-center">
                    <p class="text-h5 no-margin text-white">
                        LIBERACION EMOCIONAL
                    </p>
                    <p class="text-white">
                        el primer paso hacia tu transformacion interior
                    </p>
                    <p class="text-white q-mt-xl">
                        y si pudieras dejar atras <br />
                        el dolor, las heridas y los bloqueos…<br />
                        y empezar a vivir desde tu verdad mas profunda?
                    </p>
                </div>
            </div>
            <div
                class="wave overflow-hidden"
                :style="{
                    'margin-top': !screen.xs && !screen.sm ? '-100px' : '',
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
            <div class="col-md-6 col-sm-12">
                <p>
                    este minicurso te guia en un proceso practico y profundo
                    para liberar las emociones que aun te atan al pasado,
                    trascender tus heridas y reconectar con lo que tu alma
                    anhela:
                    <b>vivir con autenticidad, alegria, plenitud y libertad</b>
                </p>
                <p>
                    a traves de cinco etapas progresivas, aprenderas a escuchar
                    lo que sientes, soltar lo que duele y abrirte a una nueva
                    forma de vivir. todo desde una guia clara, sencilla, amorosa
                    y profundamente conectada con dios y con tu alma
                </p>
                <div class="col text-center q-mt-xl">
                    <q-btn
                        color="black"
                        label="quiero empezar ahora"
                        no-caps
                        rounded
                    >
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                        />
                    </q-btn>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center">
                <img
                    :src="`${$page.props.public_path}images/books/tree-books.png`"
                    alt="group-image"
                    style="width: 80%"
                />
            </div>
        </div>
        <div class="row bg-primary container text-white items-center">
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 q-py-md"
                :class="!screen.xs ? 'q-pr-md' : null"
            >
                <p class="text-h5">MI HISTORIA: POR QUE NACIO ESTE CURSO</p>
                <p>
                    durante años acompañe a personas a sanar… pero no fue hasta
                    que pase por mi propia transformacion emocional, que
                    comprendi lo esencial:
                    <b>no hay cambio real sin liberar lo que llevamos dentro</b>
                </p>
                <p>
                    este curso nacio de mi camino, de lo que me sirvio a mi y a
                    quienes ya lo han recorrido conmigo
                </p>
                <p>
                    aqui no solo aprenderas herramientas, sino una forma
                    completamente nueva de vivirte
                </p>
            </div>
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 q-py-md text-center"
            >
                imagen
            </div>
        </div>
        <div class="row container q-py-lg">
            <div class="col">
                <p class="text-h6">QUE ENCONTRARAS EN ESTE MINICURSO?</p>
                <p>
                    un recorrido practico y profundo en 5 etapas, para que
                    liberes tu carga emocional y transformes tu forma de sentir,
                    pensar y vivir puedes hacerlo a tu ritmo. cada etapa te
                    invita a soltar una capa mas de lo que ya no te sirve
                    <i
                        >cada paso es un escalon hacia una mayor libertad
                        interna</i
                    >
                </p>
                <p>
                    <img
                        :src="`${$page.props.public_path}images/icon/double-time.png`"
                        style="position: absolute"
                    />
                    cada modulo incluye ejemplos reales, ejercicios practicos y
                    reflexiones que te acompañaran de forma sencilla y cercana
                </p>
            </div>
        </div>
        <div class="row container bg-primary text-white q-py-lg">
            <div class="col">
                <p class="text-h6">ESTO ES LO QUE PUEDES TRANSFORMAR</p>
                <p>no estas aqui por casualidad. este curso te va a ayudar a</p>
                <p>
                    🦋 dejar de reaccionar desde el dolor y empezar a responder
                    desde el amor <br />
                    🦋 reconocer tus heridas y soltar lo que te limita, con
                    compasion y verdad<br />
                    🦋 dejar atras la culpa, la rabia, la tristeza o la
                    sensacion de vacio<br />
                    🦋 convertirte en quien tu alma anhela ser: una persona
                    autentica, libre y plena
                </p>
                <div class="text-center">
                    <q-btn
                        color="black"
                        label="quiero vivir esta transformacion"
                        no-caps
                        rounded
                    >
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                        />
                    </q-btn>
                </div>
            </div>
        </div>
        <div class="row container q-py-lg">
            <div class="col">
                <p class="text-h6">OFERTA ESPECIAL DE LANZAMIENTO: SOLO 19 €</p>
                <p>
                    este curso esta pensado para personas como tu: sensibles,
                    comprometidas, listas para liberarse del dolor y vivir desde
                    su verdad
                </p>
                <p>
                    por eso, durante este lanzamiento, puedes acceder al curso
                    completo + acompañamiento por chat por solo <b>19 €</b> y si
                    en los proximos <b>30 dias</b> compartes tu experiencia
                    <br />
                    <b
                        >te regalo el acceso al plan premium (valorado en 150
                        €)</b
                    >
                    🎁<br />
                    incluye <br />
                    • 3 respuestas personalizadas en video <br />• 1 sesion
                    individual de 1 hora conmigo<br />
                    <b>es mi forma de agradecerte y acompañarte mas de cerca</b>
                    en tu camino hacia la libertad emocional
                </p>
                <hr />
                <p>⏳️ disponible solo por tiempo limitado</p>
                <p>
                    esta propuesta estara activa
                    <b
                        >solo durante los proximos dias o hasta completar el
                        cupo inicial de plazas disponibles</b
                    >
                </p>
                <p>
                    despues, el curso volvera a su precio real y sin esta opcion
                    de regalo
                </p>
                <p>
                    haz clic aqui para unirte ahora y comenzar tu transformacion
                    👇️
                </p>
            </div>
        </div>
        <div class="row container bg-primary text-white q-pa-lg" id="suscribe">
            <div class="col-md-6">
                <h6 class="q-mx-sm q-my-none text-white">
                    DESCUBRE LAS CLAVES PARA VIVIR EN PLENITUD
                </h6>
                <p class="q-mx-sm q-mt-md text-justify">
                    📩 suscribete a mi newsletter exclusiva y accede a
                    reflexiones profundas, enseñanzas ineditas y herramientas
                    practicas para liberarte emocionalmente y conectar con la
                    guia de dios en tu dia a dia
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
                    🎁 un <b>test rapido</b> para identificar tus enemigos del
                    aprendizaje<br />
                    🎁 una <b>guia en PDF</b> con estrategias para liberar tu
                    mente y aprender sin miedo<br />
                    🎁 acceso exclusivo a <b>contenido indito de mi libro</b>
                    <i> liberación emocional</i>
                </p>
                <p class="q-mx-sm q-mt-md">
                    unete ahora y empieza tu camino hacia la plenitud!
                </p>
            </div>
            <div
                class="col-md-6"
                :class="!screen.xs && !screen.sm ? 'q-pl-xl' : ''"
            >
                <form-subscription-component />
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import FormSubscriptionComponent from "../../components/landing/FormSubscriptionComponent.vue";

defineOptions({
    name: "VivirEnPlenitud",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
const more_book1 = ref(false);
const more_book2 = ref(false);
const more_book3 = ref(false);
</script>
<style scope>
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
</style>
