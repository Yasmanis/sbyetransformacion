<template>
    <Layout title="consulta individual">
        <div class="row container bg-primary items-center text-white">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                <div class="container-img-right">
                    <img
                        :src="`${$page.props.public_path}images/team/maria-consulta-individual.png`"
                        alt="group-image"
                        style="width: 50%"
                    />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                <p class="text-center header-subtitle">
                    has leido mi libro <br />
                    y quieres que te ayude <br />
                    a desprogramarte y liberar, a sanar
                    <br />
                    y conseguir como yo vivir en plenitud?
                </p>
            </div>
        </div>
        <div class="column text-center q-mt-xl container">
            <h4 class="text-lowercase q-mb-none">
                solo ayudo a quien se ayuda
            </h4>
            <p>
                solo atiendo a personas que realmente quieren cambiar y se
                involucran en su transformacion <br />
                si estas listo para profundizar en tu dolor, sanarlo y
                transmutarlo, este es tu sitio<br />
                puedes hacer una consulta individual directamente conmigo o,
                mejor aun, apuntarte al taller online
            </p>
        </div>
        <div class="row q-pt-xl container">
            <div class="col-md-6 col-lg-6">
                <div class="column">
                    <h4 class="q-mb-none text-uppercase text-black text-bold">
                        consulta individual
                    </h4>
                    <p>
                        las consultas pueden ser
                        <b>online, telefonicas o presenciales</b>, asi que no es
                        necesario que vivas cerca de mi o que te desplaces.
                        claro, la magia de estar juntos se siente diferente en
                        la distancia, pero he trabajado muchas veces asi y te
                        aseguro que sigue siendo igual de eficaz
                    </p>
                    <p>
                        me adapto siempre a cada persona y a cada situacion. por
                        eso, si lo necesitas, podemos encontrar juntos la mejor
                        forma de trabajar. por ejemplo, en ocasiones he
                        trabajado con personas durante cinco dias seguidos,
                        alojandose en mi casa o en un apartamento cercano para
                        recibir un impulso intensivo.
                        <b>quien quiere, siempre encuentra el cómo</b
                        ><img
                            :src="`${$page.props.public_path}images/icon/smile-2.png`"
                            style="width: 22px; margin-bottom: -5px"
                        />
                    </p>
                    <h4 class="q-mb-none text-uppercase text-black text-bold">
                        consulta sin reloj
                    </h4>
                    <p>
                        la duracion de la consulta es <b>indefinida</b>. puedo
                        estar contigo una hora o cinco horas seguidas, segun lo
                        que necesites
                    </p>
                    <p>
                        en cada sesion trabajaremos con los recursos de mi
                        libro:
                        <b
                            >desprogramacion de creencias, reflexion y
                            liberacion emocional</b
                        >, facilitando tu camino hacia la plenitud
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 q-pa-lg text-center">
                <video-player
                    :src="`${$page.props.public_path}media/consulta-individual.mp4`"
                    :poster="`${$page.props.public_path}images/others/poster-vivir-en-plenitud.png`"
                    controls
                    aspectRatio="4:3"
                    :volume="0.6"
                />
            </div>
        </div>
        <div class="row container">
            <h4 class="q-mb-none text-uppercase text-black text-bold">
                UN PROCESO DE TRANSFORMACION CON ACOMPAÑAMIENTO
            </h4>
            <p>
                suelo trabajar en un <b>marco de tres meses</b>, con
                <b>consultas quincenales</b> y un contacto continuo entre
                sesiones. no quiero que en ningun momento te sientas solo o sin
                apoyo. sin embargo, siempre busco tu
                <b>empoderamiento y autonomia</b>. al final de este periodo (que
                puede ajustarse segun cada persona), sabras utilizar todas las
                herramientas por ti mismo y solo necesitaras apoyo en momentos
                puntuales
            </p>
            <p>
                mis clientes se convierten en mis amigos, porque nos
                comprendemos desde lo mas profundo. por eso, tanto durante el
                proceso como despues, mi acompañamiento no tiene coste.
                <b
                    >si en algun momento me desbordo, encontrarr la forma, junto
                    con dios, de que nunca te sientas solo en tu camino de
                    sanacion y cambio</b
                >
            </p>
        </div>
        <div class="row container q-pb-lg">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div
                    class="column q-pa-md"
                    :class="screen.xs ? 'items-center' : 'items-end'"
                >
                    <q-card
                        class="my-card q-px-md"
                        style="width: 220px; border-radius: 15px"
                    >
                        <q-card-section horizontal>
                            <img
                                :src="`${$page.props.public_path}images/others/euro.png`"
                                style="
                                    width: 50px;
                                    height: 50px;
                                    margin-top: 30px;
                                "
                            />
                            <q-card-section>
                                <h6 class="q-ma-none">
                                    <b>PRECIO</b>
                                </h6>
                                <h5 class="q-ma-none">150 €</h5>
                                <small class="q-ma-none">sesion</small>
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
                    <Link href="/contactame" class="font-black text-black">
                        <q-card
                            class="my-card q-px-md"
                            style="width: 220px; border-radius: 15px"
                        >
                            <q-card-section horizontal>
                                <img
                                    :src="`${$page.props.public_path}images/others/contactos.png`"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        margin-top: 30px;
                                    "
                                />
                                <q-card-section>
                                    <h6 class="q-mt-none">
                                        <b>CONTACTO</b>
                                    </h6>
                                    <small
                                        >cuentame que <br />
                                        necesitas</small
                                    >
                                </q-card-section>
                            </q-card-section>
                        </q-card>
                    </Link>
                </div>
            </div>
        </div>
        <div
            class="row items-center container bg-primary"
            :class="screen.xs || screen.sm ? 'q-pt-xl q-pb-lg' : 'q-py-xl'"
        >
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 bg-mariposas">
                <div class="row items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="column items-center">
                            <q-card
                                class="my-card text-center q-pa-none"
                                style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                "
                            >
                                <q-card-section>
                                    <img
                                        class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/elena.png`"
                                        style="margin-top: -5px"
                                    />
                                    <h5
                                        class="text-lowercase q-ma-none q-pa-none"
                                        style="margin-top: -10px"
                                    >
                                        Elena
                                    </h5>
                                    <p
                                        style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        25 años
                                    </p>
                                    <a
                                        class="text-primary q-ma-none q-pa-none"
                                        target="_blank"
                                        :href="`${$page.props.public_path}informes/consulta_individual/elena-25-anios.pdf`"
                                        >leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"
                                        ></i
                                    ></a>
                                </q-card-section>
                            </q-card>

                            <q-card
                                class="my-card text-center q-pa-none"
                                :class="screen.xs ? 'q-my-md' : 'q-mt-xl'"
                                style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                "
                            >
                                <q-card-section>
                                    <img
                                        class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/marta.png`"
                                        style="margin-top: -5px"
                                    />
                                    <h5
                                        class="text-lowercase q-ma-none q-pa-none"
                                        style="margin-top: -10px"
                                    >
                                        marta
                                    </h5>
                                    <p
                                        style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        67 años
                                    </p>
                                    <a
                                        class="text-primary q-ma-none q-pa-none"
                                        target="_blank"
                                        :href="`${$page.props.public_path}informes/consulta_individual/marta-67-anios.pdf`"
                                        >leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"
                                        ></i
                                    ></a>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="column items-center">
                            <q-card
                                class="my-card text-center q-pa-none"
                                style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                "
                            >
                                <q-card-section>
                                    <img
                                        class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/sebas.png`"
                                        style="margin-top: -5px"
                                    />
                                    <h5
                                        class="text-lowercase q-ma-none q-pa-none"
                                        style="margin-top: -10px"
                                    >
                                        sebas
                                    </h5>
                                    <p
                                        style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        60 años
                                    </p>
                                    <a
                                        class="text-primary q-ma-none q-pa-none"
                                        target="_blank"
                                        :href="`${$page.props.public_path}informes/consulta_individual/sebas-60-anios.pdf`"
                                        >leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"
                                        ></i
                                    ></a>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h4
                    class="q-mb-none text-uppercase text-white text-bold"
                    :class="screen.xs || screen.sm ? 'q-pt-lg' : ''"
                >
                    QUE PUEDES ESPERAR DE UNA CONSULTA CONMIGO?
                </h4>
                <p class="text-white q-pt-lg">
                    te dejo varios informes reales (con los nombres modificados
                    para privacidad) para que veas como trabajo y que puedes
                    esperar de una consulta individual conmigo
                </p>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { useQuasar } from "quasar";
import { computed } from "vue";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

defineOptions({
    name: "ConsultaIndividual",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
</script>
<style scope>
.bg-mariposas {
    background-image: url("images/others/cambio-transformacion.png");
    background-repeat: no-repeat;
    background-size: 66%;
}
</style>
