<template>
    <Layout>
        <q-page>
            <div
                class="fullscreen bg-blue text-white text-center q-pa-md flex flex-center"
            >
                <div>
                    <div style="font-size: 30vh">404</div>

                    <div class="text-h2" style="opacity: 0.4">
                        lo sentimos!. objeto no encontrado...
                    </div>

                    <q-btn
                        class="q-mt-xl"
                        color="white"
                        text-color="blue"
                        unelevated
                        href="/"
                        label="ir al inicio"
                        no-caps
                    />
                </div>
            </div>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
defineOptions({
    name: "notFound",
});
</script>
