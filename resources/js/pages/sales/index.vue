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
                            <q-toolbar
                                class="q-toolbar row no-wrap items-center"
                            >
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
                                <q-space />
                                <btn-heart-component tooltips="mis deseos" />
                                <btn-basket-component
                                    tooltips="cesta en proceso de compra"
                                    @click="showMenu = true"
                                >
                                    <q-badge
                                        floating
                                        style="
                                            margin-top: -3px;
                                            margin-right: -5px;
                                        "
                                        v-if="selectedProducts.length > 0"
                                        >{{ selectedProducts.length }}</q-badge
                                    ></btn-basket-component
                                >
                            </q-toolbar>
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
import ShoppingComponent from "../../components/modules/shopping/ShoppingComponent.vue";
import BtnHeartComponent from "../../components/btn/BtnHeartComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import CarComponent from "../../components/modules/shopping/components/CarComponent.vue";
import SalesDatesComponent from "../../components/modules/shopping/userdata/SalesDatesComponent.vue";
import BtnBasketComponent from "../../components/btn/BtnBasketComponent.vue";
import { products as selectedProducts } from "../../services/shopping";

defineOptions({
    name: "SalesPage",
});

const showMenu = ref(false);

const items = [
    "el nivel 1 dentro de la metodologia sbyetransformacion",
    "el nivel 2 dentro de la metodologia sbyetransformacion",
    "el nivel 3 dentro de la metodologia sbyetransformacion",
    "el nivel 4 dentro de la metodologia sbyetransformacion",
    "el nivel 5 dentro de la metodologia sbyetransformacion",
];
</script>
