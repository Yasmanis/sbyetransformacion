<template>
    <Layout title="taller online">
        <div class="row container bg-primary items-center">
            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                <img :src="`${$page.props.public_path}images/team/maria-taller-online.png`" class="rounded"
                    style="width: 60%" />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                <p class="text-white text-lowercase header-subtitle">
                    quieres que te ayude <br />
                    desprogramarte y liberar, a sanar<br />y conseguir como yo
                    vivir en plenitud?<br /><br />o, eres terapeuta y<br />deseas
                    convertirte en facilitador de procesos personales?
                </p>
            </div>
        </div>
        <div class="row items-center container q-mt-xl">
            <div class="col-lg-6 col-md-6 col-sm-12" :class="screen.xs || screen.sm ? '' : 'q-pr-xl'">
                <h2>taller online</h2>
                <p>
                    se trata de un programa online de 3 meses en donde
                    semanalmente tendremos dos reuniones para practicar en grupo
                    los recursos que he propuesto en el libro. iras haciendo los
                    ejercicios a tu ritmo personal en casa, pero en grupo los
                    revisaremos y solucionaremos dudas, practicaremos y
                    compartiremos con los demas nuestro propio camino
                </p>
                <p>
                    adicionalmente, a lo largo del mes, tendre una consulta
                    individual contigo, en donde te conocere profundamente para
                    poder apoyarte y guiarte en tu camino hacia tu plenitud,
                    para ello utilizare recursos de liberacion emocional,
                    desprogramacion de creencias y reflexion y al finalizarla te
                    escribire un informe personal sobre lo que hemos trabajado y
                    mis recomendaciones y reflexiones sobre tu personalidad y
                    circunstancias
                </p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <img :src="`${$page.props.public_path}images/others/encontrar-luz-mujer.png`" :style="{
                            width: screen.xs ? '100%' : '84%',
                        }" class="rounded" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <img class="rounded" :src="`${$page.props.public_path}images/others/encajar-pieza-falta.png`"
                            style="width: 100%" />
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <img :src="`${$page.props.public_path}images/others/taller-online.png`" class="rounded"
                            style="width: 100%" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row container q-pt-xl items-center items-center">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="column items-center">
                    <q-card class="my-card q-px-md" style="width: 220px; border-radius: 15px">
                        <q-card-section horizontal>
                            <img :src="`${$page.props.public_path}images/others/euro.png`" style="
                                    width: 50px;
                                    height: 50px;
                                    margin-top: 30px;
                                " />
                            <q-card-section>
                                <h6>
                                    <b>PRECIO</b>
                                </h6>
                                <h5>300 €</h5>
                                <small>mes</small>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" :class="screen.xs ? 'q-pt-md' : ''">
                <div class="column items-center">
                    <q-card class="my-card q-px-md" style="width: 220px; border-radius: 15px">
                        <q-card-section horizontal>
                            <img :src="`${$page.props.public_path}images/others/euro.png`" style="
                                    width: 50px;
                                    height: 50px;
                                    margin-top: 30px;
                                " />
                            <q-card-section>
                                <h6>
                                    <b>AFORO</b>
                                </h6>
                                <h5>10</h5>
                                <small>personas</small>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" :class="screen.xs || screen.sm ? 'q-pt-md' : ''">
                <div class="column items-center">
                    <Link href="/contactame" class="font-black text-black">
                    <q-card class="my-card q-px-md" style="width: 220px; border-radius: 15px">
                        <q-card-section horizontal>
                            <img :src="`${$page.props.public_path}images/others/contactos.png`" style="
                                        width: 50px;
                                        height: 50px;
                                        margin-top: 30px;
                                    " />
                            <q-card-section>
                                <h6 class="q-mt-none">
                                    <b>CONTACTO</b>
                                </h6>
                                <small>cuentame que <br> necesitas</small>
                            </q-card-section>
                        </q-card-section>
                    </q-card>
                    </Link>
                </div>
            </div>
        </div>
        <div class="row items-center container bg-primary q-mt-xl">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 bg-mariposas q-py-xl ">
                <div class="row items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="column items-center">
                            <q-card class="my-card text-center q-pa-none" style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                ">
                                <q-card-section>
                                    <img class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/monica.png`"
                                        style="margin-top: -5px" />
                                    <h5 class="text-lowercase q-ma-none q-pa-none" style="margin-top: -10px">
                                        Lola
                                    </h5>
                                    <p style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        ">
                                        70 años
                                    </p>
                                    <a class="text-primary q-ma-none q-pa-none" target="_blank"
                                        :href="`${$page.props.public_path}informes/taller_online/lola-70-anios.pdf`">leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"></i></a>
                                </q-card-section>
                            </q-card>

                            <q-card class="my-card text-center q-pa-none" :class="screen.xs ? 'q-mt-md' : 'q-mt-xl'"
                                style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                ">
                                <q-card-section>
                                    <img class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/rosa.png`"
                                        style="margin-top: -5px" />
                                    <h5 class="text-lowercase q-ma-none q-pa-none" style="margin-top: -10px">
                                        carol
                                    </h5>
                                    <p style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        ">
                                        37 años
                                    </p>
                                    <a class="text-primary q-ma-none q-pa-none" target="_blank"
                                        :href="`${$page.props.public_path}informes/taller_online/carol-37-anios.pdf`">leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"></i></a>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="column items-center">
                            <q-card class="my-card text-center q-pa-none" :class="screen.xs ? 'q-mt-md' : ''" style="
                                    width: 160px;
                                    max-height: 160px;
                                    border-radius: 25px;
                                ">
                                <q-card-section>
                                    <img class="q-ma-none q-pa-none"
                                        :src="`${$page.props.public_path}images/avatars/sebas.png`"
                                        style="margin-top: -5px" />
                                    <h5 class="text-lowercase q-ma-none q-pa-none" style="margin-top: -10px">
                                        sebas
                                    </h5>
                                    <p style="
                                            margin-top: -5px;
                                            margin-bottom: 5px;
                                        ">
                                        60 años
                                    </p>
                                    <a class="text-primary q-ma-none q-pa-none" target="_blank"
                                        :href="`${$page.props.public_path}informes/taller_online/sebas-60-anios.pdf`">leer<i
                                            class="fa fa-long-arrow-right q-ml-sm"></i></a>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12" :class="screen.xs || screen.sm ? 'q-pb-xl' : ''">
                <p class="text-white q-mb-none">
                    te dejo varios informes reales, en donde he cambiado el
                    nombre de la persona para mayor privacidad, con el fin de
                    que sepas que puedes esperar de una consulta individual
                    conmigo dentro del taller online
                </p>
            </div>
        </div>
        <div class="row container q-mt-xl items-center">
            <div class="col-lg-6 col-md-6 q-px-md">
                <h4>
                    QUIERES CONVERTIRTE EN FACILITADOR DE PROCESOS PERSONALES?
                </h4>
                <p>
                    haz el taller online de 3 meses y practica de forma directa
                    conmigo primero a traves del taller y posteriormente
                    tendremos una consulta individual mensual hasta que sintamos
                    que estas totalmente empoderado para poder ayudar a otras
                    personas desde tu propia experiencia personal y con total
                    dominio de los recursos que he propuesto en el libro y otros
                    que te ire proponiendo en caso de que sean necesarios en tu
                    interaccion personal con otras personas
                </p>
                <p>
                    al finalizar contaras con mi apoyo incondicional para
                    ayudarte a resolver tus dudas cuando estes trabajando hacia
                    los demas, ademas de mi apoyo en tu propio proceso personal,
                    como cualquier otro cliente-amigo
                </p>
                <p>
                    por supuesto, aunque ya sabes que no se trata de una
                    formacion oficial, contaras con tu titulo de facilitador de
                    prosesos personales firmado por mi
                    <img :src="`${$page.props.public_path}images/icon/smile.png`"
                        style="width: 25px; margin-bottom: -8px" />
                </p>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="row items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="q-pa-sm">
                            <img :src="`${$page.props.public_path}images/others/guiar-facilitador-procesos.png`"
                                style="width: 100%" class="rounded" />
                        </div>
                        <div class="q-pa-sm">
                            <img :src="`${$page.props.public_path}images/others/mujer-liberanso-emocionalmente.png`"
                                style="width: 100%" class="rounded" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="q-pa-sm">
                            <img :src="`${$page.props.public_path}images/others/facilitador-procesos-personales.png`"
                                style="width: 100%" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import { useQuasar } from "quasar";
import { computed } from "vue";

defineOptions({
    name: "TallerOnline",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
</script>
<style scope>
.bg-mariposas {
    background-image: url("images/others/sbye-desarrollo.png");
    background-repeat: no-repeat;
    background-size: 66%;
}
</style>
