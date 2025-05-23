<template>
    <Layout>
        <q-page padding>
            <div class="row bg-red q-pa-md text-h5 text-white q-my-sm">
                <div class="col text-center">
                    esta pagina no funciona correctamente dado que está en
                    desarrollo
                </div>
            </div>
            <q-item style="padding: 0">
                <q-item-section>
                    <q-card>
                        <q-card-section class="no-padding">
                            <q-item style="padding: 0">
                                <q-item-section avatar>
                                    <section
                                        class="q-my-xs q-mr-sm cursor-pointer text-subtitle1"
                                    >
                                        <div
                                            class="doc-card-title bg-primary text-white"
                                        >
                                            <q-icon
                                                name="mdi-cart-variant"
                                                size="22px"
                                            />
                                            mis compras
                                        </div>
                                    </section>
                                </q-item-section>
                                <q-space />
                                <q-item-section avatar>
                                    <btn-heart-component
                                        tooltips="mis deseos"
                                    />
                                </q-item-section>
                                <q-item-section avatar>
                                    <q-btn-component
                                        icon="mdi-basket-outline"
                                        tooltips="cesta en proceso de compra"
                                        @click="showMenu = true"
                                        ><q-badge color="black" floating
                                            >1</q-badge
                                        ></q-btn-component
                                    >
                                </q-item-section>
                            </q-item>
                            <q-separator />
                            <q-item style="padding: 0">
                                <q-item-section>
                                    <q-card flat>
                                        <q-card-section>
                                            <q-item style="padding: 0">
                                                <q-item-section>
                                                    <q-item-label
                                                        class="text-bold"
                                                        >mis compras
                                                        activas</q-item-label
                                                    >
                                                </q-item-section>
                                                <q-item-section avatar>
                                                    <sales-dates-component />
                                                </q-item-section>
                                                <q-item-section avatar>
                                                    <btn-list-component list />
                                                </q-item-section>
                                            </q-item>
                                            <div class="row">
                                                <div
                                                    class="col-md-3 col-lg-3 col-xl-2 col-sm-4 col-xs-12 q-pa-xs"
                                                    v-for="(
                                                        item, index
                                                    ) in items"
                                                    :key="`item-${index}`"
                                                >
                                                    <shopping-component />
                                                </div>
                                            </div>
                                        </q-card-section>
                                        <q-card-section>
                                            <q-item-label
                                                class="text-bold q-pb-md"
                                                >historico de
                                                compras</q-item-label
                                            >
                                            <div class="row">
                                                <div
                                                    class="col-md-3 col-lg-3 col-xl-2"
                                                >
                                                    <shopping-component />
                                                </div>
                                            </div>
                                        </q-card-section>
                                    </q-card>
                                </q-item-section>
                            </q-item>
                        </q-card-section>
                    </q-card>
                </q-item-section>
                <q-item-section
                    avatar
                    top
                    class="q-ml-md bg-white"
                    :style="{
                        padding: '10px 0px',
                    }"
                >
                    <car-component
                        :show="showMenu"
                        @show="showMenu = true"
                        @hide="showMenu = false"
                    />
                </q-item-section>
            </q-item>
        </q-page>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import ShoppingComponent from "../../components/modules/shopping/ShoppingComponent.vue";
import BtnEditComponent from "../../components/btn/BtnEditComponent.vue";
import BtnHeartComponent from "../../components/btn/BtnHeartComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import CarComponent from "../../components/landing/store/CarComponent.vue";
import SalesDatesComponent from "../../components/modules/shopping/userdata/SalesDatesComponent.vue";

defineOptions({
    name: "SalesPage",
});

const showMenu = ref(false);

const active = ref("store");

const items = [
    "el nivel 1 dentro de la metodologia sbyetransformacion",
    "el nivel 2 dentro de la metodologia sbyetransformacion",
    "el nivel 3 dentro de la metodologia sbyetransformacion",
    "el nivel 4 dentro de la metodologia sbyetransformacion",
    "el nivel 5 dentro de la metodologia sbyetransformacion",
];
</script>
