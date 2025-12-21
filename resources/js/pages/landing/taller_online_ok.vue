<template>
    <Layout title="taller online">
        <div class="row container bg-primary items-center">
            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                <img
                    :src="`${$page.props.public_path}images/team/maria-taller-online.png`"
                    class="rounded"
                    style="width: 60%"
                />
            </div>
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 self-center text-center text-white"
                style="font-size: 18px; line-height: 1.5"
            >
                <p class="text-bold">3 meses de transformacion real</p>
                <p class="text-center q-mb-xl">
                    vive un proceso profundo, acompañado, continuo libera,
                    desprograma y aprende a guiarte por ti mismo
                </p>
                <q-btn
                    rounded
                    color="black"
                    label="quiero reservar plaza"
                    no-caps
                    class="q-mt-md"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
            </div>
        </div>
        <div class="row container tems-center q-py-xl">
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
            >
                <h6 class="text-lowercase q-mb-md">
                    que es este taller y por que es diferente
                </h6>
                <p>
                    este taller no es un curso grabado ni un espacio teoricocomo
                    trabajaremos juntos
                </p>
                <p>
                    es un proceso de 3 meses, en vivo, donde trabajamos juntos
                    tu programa interno: emociones atrapadas, creencias
                    heredadas, patrones inconscientes y tu verdad profunda
                </p>
                <p>
                    cada semana tendras <b>dos reuniones en grupo </b>para
                    practicar:
                </p>
                <ol class="guion-list">
                    <li>liberacion emocional</li>
                    <li>desprogramacion de creencias</li>
                    <li>reflexion profunda</li>
                    <li>observacion del inconsciente</li>
                    <li>lectura interna</li>
                </ol>
                <p>
                    tu haras los ejercicios en casa, pero los integramos juntos,
                    paso a paso
                </p>
                <p><b>ademas:</b></p>
                <p>
                    cada mes tendremos
                    <b>una consulta individual profunda</b> para avanzar en lo
                    personal
                </p>
            </div>
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 self-center text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/taller_online_personas_conectadas.png`"
                    style="width: 60%"
                />
            </div>
        </div>
        <div class="row container tems-center bg-primary text-white q-py-xl">
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 self-center text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/camino_transformacion_interior.png`"
                    style="width: 60%"
                />
            </div>
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
            >
                <h6 class="text-lowercase q-mb-md text-white">como trabajo?</h6>
                <q-list>
                    <q-item v-for="w in workList" :key="`work-${w.title}`">
                        <q-item-section avatar>
                            <q-icon
                                size="lg"
                                :name="`img:${$page.props.public_path}images/icon/${w.icon}`"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label class="text-bold">{{
                                w.title
                            }}</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
        <div class="row container q-py-xl">
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
            >
                <h6 class="text-lowercase q-mb-md">para quien es</h6>
                <p>este taller es para ti si…</p>
                <ol class="guion-list">
                    <li>has trabajado en ti pero sigues repitiendo patrones</li>
                    <li>entiendes tus heridas pero no consigues cambiarlas</li>
                    <li>
                        eres sensible y te cuesta gestionar tu mundo interno
                    </li>
                    <li>quieres dejar de sobrevivir y empezar a vivir</li>
                    <li>sientes ansiedad, bloqueo o falta de direccion</li>
                    <li>buscas un camino profundo, sin superficialidad</li>
                    <li>
                        eres terapeuta y quieres aprender a acompañar desde lo
                        profundo
                    </li>
                    <li>
                        deseas autonomia emocional real y no depender de nadie
                    </li>
                </ol>
            </div>
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 self-center text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/mariposas_azul_clarito_negro_azulado.png`"
                    style="width: 30%"
                />
            </div>
        </div>
        <div class="row container bg-primary q-py-xl">
            <div class="col-12 text-center">
                <h6 class="text-lowercase q-mb-md text-white">
                    ejemplo real del trabajo
                </h6>
                <p class="text-white">
                    estos fragmentos anonimizados pertenecen a informes reales
                    entregados tras sesiones individuales <br />
                    muestran el tipo de profundidad emocional y comprension
                    interna que alcanzaras durante el taller
                </p>
            </div>
            <div
                v-for="(t, imgIndex) in informes"
                :key="imgIndex"
                class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 q-pa-md"
            >
                <q-card
                    class="my-card"
                    style="border-radius: 55px; min-height: 390px"
                >
                    <q-card-section class="text-center">
                        <q-img
                            :src="`${$page.props.public_path}images/icon/icono_mariposa_informes.png`"
                            fit="fill"
                            width="60px"
                        />
                    </q-card-section>
                    <q-card-section>
                        "<span v-html="t.description"></span>"
                    </q-card-section>
                    <q-card-actions
                        style="
                            position: absolute;
                            bottom: 5px;
                            width: 100%;
                            padding-right: 30px;
                        "
                        ><p class="text-right full-width">
                            {{ t.title }}
                        </p></q-card-actions
                    >
                </q-card>
            </div>
            <div class="col-12 text-center">
                <p class="text-white q-pt-md">
                    puedes ver informes completos en publicaciones
                </p>
                <q-btn
                    rounded
                    color="black"
                    label="ver informes completos"
                    no-caps
                    class="q-mt-md"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
            </div>
        </div>
        <div class="row container">
            <div class="col-12">
                <h6 class="text-lowercase q-mb-md text-white">
                    convertirte en facilitador
                </h6>
                <p>quieres formarte como facilitador de procesos personales?</p>
                <p>
                    si completas este taller y deseas continuar, trabajaremos de
                    forma individual <br />
                    una vez al mes hasta que integres todo el metodo
                </p>
                <p>
                    no es una formacion oficial, pero si un entrenamiento real,
                    profundo y <br />
                    supervisado
                </p>
                <p>
                    contaras siempre con mi apoyo, mi mirada y mi acompañamiento
                    personal
                </p>
                <p>
                    al finalizar, recibiras tu titulo de facilitador de procesos
                    personales firmado <br />
                    por mi
                </p>
            </div>
            <div class="col-12">
                <hr style="height: 1px" class="bg-grey-6" />
            </div>
        </div>
        <div class="row container q-pb-lg q-col-gutter-xl q-py-lg">
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 self-center"
            >
                <div
                    class="column"
                    :class="Screen.xs ? 'items-center' : 'items-end'"
                >
                    <q-card
                        class="my-card q-px-md"
                        flat
                        style="
                            border-radius: 55px;
                            border: 3px solid #407492;
                            width: 400px;
                        "
                    >
                        <q-card-section class="text-center q-pa-none">
                            <img
                                :src="`${$page.props.public_path}images/others/euro.png`"
                                style="
                                    width: 50px;
                                    height: 50px;
                                    margin-top: 30px;
                                "
                            />
                            <q-card-section>
                                <p><b>taller online de 3 meses</b></p>
                                <p>
                                    2 sesiones grupales semanales en vivo <br />
                                    1 consulta individual mensual <br />
                                    informe personalizado <br />
                                    acompanamiento entre sesiones <br />
                                    practicas guiadas y ejercicios reales <br />
                                    espacio seguro y reducido (10 personas)
                                </p>
                                <p class="text-bold q-mb-none">300 €</p>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 self-center"
            >
                <div
                    class="column"
                    :class="Screen.xs ? 'items-center' : 'items-start'"
                >
                    <q-card
                        class="my-card q-px-md"
                        flat
                        style="
                            border-radius: 55px;
                            border: 3px solid #407492;
                            width: 400px;
                        "
                    >
                        <q-card-section class="text-center q-pa-none">
                            <img
                                :src="`${$page.props.public_path}images/others/contactos.png`"
                                style="
                                    width: 50px;
                                    height: 50px;
                                    margin-top: 30px;
                                "
                            />
                            <q-card-section>
                                <p><b>quieres reservar?</b></p>
                                <p>
                                    no hay reserva automatica porque <br />
                                    me gustaria escuchar tu necesidad <br />
                                    tu momento y tu disponibilidad
                                </p>
                                <q-btn
                                    rounded
                                    color="black"
                                    label="cuentame lo que necesitas"
                                    no-caps
                                    class="q-my-lg"
                                >
                                    <q-icon
                                        name="fa fa-long-arrow-right"
                                        class="q-ml-md"
                                    />
                                </q-btn>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
        <div class="row container bg-primary text-white text-center q-py-xl">
            <div class="col">
                <p>
                    no necesitas repetir mas tu historia <br />
                    ni tus heridas <br />
                    ni tus patrones
                </p>
                <p>
                    puedes transformarlo<br />
                    y puedes hacerlo ahora
                </p>
                <q-btn
                    rounded
                    color="black"
                    label="quiero reservar"
                    no-caps
                    class="q-mt-lg"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { Screen, useQuasar } from "quasar";
import { computed, ref } from "vue";

defineOptions({
    name: "TallerOnline",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const workList = ref([
    {
        icon: "icono_2_sesiones_grupales.png",
        title: "2 sesiones grupales semanales en vivo",
    },
    {
        icon: "icono_1_sesion_individual.png",
        title: "1 consulta individual mensual profunda",
    },
    {
        icon: "icono_informe_espiritual.png",
        title: "informe personalizado despues de cada consulta",
    },
    {
        icon: "icono_acompanamiento.png",
        title: "acompanamiento directo entre sesiones",
    },
    {
        icon: "icono_practicas_guiadas.png",
        title: "practicas guiadas y ejercicios reales",
    },
    {
        icon: "icono_espacio_seguro.png",
        title: "espacio seguro y reducido (10 personas)",
    },
]);

const informes = [
    {
        title: "informe 1 de lola de 70 años",
        description:
            "este informe busca facilitarte, ampliarte y recordarte los puntos mas importantes de lo que trabajamos. <br/>profundizamos en heridas normalizadas desde la infancia, en la herida de desamor gestada en el utero y en la tendencia a dar para recibir amor. <br/> el trabajo consiste en recuperar el amor propio sin miedo y sin dependencia.",
    },
    {
        title: "informe 2 de sebas de 60 años",
        description:
            "trabajamos heridas de falta de valia, culpa y desamor. <br/>desprogramamos las creencias que sostenian el bloqueo y revisamos los patrones inconscientes que se repetian en su vida diaria. <br/>al comprender la raiz, la persona comienza a experimentar una libertad emocional que nunca habia sentido.",
    },
    {
        title: "informe 1 de carol de 37 años",
        description:
            "la consulta permitio ver la desconexion entre tus emociones presentes y el origen real. <br/>liberamos tristeza acumulada, miedo retenido y la creencia profunda de no ser suficiente. <br/>el informe recoge tu mapa emocional, los puntos de trabajo y el inicio de un cambio interno muy claro.",
    },
];
</script>
<style scope>
.bg-mariposas {
    background-image: url("../../../../public/images/others/sbye-desarrollo.png");
    background-repeat: no-repeat;
    background-size: contain;
}
</style>
