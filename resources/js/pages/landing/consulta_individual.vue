<template>
    <Layout title="consulta individual">
        <div class="row container bg-primary items-center text-white">
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center"
                :class="{
                    'q-pa-lg': !Screen.xs,
                }"
            >
                <img
                    :src="`${$page.props.public_path}images/team/maria-consulta-individual.png`"
                    alt="group-image"
                    style="width: 40%"
                />
            </div>
            <div
                class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center"
                style="font-size: 18px; line-height: 1.5"
            >
                <p class="text-bold">
                    consulta individual <br />
                    un proceso profundo de transformacion real
                </p>
                <p class="text-center">
                    libera, desprograma, recupera tu verdad
                </p>
            </div>
        </div>
        <div class="column text-center q-my-xl container">
            <h6 class="text-lowercase q-mb-md">que es una consulta conmigo?</h6>
            <p>
                acompañarte no es solo darte tecnicas para calmarte un dia
                <br />
                es ayudarte a encontrar el origen real de lo que sientes,
                desprogramarlo y recuperar tu libertad interior
            </p>
            <p>en cada consulta trabajamos</p>
            <p>
                liberar emociones atrapadas <br />
                descubrir las creencias que sostienen el bloqueo <br />
                desprogramar patrones inconscientes <br />
                recuperar tu verdad interior <br />
                tomar decisiones desde tu alma, no desde el miedo
            </p>
            <p>
                mi trabajo es acompañarte hasta que sientas un cambio real, no
                superficial
            </p>
        </div>
        <div class="row container bg-primary text-white q-py-xl">
            <div class="col">
                <h6 class="text-lowercase text-white q-mb-md">como trabajo?</h6>
                <p>mi manera de acompañarte es diferente</p>
                <q-list>
                    <q-item v-for="w in workList" :key="`work-${w.title}`">
                        <q-item-section avatar>
                            <q-icon
                                size="md"
                                :name="`img:${$page.props.public_path}images/icon/${w.icon}`"
                            />
                        </q-item-section>
                        <q-item-section style="max-width: 250px">
                            <q-item-label>{{ w.title }}</q-item-label>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>{{ w.description }}</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </div>
        </div>
        <div class="row container tems-center q-py-xl">
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
            >
                <h6 class="text-lowercase q-mb-md">
                    que puedes esperar en una sesion?
                </h6>
                <ol class="guion-list" style="line-height: 40px">
                    <li>
                        te ayudare a encontrar el origen exacto de lo que estas
                        viviendo
                    </li>
                    <li>
                        liberaremos las emociones atrapadas que sostienen ese
                        patron
                    </li>
                    <li>desprogramaremos creencias que no nacieron de ti</li>
                    <li>
                        te mostrare como funciona tu mundo interno con claridad
                    </li>
                    <li>y con el tiempo, aprenderas a guiarte tu mismo</li>
                </ol>
                <p>
                    mi mision es que no dependas de mi <br />
                    sino que recuperes tu poder
                </p>
            </div>
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/transformacion_consulta.png`"
                    style="width: 40%"
                />
            </div>
        </div>
        <div class="row container tems-center">
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 self-center text-center"
            >
                <img
                    :src="`${$page.props.public_path}images/others/consulta_individual.png`"
                    style="width: 60%"
                />
            </div>
            <div
                class="col-xl-6 col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12"
            >
                <h6 class="text-lowercase q-mb-md">el proceso completo</h6>
                <p>como trabajaremos juntos</p>
                <ol
                    style="
                        line-height: 40px;
                        padding-left: 15px;
                        margin-top: -5px;
                    "
                >
                    <li>consulta profunda (sin limite de tiempo)</li>
                    <li>informe personalizado</li>
                    <li>dos semanas de integracion con mi acompañamiento</li>
                    <li>siguiente sesion</li>
                    <li>repetimos el ciclo durante 3 meses</li>
                    <li>finalizas empoderado, con autonomia real</li>
                </ol>
            </div>
            <div class="col-12 q-py-lg">
                <hr style="height: 1px" class="bg-grey-6" />
            </div>
        </div>
        <div class="row container q-pb-lg">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div
                    class="column q-pa-md"
                    :class="screen.xs ? 'items-center' : 'items-end'"
                >
                    <q-card
                        class="my-card q-px-md"
                        flat
                        style="
                            max-width: 400px;
                            border-radius: 55px;
                            border: 3px solid #407492;
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
                                <p><b>consulta profunda</b></p>
                                <p>
                                    sin limite de tiempo <br />
                                    informe detallado incluido <br />
                                    acompañamiento entre sesiones <br />
                                    proceso 3 meses: personalizado segun <br />
                                    necesidades
                                </p>
                                <p class="text-bold q-mb-none">150 €</p>
                                <p>sesion</p>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div
                    class="column q-pa-md"
                    :class="screen.xs ? 'items-center' : ''"
                >
                    <q-card
                        class="my-card q-px-md"
                        flat
                        style="
                            max-width: 400px;
                            border-radius: 55px;
                            border: 3px solid #407492;
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
                                <p><b>quieres que te ayude?</b></p>
                                <p>
                                    cuentame tu caso <br />
                                    y te orientare personalmente <br />
                                    (no hay reserva automatica <br />
                                    quiero escuchar primero tu necesidad)
                                </p>
                                <q-btn
                                    rounded
                                    color="black"
                                    label="cuentame lo que necesitas"
                                    no-caps
                                    class="q-my-lg"
                                    href="/contactame"
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
        <div class="row bg-primary text-white container q-pt-lg">
            <div class="col-12">
                <p class="text-h6">LO QUE DICEN DE MI TRABAJO</p>
                <p class="text-justify">
                    cada persona que he acompañado me ha mostrado que, cuando
                    alguien se atreve a mirar dentro, el cambio es inevitable
                </p>
                <p class="text-justify">
                    estas son algunas voces reales que han vivido esta
                    transformacion a traves de sesiones, de mi libro o de mis
                    conferencias
                </p>
                <hr style="width: 100%; height: 1px; background: #fff" />
                <p class="text-h6 q-pt-md">video testimonio destacado</p>
                <div class="row q-col-gutter-sm items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <video-player
                            :src="`${$page.props.public_path}media/testimonio-destacado.mp4`"
                            controls
                            :volume="0.6"
                            aspectRatio="16:9"
                        />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <p
                            class="text-justify"
                            :class="!Screen.xs ? 'q-px-xl' : null"
                        >
                            ella vivio un proceso profundo de liberacion
                            emocional durante varios dias de trabajo intensivo
                            conmigo
                        </p>
                        <p
                            class="text-justify"
                            :class="!Screen.xs ? 'q-px-xl' : null"
                        >
                            lo que cuenta es parte de lo que tambien puedes
                            experimentar en una consulta conmigo
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <hr style="width: 100%; height: 1px; background: #fff" />
                <p class="text-h6 q-pt-md q-mb-none">testimonios destacados</p>
                <br />
            </div>
        </div>
        <div class="row container bg-primary q-col-gutter-lg q-pb-xl">
            <div
                v-for="(t, imgIndex) in staticTestimonies"
                :key="imgIndex"
                class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
            >
                <q-card class="my-card" style="border-radius: 55px">
                    <q-card-section class="text-center">
                        <q-img
                            :src="`${$page.props.public_path}images/icon/heart.png`"
                            fit="fill"
                            width="50px"
                        />
                    </q-card-section>
                    <q-card-section
                        class="text-center text-black"
                        style="min-height: 200px"
                    >
                        <span v-html="t.description"></span>
                    </q-card-section>
                    <q-card-actions
                        ><p class="text-right full-width q-pr-sm">
                            {{ t.user }}
                        </p></q-card-actions
                    >
                </q-card>
            </div>
            <div class="col-12 text-center">
                <q-btn
                    rounded
                    color="black"
                    label="ver mas testimonios"
                    no-caps
                    class="q-mt-md"
                    href="/publicaciones/2"
                >
                    <q-icon name="fa fa-long-arrow-right" class="q-ml-md" />
                </q-btn>
            </div>
        </div>
        <div class="row container q-py-xl">
            <div class="col text-center">
                <p>
                    no necesitas vivir desde tu miedo, tu programacion o tu
                    pasado <br />
                    puedes transformarlo <br />
                    y puedes hacerlo ahora
                </p>
                <q-btn
                    rounded
                    color="black"
                    label="mi enfoque"
                    no-caps
                    class="q-mt-md"
                    href="/mi_enfoque"
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
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

defineOptions({
    name: "ConsultaIndividual",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const workList = ref([
    {
        icon: "icono_reloj.png",
        title: "consulta sin reloj",
        description:
            "no hay prisa. podemos estar una hora o cinco. llegamos juntos donde haya que llegar",
    },
    {
        icon: "icono_manos.png",
        title: "acompañamiento entre sesiones",
        description:
            "no te dejo solo. tienes contacto directo conmigo para sostener tu proceso emocional y tus pasos",
    },
    {
        icon: "icono_informe.png",
        title: "informe personal detallado",
        description:
            "recibes un informe con tu mapa emocional, tus creencias, tus avances y los pasos claros a seguir",
    },
    {
        icon: "icono_ojo.png",
        title: "trabajo emocional + inconsciente",
        description:
            "integro emocion, inconsciente y verdad interior para que te entiendas, te liberes y cambies tu vida desde dentro",
    },
    {
        icon: "icono_calendario.png",
        title: "proceso personalizado (normalmente 3 meses)",
        description:
            "tiempo suficiente para trasformar tu programacion y hacerte autonomo, aunque el ritmo se adapta a tu momento y circunstancias",
    },
]);

const staticTestimonies = [
    {
        user: "Carmen",
        description:
            "Conocí a María en el que creí que era el peor momento de mi vida: la muerte de mi padre. Sin embargo, la vida me sorprendió poniéndome frente a una persona que, con sus palabras y experiencias, me ayudó a despertar y a superar traumas del pasado que ni siquiera recordaba.",
    },
    {
        user: "Cristina",
        description:
            "María me ha enseñado todo lo increíble que puede ser la vida. Sin frenos, cargada de emociones y conociéndose a uno mismo hasta el mas profundo recobeco del alma.",
    },
    {
        user: "Marcos",
        description:
            "No soy de leer libros, pero sí soy de escuchar. desde hace años, mi madre me habla de cómo creamos nuestra realidad, de cómo el miedo nos frena y de cómo, cuando uno se atreve a vivir, la vida se transforma.",
    },
];
</script>
<style scope>
.bg-mariposas {
    background-image: url("../../../../public/images/others/cambio-transformacion.png");
    background-repeat: no-repeat;
    background-size: contain;
}
</style>
