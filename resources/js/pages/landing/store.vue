<template>
    <Layout title="tienda">
        <div class="container q-py-lg">
            <div class="col text-right">
                <q-btn
                    label="entrar"
                    outline
                    no-caps
                    color="primary"
                    @click="dialogAuth = true"
                />
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>ACCESO A SBYE DIETAPP PARA FORMALIZAR TU COMPRA</p>
                </div>
            </div>
        </div>
    </Layout>

    <q-dialog v-model="dialogAuth">
        <q-card style="width: 800px; max-width: 80vw">
            <dialog-header-component
                icon="mdi-key"
                title="ACCESO A SBYE DIETAPP PARA FORMALIZAR TU COMPRA"
                closable
            />
            <q-card-section>
                <div class="row">
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 bg-teal-11 q-pa-xl text-center"
                    >
                        <p class="text-center">
                            ES LA PRIMERA VEZ <br />
                            QUE CONTRATO EN SBYE DIETAPP
                        </p>
                        <q-btn label="INICIAR REGISTRO" color="primary" />
                    </div>
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-xl"
                    >
                        <div class="column items-center">
                            <q-form ref="formRef" class="q-gutter-md">
                                <q-card flat>
                                    <q-card-section class="q-gutter-sm">
                                        <p>YA SOY CLIENTE EN SBYE DIETAPP</p>
                                        <text-field
                                            label="email"
                                            name="email"
                                            type="email"
                                        />
                                        <text-field
                                            label="contraseña"
                                            name="password"
                                            type="password"
                                        />
                                        <checkbox-field
                                            name="rememberme"
                                            label="recordar contraseña"
                                            class="q-pl-none q-ml-none q-mt-md"
                                        />
                                    </q-card-section>
                                    <q-card-section class="text-center">
                                        <q-btn
                                            label="INICIAR SESION"
                                            color="primary"
                                        />
                                    </q-card-section>
                                    <q-card-section class="text-center">
                                        <q-item-label>
                                            has olvidado tu contraseña?
                                        </q-item-label>
                                    </q-card-section>
                                </q-card>
                            </q-form>
                        </div>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import TextField from "../../components/form/input/TextField.vue";
import CheckboxField from "../../components/form/input/CheckboxField.vue";
import DialogHeaderComponent from "../../components/base/DialogHeaderComponent.vue";
import { useQuasar } from "quasar";
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

const dialogAuth = ref(false);
</script>
<style scope>
.bg-mariposas {
    background-image: url("images/others/cambio-transformacion.png");
    background-repeat: no-repeat;
    background-size: 66%;
}
</style>
