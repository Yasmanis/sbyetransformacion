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
                por tanto, solo atendere a personas que realmente quieran
                cambiar y se involucren en su cambio <br />
                si estas preparado en profundizar en tu dolor, sanarlo y
                transmutarlo, este es tu sitio <br />
                puedes hacer consulta de forma directa conmigo o, mejor aun,
                apuntate al taller online
            </p>
        </div>
        <div class="row q-pt-xl container">
            <div class="col-md-6 col-lg-6">
                <div class="column">
                    <h4 class="q-mb-none text-uppercase">
                        consulta individual
                    </h4>
                    <p>
                        las consultas podran ser online, telefonicas o
                        presenciales, por lo que no es necesario que vivas cerca
                        de mi o te desplaces. por supuesto la magia de estar
                        juntos se rompe un poco en la distancia, pero he
                        trabajado muchas veces asi y te aseguro que sera muy
                        eficaz <br />
                        <br />
                        siempre estoy flexibilizandome y adaptandome a las
                        circunstancias mias y de la otra persona, por lo que no
                        descarto nada, asi que ponte en contacto conmigo y
                        buscaremos juntos cual es la mejor formula para ambos.
                        por ponerte un ejemplo, en ocasiones he trabajado cinco
                        dias seguidos con personas que necesitaban un empujon
                        grande, y han estado o en mi casa o en un apartamento
                        por la zona donde vivo. quien quiere, siempre encuentra
                        como!
                        <img
                            :src="`${$page.props.public_path}images/icon/smile-2.png`"
                            style="width: 22px; margin-bottom: -5px"
                        />
                        <br />
                        <br />
                        la duracion de la consulta es indefinida, es decir,
                        puedo estar contigo de una hora a cinco horas seguidas,
                        dependiendo de lo que necesites
                        <br /><br />
                        en la consulta trabajare con los recursos que te he
                        presentado en el libro y, por tanto, utilizare la
                        desprogramacion de creencias, la reflexion y la
                        liberacion emocional, para conseguir facilitarte el
                        camino hacia tu plenitud
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="row q-mt-xl items-center">
                    <div class="col-lg-6 col-md-6 text-center">
                        <img
                            :src="`${$page.props.public_path}images/others/mujer-llorando.png`"
                            class="rounded"
                            style="width: 80%"
                        />
                        <br />
                        <img
                            :src="`${$page.props.public_path}images/others/piezas-faltan.png`"
                            class="rounded"
                            style="width: 80%"
                        />
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                        <img
                            :src="`${$page.props.public_path}images/others/mujer-timon-barco.png`"
                            style="width: 80%"
                            class="rounded"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row container">
            <p>
                normalmente trabajo en un marco temporal de 3 meses con
                consultas quincenales en donde me mantengo en permanente
                contacto con la persona que esta liberando y cambiando, para que
                en ningun momento se sienta sola y desamparada, sino querida y
                apoyada, pero siempre buscando su empoderamiento, de modo que al
                cabo de este marco temporal, que podra variar ligeramente segun
                cada uno, la persona sepa utilizar por si misma todas las
                herramientas y ya solo necesite apoyarse en mi en momentos
                puntuales de crisis
                <br /><br />
                como sabes, mis clientes se convierten en mis amigos,
                sencillamente porque me desnudo con ellos, les comprendo y me
                comprenden, tenemos un fin comun y conectamos desde lo mas
                profundo de nuestro ser, es por esto que, tanto en el periodo de
                consultas como posteriormente a lo largo de toda la vida, no
                cobrare mi acompañamiento, y si me siento desbordada, buscare la
                formula, junto con dios, para que nunca, jamas, te sientas sola
                o solo en tu proceso de sanancion y cambio, en tu camino a la
                plenitud
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
                <p
                    class="text-white"
                    :class="screen.xs || screen.sm ? 'q-pt-lg' : ''"
                >
                    te dejo varios informes reales, en donde he cambiado el
                    nombre de la persona para mayor privacidad, con el fin de
                    que sepas que puedes esperar de una consulta individual
                    conmigo
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
