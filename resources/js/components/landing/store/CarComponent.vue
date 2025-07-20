<template>
    <q-btn
        :icon="onlyBtn ? 'mdi-basket' : 'mdi-chevron-double-left'"
        flat
        rounded
        color="black"
        padding="2px"
    >
        <q-badge
            floating
            style="margin-top: -3px; margin-right: -5px"
            v-if="onlyBtn && products.length > 0"
            >{{ products.length }}</q-badge
        >
        <q-tooltip
            class="bg-black text-body3"
            self="top middle"
            anchor="bottom middle"
            :offset="[5, 5]"
        >
            mostrar cesta
        </q-tooltip>
        <q-menu
            v-model="menu"
            :transition-show="onlyBtn ? '' : 'slide-left'"
            :transition-hide="onlyBtn ? '' : 'slide-right'"
            style="width: 500px"
            :offset="[2, -38]"
            @before-show="emits('show')"
            @hide="emits('hide')"
        >
            <q-card bordered>
                <q-card-section class="q-pa-none" style="width: 100%">
                    <q-item dense>
                        <q-item-section avatar>
                            <btn-left-right-component
                                title="ocultar"
                                :leftDirection="false"
                                @click="menu = !menu"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label> mi cesta </q-item-label>
                            <q-item-label
                                lines="1"
                                caption
                                class="text-primary"
                            >
                                seguir comprando
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-list
                        separator
                        class="q-mt-sm"
                        v-if="products.length > 0"
                    >
                        <q-item
                            class="bg-teal-2"
                            v-for="(prod, indexP) in products"
                            :key="`product-${indexP}`"
                        >
                            <q-item-section avatar top>
                                <q-img
                                    :src="`${$page.props.public_path}images/logo/2.png`"
                                    fit
                                    width="70px"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label class="text-bold" lines="1">
                                    {{ prod.name }}
                                </q-item-label>
                                <q-item-label>contado</q-item-label>
                                <q-item-label
                                    ><ul style="padding-left: 20px; margin: 0">
                                        <li>
                                            pago inicial
                                            {{ prod.first_payment }} €
                                        </li>
                                        <li>
                                            {{ prod.total_payments }} pagos
                                            menusales de
                                            {{
                                                (prod.price -
                                                    prod.first_payment) /
                                                prod.total_payments
                                            }}
                                            €
                                        </li>
                                    </ul></q-item-label
                                >
                                <q-item-label class="text-bold">
                                    {{ prod.price }} €
                                </q-item-label>
                                <product-information
                                    :product="prod"
                                    :btn="false"
                                />
                            </q-item-section>
                            <q-item-section avatar top>
                                <q-input
                                    dense
                                    outlined
                                    style="width: 50px"
                                    v-model="prod.total_to_car"
                                />
                            </q-item-section>
                            <q-item-section
                                avatar
                                top
                                style="padding: 0px; min-width: 20px"
                            >
                                <btn-delete-component
                                    class="q-ml-xs q-mt-xs"
                                    @click="removeProductFromStorage(prod)"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                    <div class="row" v-else>
                        <div class="col text-center q-pa-md">
                            <span class="text-h6"
                                >no tienes productos en la cesta</span
                            >
                        </div>
                    </div>
                </q-card-section>
                <q-card-actions v-if="authBtn"
                    ><q-btn-component
                        label="formalizar"
                        class="full-width"
                        color="black"
                        :flat="false"
                        :round="false"
                        :disable="products.length === 0"
                        padding="5px"
                        @click="emits('show-auth')"
                /></q-card-actions>
            </q-card>
        </q-menu>
    </q-btn>
</template>

<script setup>
import { onBeforeMount, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../btn/BtnLeftRightComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import ProductInformation from "../../modules/shopping/ProductInformation.vue";

import {
    products,
    removeProductFromStorage,
    loadProductsFromStorage,
} from "../../../services/shopping";

defineOptions({
    name: "CarComponent",
});

const props = defineProps({
    onlyBtn: {
        type: Boolean,
        default: false,
    },
    authBtn: Boolean,
    show: Boolean,
});

const emits = defineEmits(["show", "hide", "remove-product", "show-auth"]);
const menu = ref(false);

onBeforeMount(() => {
    loadProductsFromStorage();
});

watch(
    () => props.show,
    (n) => {
        if (n) {
            menu.value = true;
            emits("show");
        }
    }
);
</script>
