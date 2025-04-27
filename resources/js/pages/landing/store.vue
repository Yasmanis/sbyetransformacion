<template>
    <Layout title="tienda">
        <div class="q-py-lg">
            <q-toolbar>
                <q-toolbar-title></q-toolbar-title>
                <dialog-auth-component />
            </q-toolbar>
            <div
                class="float-right q-mr-md bg-primary"
                style="width: 30px; height: 300px"
            >
                <car-component />
            </div>

            <div class="row">
                <div class="col text-center">
                    <p>
                        ACCESO A SBYETRANSFORMACION APP PARA FORMALIZAR TU
                        COMPRA
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";
import CarComponent from "../../components/landing/store/CarComponent.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../components/btn/BtnLeftRightComponent.vue";
defineOptions({
    name: "ConsultaIndividual",
});
</script>
