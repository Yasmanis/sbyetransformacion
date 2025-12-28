<template>
    <Head>
        <title>
            María Garriga Domínguez – Sbye Transformación | Mi enfoque
        </title>
    </Head>
    <Layout title="mi enfoque">
        <div class="row container bg-primary items-center text-white">
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center"
                :class="{
                    'q-pa-xl': !Screen.xs,
                }"
            >
                <img
                    :src="`${$page.props.public_path}images/others/mi_enfoque.png`"
                    alt="group-image"
                    :style="{
                        width: Screen.xs ? '60%' : '50%',
                    }"
                />
            </div>
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center"
                style="font-size: 18px; line-height: 1.5"
            >
                <p class="text-bold">transformar desde dentro</p>
                <p>
                    no trabajo para que gestiones emociones <br />
                    trabajo para que transformes lo que las crea
                </p>
            </div>
        </div>
        <div class="row container q-my-xl">
            <div class="col text-center">
                <p>
                    no cambiamos por pensar distinto <br />
                    cambiamos cuando ademas entendemos lo que sentimos <br />
                    liberamos lo que nos duele <br />
                    y desprogramamos lo que nos limita
                </p>
                <p>
                    mi enfoque une pensamiento + emocion + inconsciente + verdad
                    interior<br />
                    para que puedas vivir desde ti, no desde tu programa
                </p>
            </div>
        </div>
        <div class="row container bg-primary items-center">
            <div
                class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
                :class="Screen.xs || Screen.sm ? ' q-py-xl' : null"
            >
                <h6 class="text-lowercase text-white">
                    los 4 pilares de mi metodo
                </h6>
                <ol class="text-white pilares" style="padding-left: 14px">
                    <li>
                        <b>liberar la emocion atrapada</b> <br />
                        lo que no liberamos, lo repetimos
                    </li>
                    <li>
                        <b>desprogramar creencias y patrones</b> <br />
                        cambiar un pensamiento no cambia tu vida; cambiar el
                        programa, si
                    </li>
                    <li>
                        <b>acceder a tu verdad interior</b><br />
                        ese lugar donde ya sabes lo que necesitas, aunque lo
                        hayas olvidado
                    </li>
                    <li>
                        <b>integracion y accion consciente</b> <br />
                        no basta con liberar. hay que vivir desde lo nuevo
                    </li>
                </ol>
            </div>
            <div
                class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/enfoque_pilares.png`"
                    style="width: 60%; margin-top: -20px; margin-bottom: -20px"
                />
            </div>
        </div>
        <div class="row text-center">
            <div class="col q-py-xl">
                <h6 class="text-lowercase q-mb-md">
                    como funciona el inconsciente
                </h6>
                <p>
                    tu inconsciente es el origen de la mayor parte de tus
                    decisiones <br />
                    tu ego es un conjunto de creencias y conductas programadas
                    desde tu infancia <br />
                    cuando liberas la raiz, tu identidad cambia desde dentro
                </p>
            </div>
        </div>
        <div class="row container bg-primary items-center">
            <div
                class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text-white"
                :class="Screen.xs || Screen.sm ? ' q-py-xl' : null"
            >
                <h6 class="text-lowercase text-white q-mb-md">
                    mi enfoque vs otros enfoques
                </h6>
                <p>
                    no comparo para desacreditar. comparo para que entiendas
                    donde actua cada enfoque y por que mi trabajo se vuelve mas
                    sencillo cuando ya has recorrido parte de este camino
                </p>
                <p>
                    la gestion emocional calma el sintoma <br />
                    la liberacion emocional transforma el origen
                </p>
                <p>
                    la terapia tradicional te ayuda a comprender <br />
                    <i>sbye transformacion</i> te enseña a trascender
                </p>
                <p>
                    el mindset cambia ideas <br />
                    mi enfoque cambia estructuras internas
                </p>
            </div>
            <div
                class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text-center self-end"
                :class="Screen.xs ? '' : 'q-pt-lg'"
            >
                <img
                    :src="`${$page.props.public_path}images/others/diferencia_otros_enfoques.png`"
                    :style="{
                        width: Screen.xs ? '100%' : '60%',
                        'margin-bottom': '-15px',
                    }"
                />
            </div>
        </div>
        <div
            class="row container tems-center"
            :class="Screen.xs ? '' : 'q-pt-lg'"
            style="background-color: #ededed"
        >
            <div
                class="col-md-5 col-lg-5 col-xl-5 col-sm-12 col-xs-12 text-center"
                :class="
                    Screen.xs || Screen.sm ? 'text-center q-pt-xl' : 'self-end'
                "
            >
                <img
                    :src="`${$page.props.public_path}images/others/mariposas_azul_clarito_negro_azulado.png`"
                    :style="{
                        width: !Screen.xs ? '30%' : '40%',
                    }"
                />
            </div>
            <div
                class="col-md-7 col-lg-7 col-xl-7 col-sm-12 col-xs-12"
                :class="Screen.xs || Screen.sm ? ' q-py-xl' : null"
            >
                <h6 class="text-lowercase q-mb-md">
                    para quien es este camino
                </h6>
                <p>es para ti si…</p>
                <ol class="guion-list">
                    <li>
                        sientes que, aunque has leido, reflexionado o hecho
                        terapia, sigues repitiendo lo mismo
                    </li>
                    <li>
                        comprendes muchas cosas de ti, pero no consigues cambiar
                        desde dentro
                    </li>
                    <li>
                        eres sensible, emocional, intensa, o te afecta demasiado
                        lo que vives
                    </li>
                    <li>
                        te cansaste de sobrevivir y quieres empezar a vivir de
                        verdad
                    </li>
                    <li>no quieres depender eternamente de un terapeuta</li>
                    <li>vives ansiedad, bloqueo, confusion o estancamiento</li>
                    <li>
                        no entiendes por que tu vida va por un lado y tu
                        interior por otro
                    </li>
                    <li>
                        te dedicas al desarrollo personal y sientes que
                        necesitas ir mucho mas profundo que todo lo que ya
                        conoces
                    </li>
                </ol>
            </div>
        </div>

        <div
            class="row container tems-center q-py-xl bg-primary text-white"
            style="background-color: #ededed"
        >
            <div
                class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12"
                :class="Screen.xs || Screen.sm ? ' q-py-xl' : null"
            >
                <h6 class="text-lowercase q-mb-md text-white">
                    que puedes esperar
                </h6>
                <ul style="list-style: none; line-height: 40px">
                    <li>claridad</li>
                    <li>direccion</li>
                    <li>liberacion</li>
                    <li>crecimiento real</li>
                    <li>autonomia emocional</li>
                </ul>
            </div>
            <div
                class="col-md-8 col-lg-8 col-xl-8 col-sm-12 col-xs-12 text-center self-center q-pt-lg"
            >
                <img
                    :src="`${$page.props.public_path}images/others/enfoque_camino.png`"
                    style="width: 90%"
                />
            </div>
            <div class="col-12 text-center q-pt-xl">
                <h6 class="text-lowercase q-mb-md text-white">
                    si quieres conocerlo desde dentro
                </h6>
                <q-btn
                    rounded
                    color="black"
                    label="consulta individual"
                    no-caps
                    class="q-mt-md"
                    href="/consulta_individual"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
                <br />
                <q-btn
                    rounded
                    color="black"
                    label="taller online"
                    no-caps
                    class="q-mt-md"
                    href="/taller_online"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { Screen } from "quasar";

defineOptions({
    name: "Maria",
});
</script>
<style scoped>
.pilares li {
    margin-top: 10px;
}
</style>
