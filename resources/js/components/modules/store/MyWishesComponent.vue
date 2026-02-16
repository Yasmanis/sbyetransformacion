<template>
    <btn-heart-component
        :tooltips="tooltips"
        :color="color"
        @click="showDialog = true"
        v-if="onlyBtn"
    />
    <q-btn-component
        label="Mis deseos"
        :color="color"
        :flat="false"
        :round="false"
        padding="5px"
        @click="showDialog = true"
        v-else
    />

    <q-dialog v-model="showDialog">
        <q-card>
            <dialog-header-component
                icon="mdi-cards-heart-outline"
                title="mis deseos"
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <q-list class="q-mt-sm">
                    <q-item>
                        <q-item-section avatar side>
                            <q-img
                                :src="`${$page.props.public_path}images/logo/2.png`"
                                fit
                                width="80px"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label class="text-bold">
                                JUNT@S!
                            </q-item-label>
                            <q-item-label>contado</q-item-label>
                            <q-item-label
                                ><ul class="q-ma-none q-pl-md text-body2">
                                    <li>pago inicial 270 €</li>
                                    <li>4 pagos mensuales de 130 €</li>
                                </ul></q-item-label
                            >
                        </q-item-section>
                        <q-item-section avatar top>
                            <basket-sale-component label="comprar" />
                            <btn-heart-component class="q-mt-lg" />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnHeartComponent from "../../btn/BtnHeartComponent.vue";
import BasketSaleComponent from "../shopping/BasketSaleComponent.vue";
import { Dark } from "quasar";
defineOptions({
    name: "MyWishesComponent",
});

const props = defineProps({
    onlyBtn: Boolean,
    tooltips: String,
    color: {
        type: String,
        default: "black",
    },
});

const showDialog = ref(false);
</script>
