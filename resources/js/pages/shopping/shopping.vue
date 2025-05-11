<template>
    <Layout>
        <q-page padding>
            <q-item style="padding: 0">
                <q-item-section avatar>
                    <q-btn-component
                        label="Tienda Sbyetransformacion"
                        color="black"
                        :flat="false"
                        :round="false"
                        padding="5px"
                    />
                </q-item-section>
                <q-item-section avatar>
                    <my-wishes-component />
                </q-item-section>
                <q-item-section />
                <q-item-section avatar class="q-mr-md">
                    <q-btn-component
                        icon="mdi-basket-outline"
                        tooltips="cesta en proceso de compra"
                        ><q-badge color="black" floating
                            >1</q-badge
                        ></q-btn-component
                    >
                </q-item-section>
                <q-item-section
                    avatar
                    :style="{
                        'min-width': '28px',
                        background: showMenu ? 'transparent' : '#fff',
                        padding: 0,
                    }"
                >
                    <car-component
                        @show="showMenu = true"
                        @hide="showMenu = false"
                    />
                </q-item-section>
            </q-item>
            <q-item style="padding: 0">
                <q-item-section class="q-mr-md">
                    <q-card flat>
                        <q-card-section>
                            <q-item style="padding: 0">
                                <q-item-section>
                                    <q-item-label class="text-bold q-pb-md"
                                        >mis compras activas</q-item-label
                                    >
                                </q-item-section>
                                <q-item-section avatar>
                                    <btn-edit-component
                                        tooltips="editar datos de la compra"
                                    />
                                </q-item-section>
                                <q-item-section avatar>
                                    <btn-list-component />
                                </q-item-section>
                            </q-item>
                            <div class="row">
                                <div
                                    class="col-md-3 col-lg-3 col-xl-2 col-sm-4 col-xs-12 q-pa-xs"
                                    v-for="(item, index) in items"
                                    :key="`item-${index}`"
                                >
                                    <shopping-component />
                                </div>
                            </div>
                        </q-card-section>
                        <q-card-section>
                            <q-item-label class="text-bold q-pb-md"
                                >historico de compras</q-item-label
                            >
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xl-2">
                                    <shopping-component />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </q-item-section>
                <q-item-section
                    avatar
                    :style="{
                        'min-width': '28px',
                        background: showMenu ? 'transparent' : '#fff',
                        padding: 0,
                    }"
                ></q-item-section>
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
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import CarComponent from "../../components/landing/store/CarComponent.vue";
import MyWishesComponent from "../../components/modules/shopping/MyWishesComponent.vue";

defineOptions({
    name: "ShoppingPage",
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
