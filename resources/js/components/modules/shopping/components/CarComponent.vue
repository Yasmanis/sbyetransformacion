<template>
    <q-btn
        :icon="onlyBtn ? 'mdi-basket' : 'mdi-chevron-double-left'"
        flat
        rounded
        :color="color"
        padding="2px"
        :style="style"
        :class="cls"
        :size="size"
    >
        <q-badge
            floating
            style="margin-top: -3px; margin-right: -2px"
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
            transition-show="slide-left"
            transition-hide="slide-right"
            :offset="offset"
            style="width: 500px"
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
                                    :src="`${$page.props.public_path}${
                                        prod.image_path?.substring(1) ??
                                        'images/logo/2.png'
                                    }`"
                                    fit
                                    width="70px"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label class="text-bold" lines="1">
                                    {{ prod.name }}
                                </q-item-label>
                                <q-item-label>contado</q-item-label>
                                <q-item-label class="text-bold">
                                    {{ prod.final_price }} €
                                </q-item-label>
                                <product-information
                                    :product="prod"
                                    :btn="false"
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
                <q-card-actions
                    ><q-btn-component
                        label="formalizar"
                        class="full-width"
                        color="black"
                        :flat="false"
                        :round="false"
                        :disable="products.length === 0"
                        padding="5px"
                        @click="
                            () => {
                                showPaymentOnLogin = true;
                                showAuth = true;
                            }
                        "
                        v-if="authBtn && !user"
                    />
                    <basket-sale-component
                        :show="showPayment"
                        label="pagar"
                        class="full-width"
                        v-if="user && products.length > 0"
                    />
                </q-card-actions>
            </q-card>
        </q-menu>
    </q-btn>

    <dialog-auth-component
        :show="showAuth"
        :show-label="false"
        :show-payment-on-login="showPaymentOnLogin"
        @hide="
            {
                showAuth = false;
            }
        "
    />
</template>

<script setup>
import { computed, onBeforeMount, ref, watch } from "vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../../btn/BtnLeftRightComponent.vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import ProductInformation from "../ProductInformation.vue";
import BasketSaleComponent from "../BasketSaleComponent.vue";
import DialogAuthComponent from "../../../landing/store/DialogAuthComponent.vue";
import { usePage } from "@inertiajs/vue3";

import {
    products,
    removeProductFromStorage,
    loadProductsFromStorage,
} from "../../../../services/shopping";

defineOptions({
    name: "CarComponent",
});

const props = defineProps({
    onlyBtn: {
        type: Boolean,
        default: false,
    },
    color: {
        type: String,
        default: "black",
    },
    style: Object,
    cls: String,
    authBtn: Boolean,
    show: Boolean,
    showPayment: Boolean,
    size: String,
    offset: {
        type: Array,
        default: [12, -35],
    },
});

const emits = defineEmits(["show", "hide", "remove-product"]);
const menu = ref(false);
const page = usePage();
const showAuth = ref(false);
const showPaymentOnLogin = ref(false);

onBeforeMount(() => {
    loadProductsFromStorage();
});

const user = computed(() => {
    return page.props.auth?.user ?? null;
});

watch(
    () => props.show,
    (n) => {
        if (n) {
            menu.value = true;
            emits("show");
        }
    },
);
</script>
