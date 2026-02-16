<template>
    <Layout>
        <q-page padding>
            <div class="row bg-red q-pa-md text-h5 text-white q-my-sm">
                <div class="col text-center">
                    esta pagina no funciona correctamente dado que está en
                    desarrollo
                </div>
            </div>
            <q-tabs
                v-model="tab"
                no-caps
                inline-label
                align="left"
                class="text-white"
            >
                <q-tab name="sales" icon="mdi-cart" label="mis compras" />
                <q-tab name="wishes" icon="mdi-cart-heart" label="mis deseos" />
                <q-tab name="store" icon="mdi-cart-variant" label="tienda" />
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated class="q-mt-xs">
                <q-tab-panel name="sales" style="padding: 0px !important">
                    <q-item style="padding: 0">
                        <q-item-section>
                            <q-card>
                                <q-card-section class="no-padding">
                                    <panel-header-component
                                        icon="mdi-cart-variant"
                                        title="mis compras"
                                    >
                                        <slot>
                                            <btn-heart-component
                                                tooltips="mis deseos"
                                            />

                                            <btn-basket-component
                                                tooltips="cesta en proceso de compra"
                                            >
                                                <q-badge
                                                    floating
                                                    style="
                                                        margin-top: -3px;
                                                        margin-right: -5px;
                                                    "
                                                    v-if="
                                                        selectedProducts.length >
                                                        0
                                                    "
                                                    >{{
                                                        selectedProducts.length
                                                    }}</q-badge
                                                ></btn-basket-component
                                            >
                                        </slot>
                                    </panel-header-component>
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
                                                            <btn-list-component
                                                                list
                                                            />
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
                                                            <card-product-component />
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
                                                            <card-product-component />
                                                        </div>
                                                    </div>
                                                </q-card-section>
                                            </q-card>
                                        </q-item-section>
                                    </q-item>
                                </q-card-section>
                            </q-card>
                        </q-item-section>
                    </q-item>
                </q-tab-panel>

                <q-tab-panel name="wishes">
                    <div class="text-h6">Alarms</div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                </q-tab-panel>

                <q-tab-panel name="store">
                    <shopping-component />
                </q-tab-panel>
            </q-tab-panels>
            <!--  -->
        </q-page>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onMounted, ref } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import CardProductComponent from "../../components/modules/shopping/CardProductComponent.vue";
import BtnHeartComponent from "../../components/btn/BtnHeartComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import SalesDatesComponent from "../../components/modules/shopping/userdata/SalesDatesComponent.vue";
import BtnBasketComponent from "../../components/btn/BtnBasketComponent.vue";
import PanelHeaderComponent from "../../components/base/PanelHeaderComponent.vue";
import ShoppingComponent from "../../components/modules/shopping/ShoppingComponent.vue";
import { products as selectedProducts } from "../../services/shopping";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "SalesPage",
});

const tab = ref(null);
const page = usePage();

const items = [
    "el nivel 1 dentro de la metodologia sbyetransformacion",
    "el nivel 2 dentro de la metodologia sbyetransformacion",
    "el nivel 3 dentro de la metodologia sbyetransformacion",
    "el nivel 4 dentro de la metodologia sbyetransformacion",
    "el nivel 5 dentro de la metodologia sbyetransformacion",
];

onBeforeMount(() => {
    tab.value = page.props.show_payment ? "store" : "sales";
});
</script>
