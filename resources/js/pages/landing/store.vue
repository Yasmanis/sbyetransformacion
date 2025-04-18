<template>
    <Layout title="tienda">
        <div class="container q-py-lg">
            <div class="col text-right">
                <dialog-auth-component />
            </div>
            <div class="row">
                <div class="col text-center">
                    <p>ACCESO A SBYE DIETAPP PARA FORMALIZAR TU COMPRA</p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";

defineOptions({
    name: "ConsultaIndividual",
});
</script>
