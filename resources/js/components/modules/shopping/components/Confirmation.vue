<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs && !Screen.sm ? 'q-pr-sm' : ''"
        >
            <div class="row">
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs && !Screen.sm ? 'q-pr-md' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white">
                                    <q-item-section class="text-center">
                                        DIRECCION DE ENVIO
                                    </q-item-section>
                                </q-item>
                                <q-item style="padding: 10px 0px">
                                    <q-item-section>
                                        <q-item-label>
                                            nombre apellido apellido
                                        </q-item-label>
                                        <q-item-label>
                                            direccion completa
                                        </q-item-label>
                                        <q-item-label>
                                            pueblo – ciudad
                                        </q-item-label>
                                        <q-item-label>
                                            cp – provincia (pais)
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs ? 'q-pr-xs' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white">
                                    <q-item-section class="text-center">
                                        DIRECCION DE FACTURACION
                                    </q-item-section>
                                </q-item>
                                <address-card
                                    :object="currentBillingInformation"
                                />
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="row">
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
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
                                <q-item style="padding: 0">
                                    <q-item-section avatar>
                                        <q-img
                                            :src="`${$page.props.public_path}images/logo/2.png`"
                                            :ratio="16 / 9"
                                            width="50px"
                                            fit="fill"
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>
                                            {{ method.name }}
                                        </q-item-label>
                                        <q-item-label>
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
                <div
                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"
                    :class="!Screen.xs ? 'q-pr-xs' : ''"
                >
                    <q-card flat>
                        <q-card-section class="q-pa-none">
                            <q-list dense
                                ><q-item class="bg-primary text-white q-mt-md">
                                    <q-item-section class="text-center">
                                        METODO DE ENVIO
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
                            <q-item-section> pagos pendientes: </q-item-section>
                            <q-item-section avatar>
                                {{ pendingAmount }} €
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <checkbox-field
                                name="accepted"
                                label="acepto los terminos legales de esta contratacion"
                            />
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
            <q-btn-component
                label="leer terminos legales de esta contratacion"
                flat
                no-caps
                square
                color="primary"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import AddressCard from "./AddressCard.vue";
import ProductsAbstract from "./ProductsAbstract.vue";
import { Screen } from "quasar";
import {
    products,
    subtotalAmount,
    pendingAmount,
    currentPaymentMethod as method,
    currentBillingInformation,
} from "../../../../services/shopping";

defineOptions({
    name: "Confirmation",
});

const step = ref(1);

const columns = ref([
    {
        name: "date",
        field: "date",
        label: "fecha",
        headerClasses: "bg-primary text-white",
        align: "left",
    },
    {
        name: "summary",
        field: "summary",
        label: "resumen",
        headerClasses: "bg-primary text-white",
        align: "left",
    },
    {
        name: "cost",
        field: "cost",
        label: "importe",
        headerClasses: "bg-primary text-white",
        align: "right",
    },
    {
        name: "amount",
        field: "amount",
        label: "pagado a la fecha",
        headerClasses: "bg-primary text-white text-body1",
        align: "right",
    },
]);

const rows = ref([
    {
        date: "01-05-2023",
        summary: "primer pago con la compra",
        cost: "270 €",
        amount: "270 €",
    },
    {
        date: "01-06-2023",
        summary: "segundo pago",
        cost: "130 €",
        amount: "400 €",
    },
    {
        date: "01-07-2023",
        summary: "tercer pago",
        cost: "130 €",
        amount: "530 €",
    },
    {
        date: "01-08-2023",
        summary: "cuarto pago",
        cost: "130 €",
        amount: "660 €",
    },
    {
        date: "01-09-2023",
        summary: "quinto pago",
        cost: "130 €",
        amount: "790 €",
    },
]);
</script>
