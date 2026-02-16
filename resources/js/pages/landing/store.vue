<template>
    <Head>
        <title>
            Cursos y consulta online – Aprender a liberar y Crear la realidad
            conscientemente | Sbye Transformación
        </title>
        <meta
            name="description"
            content="Cursos de María Garriga Domínguez para liberar emociones, transformar creencias y crear conscientemente la vida que deseas. Aprende a vivir desde tu esencia."
        />
        <meta
            name="keywords"
            content="cursos liberación emocional, crear la realidad, consciencia, desprogramación emocional, maria garriga, consulta desarrollo personal"
        />
    </Head>
    <Layout title="tienda">
        <div class="q-py-lg">
            <div class="row bg-red q-pa-md text-h5 text-white">
                <div class="col text-center">
                    esta pagina no funciona correctamente dado que está en
                    desarrollo
                </div>
            </div>

            <q-toolbar>
                <q-toolbar-title></q-toolbar-title>
                <dialog-auth-component
                    :show="showAuth"
                    :show-payment-on-login="showPaymentOnLogin"
                    @hide="
                        {
                            showAuth = false;
                            showPaymentOnLogin = false;
                        }
                    "
                />
            </q-toolbar>

            <shopping-component from-public />
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";
import ShoppingComponent from "../../components/modules/shopping/ShoppingComponent.vue";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";
import { usePage, Head } from "@inertiajs/vue3";
import {
    updateProductsStorage,
    products as selectedProducts,
    loadProductsFromStorage,
    removeAllProductsFromStorage,
} from "../../services/shopping";
import { success } from "../../helpers/notifications";
import { cloneDeep } from "lodash";

defineOptions({
    name: "Store",
});

const showAuth = ref(false);
const showPaymentOnLogin = ref(false);
</script>
<style>
figure.media {
    margin: 0px !important;
}
figure.media video {
    width: 30%;
}
.text-white > span > p > span {
    color: white !important;
}
</style>
