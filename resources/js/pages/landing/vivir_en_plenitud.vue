<template>
    <Layout title="VIVIR EN PLENITUD">
        <div class="banner bg-primary">
            <div class="row items-center container">
                <div
                    class="col-md-6 col-sm-12 col-xs-12 text-center"
                    style="z-index: 1"
                >
                    <img
                        :src="`${$page.props.public_path}images/team/maria-vivir-en-plenitud.png`"
                        style="width: 50%; z-index: 9999 !important"
                    />
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 text-center">
                    <span
                        class="text-white header-title"
                        style="font-size: 33px; line-height: 1"
                        >LIBERACION EMOCIONAL</span
                    >
                    <br />
                    <span
                        class="text-white text-lowercase"
                        style="font-size: 22px"
                        >la puerta para</span
                    >
                    <br />
                    <span
                        class="text-white header-title"
                        style="font-size: 44px; line-height: 1"
                        >VIVIR EN PLENITUD</span
                    >
                    <br />
                    <span
                        class="text-white text-lowercase"
                        style="font-size: 22px"
                        >con la intervencion directa de dios</span
                    >
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
                    la complejidad de nuestras emociones junto con el desarrollo
                    de nuestra mente es lo que nos hace seres singulares con
                    respecto al resto de la existencia. comprender estas
                    emociones, aceptarlas y liberar el sufrimiento es
                    fundamental para trascender nuestra personalidad y alcanzar
                    la existencia en plenitud
                </p>
                <p>
                    vive en plenitud una persona que consigue equilibrar la
                    trilogia cuerpo_mente_dios, por lo que dialogar con dios es
                    un requisito para vivir en plenitud y asi me lo ha dicho de
                    forma directa dios que fue quien me insto a escribir este
                    libro
                </p>
                <p>
                    todo lo que digo en este libro esta directamente inspirado
                    por dios a traves de mi pensamiento que fue guiado en todo
                    momento por el/ella/ello. despertar es hablar con dios, es
                    tener la certeza de que tu eres dios en accion, dios
                    materializado a traves de ti, que tu eres el instrumento de
                    dios para experimentarse a si mismo a traves de ti
                </p>
                <p>
                    este libro desarrolla a traves de mi propia vivencia el
                    libro de neale donald walsch
                    <em>conversaciones con dios</em>
                </p>
            </div>
            <div class="col-md-6 col-sm-12 text-center">
                <img
                    :src="`${$page.props.public_path}images/books/tree-books.png`"
                    alt="group-image"
                    style="width: 80%"
                />
            </div>
        </div>
        <div class="row container q-py-md">
            <div class="col-md-4 col-sm-12 q-pa-lg">
                <div class="text-center">
                    <img
                        class="blog-img"
                        :src="`${$page.props.public_path}images/books/book-1.png`"
                        style="width: 270px; height: 340px"
                    />
                    <p class="q-mt-sm q-mb-none" style="font-size: 18px">
                        en el tomo 1
                    </p>
                </div>
                <p class="text-justify">
                    abordo la parte mas teorica de como funcionan nuestra mente
                    y nuestras emociones; como existe un dominio emocional sobre
                    la parte recional y como el inconsciente, que comienza a
                    forjarse en nuestra infancia y gestacion, nos condiciona sin
                    darnos cuenta, produciendo nuestros patrones de proteccion y
                    autoengaño para superar los traumas y sinsabores de la vida.
                    en realidad, estoy poniendo las bases para comprender como
                    se gesta nuestra personalidad, llena de programas
                    inconscientes que nos impiden vivir en plenitud y como
                    llegar a desprogramar estos, liberar nuestras emociones y
                    convertir nuestro ego programado por otros, en un ego
                    conectado con nuestra esencia divina
                </p>
                <p class="text-center text-lowercase q-mb-none">SUMARIO</p>
                <span>PARTE I VIVIENDO PLENAMENTE</span>
                <ul class="summary q-mt-none" v-if="!more_book1">
                    <li>cambiemos soy por estoy siendo</li>
                    <li>el cambio</li>
                    <li>mente y sus emociones vinculadas</li>
                    <li>cambiemos soy por estoy siendo</li>
                </ul>
                <div v-if="more_book1">
                    <ul class="summary q-mt-none">
                        <li>el cambio</li>
                        <li>mente y sus emociones vinculadas</li>
                        <li>la adiccion de nuestras emociones</li>
                        <li>
                            la tirania de nuestra mente, el estado perpetuo de
                            cavilacion
                        </li>
                        <li>el cerebro</li>
                        <li>
                            la union entre lo que pensamos, lo que nos
                            emocionamos y nuestra salud
                        </li>
                        <li>el temor que nos impide vivir en plenitud</li>
                        <li>la rabia</li>
                        <li>la sutil diferencia entre ego y personalidad</li>
                        <li>el apego</li>
                        <li>lo que es amor y lo que no lo es</li>
                        <li>el despertar</li>
                        <li>vivir en plenitud, la verdadera felicidad</li>
                        <li>Introspectar no es liberar</li>
                        <li>
                            los pasos que dar para desprogramarnos hasta vivir
                            en plenitud
                        </li>
                        <ul class="summary">
                            <li>focalizate</li>
                            <li>manten una atencion plena constante</li>
                            <li>manten el rumbo</li>
                            <li>libera emocionalmente para desprogramar</li>
                            <li>
                                utiliza los espejos para descubrir tus programas
                                inconscientes
                            </li>
                        </ul>
                    </ul>
                    <span>PARTE II ERES CREADOR DE TU REALIDAD</span>
                    <ul class="summary q-mt-none">
                        <li>creamos nuestra vida en un mundo de relatividad</li>
                        <li>todo es energia, todo es dios</li>
                        <li>
                            principios de la energia, principios de creacion
                        </li>
                        <li>porque vivimos realidades que no nos gustan?</li>
                    </ul>
                    <span>PARTE III LOS ESPEJOS</span>
                    <ul class="summary q-mt-none">
                        <li>espejos emocionales</li>
                        <ul class="summary">
                            <li>espejo numero uno: las personas</li>
                            <li>
                                espejo numero dos, nuestras cosas personalísimas
                            </li>
                            <li>
                                espejo numero tres: nuestros juicios y opiniones
                            </li>
                            <li>
                                espejo numero cuatro, la enfermedad el cuerpo,
                                la postura corporal
                            </li>
                            <li>espejo numero cinco: otros</li>
                        </ul>
                        <li>espejos por creacion de nuestra realidad</li>
                    </ul>
                </div>
                <div class="text-center">
                    <q-btn
                        color="black"
                        :label="more_book1 ? 'leer menos' : 'leer mas'"
                        no-caps
                        rounded
                        @click="more_book1 = !more_book1"
                    >
                        <q-icon
                            name="fa fa-long-arrow-left"
                            size="xs"
                            class="q-ml-md"
                            v-if="more_book1"
                        />
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                            v-else
                        />
                    </q-btn>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 q-pa-lg">
                <div class="text-center">
                    <img
                        class="blog-img"
                        :src="`${$page.props.public_path}images/books/book-2.png`"
                        style="width: 320px; height: 340px"
                    />
                    <p class="q-mt-sm q-mb-none" style="font-size: 18px">
                        en el tomo 2
                    </p>
                </div>
                <p class="text-justify">
                    reflexiono sobre distintos temas que todos compartimos y
                    sobre los que podemos pensar muy distinto segun lo que
                    hayamos vivido, nuestras circunstancias y programaciones.
                    tambien son temas que estan en constante evolucion historica
                    y, por tanto, son reflexiones enfocadas en provocar que
                    pienses sobre estos asuntos y que aprendas de este modo a
                    flexibilizar tu mente, sobre la base de que existen muy
                    pocas verdades absolutas y que las creencias pertenecen al
                    instante que vivamos, de ahi la expresion de necesitar
                    aprender a vivir presentes. como ultima parte de este tomo
                    tengo una conversacion directa con dios con la finalidad de
                    que te atrevas a hablar de forma directa con el/ella/ello
                    mostrandote el camino que yo emprendi para poder hacerlo
                </p>
                <p class="text-center text-lowercase q-mb-none">SUMARIO</p>
                <span>PARTE IV REFLEXIONES</span>
                <ul class="summary q-mt-none" v-if="!more_book2">
                    <li>de atea a estar segura de la existencia de dios</li>
                    <li>salud y enfermedad</li>
                </ul>
                <div v-if="more_book2">
                    <ul class="summary q-mt-none">
                        <li>de atea a estar segura de la existencia de dios</li>
                        <li>salud y enfermedad</li>
                        <li>ecologia y alimentacion</li>
                        <li>sexualidad y amor de pareja</li>
                        <li>familia, maternidad y paternidad</li>
                        <li>dinero y riqueza</li>
                        <li>
                            el miedo a vivir, el miedo a morir y el miedo a
                            sufrir
                        </li>
                        <li>soledad y desamor</li>
                        <li>la necesidad de perfeccionismo</li>
                        <li>la culpa y la vergüenza</li>
                    </ul>
                    <span>
                        PARTE V ALGUNAS PREGUNTAS QUE LE HE HECHO A DIOS Y HE
                        AQUI SUS RESPUESTAS
                    </span>
                </div>
                <div class="text-center">
                    <q-btn
                        color="black"
                        :label="more_book2 ? 'leer menos' : 'leer mas'"
                        no-caps
                        rounded
                        @click="more_book2 = !more_book2"
                    >
                        <q-icon
                            name="fa fa-long-arrow-left"
                            size="xs"
                            class="q-ml-md"
                            v-if="more_book2"
                        />
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                            v-else
                        />
                    </q-btn>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 q-pa-lg">
                <div class="text-center">
                    <img
                        class="blog-img"
                        :src="`${$page.props.public_path}images/books/book-3.png`"
                        style="width: 270px; height: 340px"
                    />
                    <p class="q-mt-sm q-mb-none" style="font-size: 18px">
                        en el tomo 3
                    </p>
                </div>
                <p class="text-justify">
                    te propongo ejercicios y recursos para que puedas trabajar
                    tu desarrollo personal, para que puedas reflexionar y
                    aprender tecnicas que te ayudaran a desprogramarte y a
                    liberar emocionalmente
                </p>
                <p class="text-center text-lowercase q-mb-none">SUMARIO</p>
                <span
                    >PARTE VI EJERCICIOS, RECURSOS Y ACTIVIDADES PARA PRACTICAR
                    Y APRENDER A DESPROGRAMARTE POR COMPLETO</span
                >
                <ul class="summary q-mt-none" v-if="!more_book3">
                    <li>
                        significado de las principales dolencias y enfermedades
                    </li>
                    <li>desprogramacion creencias. ejemplo con el dinero</li>
                    <ul class="summary">
                        <li>tapping</li>
                        <li>regresion</li>
                    </ul>
                    <li>
                        asertividad para resolver conflictos. ejemplo con la
                        relacion de pareja
                    </li>
                    <li>
                        trabajo de profundizacion y liberacion de nuestro estado
                        emocional. ejemplo con el sentimiento de soledad y
                        analisis de la codependencia
                    </li>
                    <li>
                        como llegar a nuestra verdad profunda. ejemplo con la
                        necesidad de tener razon y otros apegos
                    </li>
                </ul>
                <div v-if="more_book3">
                    <ul class="summary q-mt-none">
                        <li>
                            significado de las principales dolencias y
                            enfermedades
                        </li>
                        <li>
                            desprogramacion creencias. ejemplo con el dinero
                        </li>
                        <ul class="summary">
                            <li>tapping</li>
                            <li>regresion</li>
                        </ul>
                        <li>
                            asertividad para resolver conflictos. ejemplo con la
                            relacion de pareja
                        </li>
                        <li>
                            trabajo de profundizacion y liberacion de nuestro
                            estado emocional. ejemplo con el sentimiento de
                            soledad y analisis de la codependencia
                        </li>
                        <li>
                            como llegar a nuestra verdad profunda. ejemplo con
                            la necesidad de tener razon y otros apegos
                        </li>
                        <li>
                            trabajo para reflexionar sobre lo que estoy viviendo
                            y como me siento, a donde quiero dirigirme, que
                            puedo mejorar y como quiero acabar sintiendome
                        </li>
                        <li>
                            detecta como te sientes a traves de los espejos que
                            pasan en tu dia a dia
                        </li>
                        <li>crear nuestra realidad. tecnicas y ayudas</li>
                        <li>profundizacion a traves de lo que vamos creando</li>
                        <li>valor personal, autoestima, autoconfianza</li>
                        <li>
                            trabajamos el ego, la personalidad, nuestros
                            patrones
                        </li>
                        <li>trabajemos la rabia</li>
                    </ul>
                </div>
                <div class="text-center">
                    <q-btn
                        color="black"
                        :label="more_book3 ? 'leer menos' : 'leer mas'"
                        no-caps
                        rounded
                        @click="more_book3 = !more_book3"
                    >
                        <q-icon
                            name="fa fa-long-arrow-left"
                            size="xs"
                            class="q-ml-md"
                            v-if="more_book3"
                        />
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                            v-else
                        />
                    </q-btn>
                </div>
            </div>
        </div>
        <div
            class="column bg-primary text-center text-white q-mt-xl"
            style="padding-left: 17%; padding-right: 17%"
        >
            <p class="text-center text-bold q-pt-md">
                tienes mi libro? <br />
                accede a mas contenido exclusivo!
            </p>
            <p class="text-center">
                disfruta de todo el libro en video, leido por mi, dentro del
                area privada <br />descarga plantillas y recursos para practicar
                <br />
                conectate con otras personas y accede a contenido nuevo con el
                tiempo
            </p>
            <p class="text-center">
                <span class="text-bold">para ingresar necesitas</span> <br />
                nombre completo <br />email <br />datos de compra (nombre del
                comprador, fecha, ticket/factura)
            </p>
            <p class="text-center">
                📢 mas adelante, te pedire una reseña para ayudar a expandir
                este mensaje
            </p>
            <p class="text-center text-bold">
                solo una persona por compra puede registrarse
            </p>

            <div class="text-center q-pb-md">
                <q-btn
                    no-caps
                    label="me registro!"
                    color="black"
                    rounded
                    @click="router.get('/contactame')"
                />
            </div>
        </div>
        <div class="row container q-py-md items-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                <img
                    :src="`${$page.props.public_path}images/team/maria1.png`"
                    alt="group-image"
                    style="width: 40%"
                />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="column text-center">
                    <h4
                        class="q-my-none"
                        style="font-size: 26px; line-height: 1.22"
                    >
                        TODAVIA NO HAS LEIDO <br />
                        MI LIBRO?
                    </h4>
                    <p class="q-my-none">podras comprarlo aqui</p>
                    <div>
                        <q-btn
                            href="https://www.amazon.es/dp/B0DJG45MMK?binding=paperback&ref=dbs_dp_sirpi"
                            target="_blank"
                            rounded
                            label="ir a tienda"
                            color="black"
                            no-caps
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row container bg-primary text-white q-pa-lg" id="subscribe">
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
                    🎁 nuevas perspectivas sobre los temas de mi libro<i>
                        liberacion emocional</i
                    ><br />
                    🎁 mensajes y enseñanzas que no comparto en redes<br />
                    🎁 claves esenciales para vivir en plenitud y reconocer la
                    intervencion de dios en tu vida
                </p>
                <p class="q-mx-sm q-mt-md">
                    <b>regalo por suscripcion</b><br />
                    un <b>test rapido</b> para identificar tus enemigos del
                    aprendizaje<br />
                    una <b>guia en PDF</b> con estrategias para liberar tu mente
                    y aprender sin miedo<br />
                    acceso exclusivo a <b>contenido indito de mi libro</b>
                    <i> liberación emocional</i>
                </p>
                <p class="q-mx-sm q-mt-md">
                    unete ahora y empieza tu camino hacia la plenitud!
                </p>
            </div>
            <div class="col-md-6">
                <iframe
                    src="https://fa479f52.sibforms.com/serve/MUIFAOQ-uk0Xiu3xqyoC2onXPMQOkM6fJioTdRUKeVBvCXn5pT1XEpfF2eNRj-6yo1D1SyktllOlDPnT0JdOLq9x0a-zeXwhx5QcC395GGXNObgePLhWEpyI9FzmHUcAQdVq2dqh-M2WAXmsxFicH-aLYcJzXqSlzYsGXoAXChf8pk8eQmcHNX1hg1AzEt5U7CCt4lcH3dJEn3xy"
                    frameborder="0"
                    scrolling="auto"
                    allowfullscreen
                    style="
                        display: block;
                        margin-left: auto;
                        margin-right: auto;
                        max-width: 100%;
                        width: 100%;
                        height: 100%;
                    "
                ></iframe>
            </div>
        </div>
    </Layout>

    <!-- <subscription-test /> -->
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import SubscriptionTest from "../../components/landing/SubscriptionTest.vue";

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
