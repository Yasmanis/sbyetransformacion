<template>
    <q-btn-component
        label="toda la informacion"
        class="full-width"
        :flat="false"
        :round="false"
        :color="Dark.isActive ? 'primary' : ''"
        square
        @click="showInformation"
        v-if="btn"
    />
    <q-item-label
        class="text-primary cursor-pointer"
        @click="showInformation"
        v-else
    >
        ver toda la informacion
    </q-item-label>

    <q-dialog v-model="showDialog" @hide="onHide">
        <q-card style="width: 1000px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-information-outline"
                title="INFORMACION DEL PRODUCTO"
                closable
            />
            <q-card-section>
                <q-list>
                    <q-item>
                        <q-item-section avatar top>
                            <q-img
                                :src="`${$page.props.public_path}${
                                    product.image_path?.substring(1) ??
                                    'images/logo/2.png'
                                }`"
                                width="150px"
                            />
                        </q-item-section>
                        <q-item-section>
                            <div class="row">
                                <div class="col">
                                    <span v-html="product.description"></span>
                                </div>
                            </div>
                            <q-item class="no-padding">
                                <q-item-section>
                                    <q-expansion-item
                                        group="somegroup"
                                        expand-separator
                                        v-for="(
                                            obj, indexObj
                                        ) in product.subtitles"
                                        :key="`subtitle-${indexObj}`"
                                        :label="obj.name"
                                    >
                                        <q-card>
                                            <q-card-section>
                                                <span
                                                    v-html="obj.description"
                                                ></span>
                                            </q-card-section>
                                        </q-card>
                                    </q-expansion-item>
                                </q-item-section>
                            </q-item>
                            <q-item style="padding: 0">
                                <q-item-section avatar class="text-bold">
                                    precio: {{ product.price }} €
                                </q-item-section>
                                <q-item-section></q-item-section>
                                <q-item-section avatar>
                                    <q-btn
                                        label="comprar"
                                        :color="
                                            Dark.isActive ? 'primary' : 'black'
                                        "
                                        :disable="
                                            products
                                                .map((p) => p.id)
                                                .includes(product.id)
                                        "
                                        @click="
                                            {
                                                emits('add-product');
                                                showDialog = false;
                                            }
                                        "
                                    />
                                </q-item-section>
                            </q-item>
                        </q-item-section>
                    </q-item>

                    <!-- <q-item v-if="offers.length > 0 || discounts.length > 0">
                        <q-item-section
                            avatar
                            style="min-width: 160px"
                        ></q-item-section>
                        <q-item-section>
                            <div class="row q-col-gutter-sm">
                                <template
                                    v-for="o in offers"
                                    :key="`offers-${o.id}`"
                                >
                                    <div class="col-4">
                                        <offers-component
                                            :object="o"
                                            :product="product"
                                        />
                                    </div>
                                </template>
                            </div>
                        </q-item-section>
                    </q-item> -->
                    <q-item>
                        <q-item-section
                            avatar
                            style="min-width: 160px"
                        ></q-item-section>
                        <q-item-section>
                            <q-item-label class="text-bold"
                                >opinion de usuarios</q-item-label
                            >
                        </q-item-section>
                    </q-item>
                    <q-item style="padding-top: 0px">
                        <q-item-section avatar style="min-width: 160px" />
                        <q-item-section>
                            <q-list dense bordered>
                                <q-item style="padding: 3px 3px !important">
                                    <q-item-section
                                        avatar
                                        class="q-pr-md bg-grey-2 q-pa-sm"
                                    >
                                        <q-item-label class="q-mt-sm"
                                            >nombre</q-item-label
                                        >
                                        <q-item-label>pais</q-item-label>
                                        <q-item-label
                                            ><q-icon
                                                name="check"
                                                color="primary"
                                                size="sm"
                                            />comprador verificado</q-item-label
                                        >
                                    </q-item-section>
                                    <q-item-section class="q-pa-sm">
                                        <q-item-label>
                                            <q-rating
                                                v-model="rating"
                                                color="primary"
                                                icon="star_border"
                                                icon-selected="star"
                                                style="margin-top: -3px"
                                            />
                                            <b class="q-ml-sm -q-mt-xs"
                                                >titulo opinion</b
                                            >
                                        </q-item-label>
                                        <q-item-label>
                                            opinion primera linea
                                        </q-item-label>
                                        <q-item-label>
                                            opinion segunda línea
                                        </q-item-label>
                                        <q-item-label>
                                            opinion tercera linea
                                        </q-item-label>
                                        <q-item-label style="margin-top: -5px">
                                            <q-item dense style="padding: 0">
                                                <q-item-section avatar>
                                                    te parece util esta opinion?
                                                </q-item-section>
                                                <q-item-section avatar>
                                                    <q-btn
                                                        label="si"
                                                        color="black"
                                                        no-caps
                                                    />
                                                </q-item-section>
                                                <q-item-section avatar>
                                                    <q-btn
                                                        label="no"
                                                        color="black"
                                                        no-caps
                                                    />
                                                </q-item-section>
                                                <q-item-section />
                                                <q-item-section avatar>
                                                    <q-btn
                                                        icon="mdi-emoticon-excited-outline"
                                                        flat
                                                    />
                                                </q-item-section>
                                            </q-item>
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import OffersComponent from "./components/offers/OffersComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark, openURL } from "quasar";
import { products } from "../../../services/shopping";

defineOptions({
    name: "ProductInformation",
});

const props = defineProps({
    product: Object,
    btn: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["add-product"]);

const rating = ref(0);
const showDialog = ref(false);

const onHide = () => {
    usePage().props.errors = {};
};

const showInformation = () => {
    if (props.product.information_to_landing) {
        openURL("/liberacion_emocional", undefined);
    } else {
        showDialog.value = true;
    }
};

const offers = computed(() => {
    return props.product.active_offers.offers;
});

const discounts = computed(() => {
    return props.product.active_offers.discounts;
});
</script>
