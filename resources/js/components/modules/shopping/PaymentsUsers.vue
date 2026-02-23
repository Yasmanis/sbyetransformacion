<template>
    <!-- <q-item style="padding: 0">
        <q-item-section>
            <q-card>
                <q-card-section class="no-padding">
                    <panel-header-component
                        icon="mdi-cart-variant"
                        title="mis compras"
                    >
                        <slot>
                            <btn-heart-component tooltips="mis deseos" />

                            <btn-basket-component
                                tooltips="cesta en proceso de compra"
                            >
                                <q-badge
                                    floating
                                    style="margin-top: -3px; margin-right: -5px"
                                    v-if="selectedProducts.length > 0"
                                    >{{ selectedProducts.length }}</q-badge
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
                                            <q-item-label class="text-bold"
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
                                            v-for="(item, index) in items"
                                            :key="`item-${index}`"
                                        >
                                            <card-product-component />
                                        </div>
                                    </div>
                                </q-card-section>
                                <q-card-section>
                                    <q-item-label class="text-bold q-pb-md"
                                        >historico de compras</q-item-label
                                    >
                                    <div class="row">
                                        <div class="col-md-3 col-lg-3 col-xl-2">
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
    </q-item> -->

    <q-card flat>
        <q-card-section>
            <q-item style="padding: 0">
                <q-item-section>
                    <q-item-label class="text-bold"
                        >mis compras activas</q-item-label
                    >
                </q-item-section>
                <q-item-section avatar>
                    <sales-dates-component />
                </q-item-section>
                <q-item-section avatar>
                    <btn-list-component list />
                </q-item-section>
            </q-item>
            <div class="row" v-if="payments.length > 0">
                <div
                    class="col-md-3 col-lg-3 col-xl-2 col-sm-4 col-xs-12 q-pa-xs"
                    v-for="(item, index) in payments"
                    :key="`item-${index}`"
                >
                    <card-product-component
                        :product="item"
                        @sales-again="emits('sales-again', item)"
                    />
                </div>
            </div>
            <div class="row" v-else>no existen compras</div>
        </q-card-section>
        <q-card-section>
            <q-item-label class="text-bold q-pb-md"
                >historico de compras</q-item-label
            >
            <div class="row" v-if="payments.length > 0">
                <div
                    class="col-md-3 col-lg-3 col-xl-2 col-sm-4 col-xs-12 q-pa-xs"
                    v-for="(item, index) in payments"
                    :key="`item-${index}`"
                >
                    <card-product-component
                        :product="item"
                        @sales-again="emits('sales-again', item)"
                    />
                </div>
            </div>
            <div class="row" v-else>no existen compras</div>
        </q-card-section>
    </q-card>
</template>

<script setup>
import CardProductComponent from "./CardProductComponent.vue";
import SalesDatesComponent from "./userdata/SalesDatesComponent.vue";
import BtnListComponent from "../../btn/BtnListComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

defineOptions({
    name: "PaymentsUsers",
});

const page = usePage();

const emits = defineEmits(["sales-again"]);

const payments = computed(() => {
    return page.props.payments ?? [];
});
</script>
