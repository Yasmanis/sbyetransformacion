<template>
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
