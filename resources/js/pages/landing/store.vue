<template>
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
                <dialog-auth-component />
            </q-toolbar>
            <q-item dense>
                <q-item-section avatar>
                    <btn-list-component size="lg" />
                </q-item-section>
                <q-item-section avatar>
                    <select-field label="categoria" />
                </q-item-section>
                <q-item-section avatar>
                    <text-field label="buscar">
                        <template #append>
                            <q-btn-component icon="search" />
                        </template>
                    </text-field>
                </q-item-section>
                <q-item-section />
                <q-item-section
                    avatar
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <my-wishes-component only-btn tooltips="mis deseos" />
                </q-item-section>
                <q-item-section
                    avatar
                    class="q-ml-sm"
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <btn-basket-component @click="showBasket = true" />
                </q-item-section>
                <q-item-section
                    avatar
                    class="bg-primary q-ml-xl"
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <car-component
                        :show="showBasket"
                        @hide="showBasket = false"
                    />
                </q-item-section>
            </q-item>
            <q-item dense>
                <q-item-section>
                    <store-component />
                </q-item-section>
                <q-item-section
                    avatar
                    top
                    class="bg-primary q-ml-xl"
                    style="
                        min-width: 20px;
                        width: 30px;
                        padding: 0;
                        margin-top: -6px;
                    "
                >
                </q-item-section>
            </q-item>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";
import CarComponent from "../../components/landing/store/CarComponent.vue";
import StoreComponent from "../../components/modules/store/StoreComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import SelectField from "../../components/form/input/SelectField.vue";
import TextField from "../../components/form/input/TextField.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import BtnHeartComponent from "../../components/btn/BtnHeartComponent.vue";
import BtnBasketComponent from "../../components/btn/BtnBasketComponent.vue";
import MyWishesComponent from "../../components/modules/store/MyWishesComponent.vue";
import { ref } from "vue";
defineOptions({
    name: "ConsultaIndividual",
});

const showBasket = ref(false);
</script>
