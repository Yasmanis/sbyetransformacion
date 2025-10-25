<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : ''"
        >
            <div class="row">
                <div class="col" :class="!Screen.xs ? 'q-pr-xs' : ''">
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><current-billing-information
                                    text="DIRECCION DE FACTURACION"
                                    bgClass="bg-primary"
                                    textClass="text-white"
                                    :current="billingInformation?.id ?? 0"
                                    :editable="false"
                                />
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="row">
                <div
                    class="col"
                    :class="!Screen.xs && !Screen.sm ? 'q-pr-md' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white q-mt-md">
                                    <q-item-section class="text-center">
                                        METODO DE PAGO
                                    </q-item-section>
                                </q-item>
                                <q-item style="padding: 0" class="q-my-xs">
                                    <q-item-section avatar>
                                        <q-img
                                            :src="`${$page.props.public_path}images/logo/2.png`"
                                            width="80px"
                                            fit="fill"
                                            v-if="method.id !== 0"
                                        />
                                        <q-img
                                            :src="`${$page.props.public_path}images/others/paypal.png`"
                                            width="80px"
                                            fit="fill"
                                            v-else
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>
                                            {{ method.name }}
                                        </q-item-label>
                                        <q-item-label v-if="method.id !== 0">
                                            tarjeta de credito que termina en
                                            ••••
                                            {{ method.number.split(" ")[3] }}
                                        </q-item-label>
                                        <q-item-label
                                            class="text-red"
                                            v-if="method.expired"
                                        >
                                            <q-icon
                                                name="mdi-alert-outline"
                                                size="md"
                                            />
                                            tu medio de pago ha expirado
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
        <div
            class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
            :class="!Screen.xs ? 'q-pl-xs' : ''"
        >
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item class="bg-primary text-white">
                            <q-item-section> subtotal: </q-item-section>
                            <q-item-section avatar>
                                {{ subtotalAmount }} €
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <q-checkbox
                                v-model="accept"
                                name="accepted"
                                dense
                                @update:model-value="
                                    (val) => emits('accepted', val)
                                "
                            >
                                acepto los
                                <legal-contracting
                                    text="<span class='text-bold'>terminos legales</span>"
                                />
                                de esta contratacion
                            </q-checkbox>
                        </q-item>
                        <q-item>
                            <q-item-section>
                                <q-item-label caption
                                    ><i
                                        >estas realizando una compra 100%
                                        segura</i
                                    ></q-item-label
                                >
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
    </div>
    <q-list dense :separator="products.length > 1">
        <q-item dense class="bg-primary text-white q-mt-md">
            <q-item-section class="text-center">
                RESUMEN DE TU PEDIDO
            </q-item-section>
        </q-item>

        <products-abstract
            :product="products[0]"
            v-if="products.length === 1"
        />

        <template v-else>
            <q-expansion-item
                v-for="(p, index) in products"
                :key="`product-${p.id}`"
                group="somegroup"
                icon="shopping_cart_checkout"
                :label="p.name"
                :default-opened="index === 0"
                header-class="text-primary"
            >
                <q-card>
                    <q-card-section>
                        <products-abstract :product="p" />
                    </q-card-section>
                </q-card>
            </q-expansion-item>
        </template>
    </q-list>

    <div class="row q-mt-sm">
        <div class="col">
            <q-btn-component flat no-caps square color="primary">
                <legal-contracting
                    text="leer <span class='text-bold'>terminos legales</span> de esta contratacion"
                />
            </q-btn-component>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import AddressCard from "./AddressCard.vue";
import ProductsAbstract from "./ProductsAbstract.vue";
import QTooltipComponent from "../../../base/QTooltipComponent.vue";
import LegalContracting from "../../../others/LegalContracting.vue";
import CurrentBillingInformation from "../userdata/CurrentBillingInformation.vue";
import { Screen, openURL } from "quasar";
import {
    products,
    subtotalAmount,
    pendingAmount,
    currentPaymentMethod as method,
} from "../../../../services/shopping";

defineOptions({
    name: "Confirmation",
});

const props = defineProps({
    billingInformation: Object,
});

const emits = defineEmits(["accepted"]);

const accept = ref(false);
</script>
