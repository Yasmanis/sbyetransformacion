<template>
    <q-btn-component
        label="toda la informacion"
        class="full-width"
        :flat="false"
        :round="false"
        :color="Dark.isActive ? 'primary' : ''"
        square
        @click="showDialog = true"
        v-if="btn"
    />
    <q-item-label
        class="text-primary cursor-pointer"
        @click="showDialog = true"
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
                            <q-item class="q-mt-sm" style="padding: 0">
                                <q-item-section
                                    avatar
                                    top
                                    style="min-width: 30px; padding: 0"
                                >
                                    <checkbox-field name="count" />
                                </q-item-section>
                                <q-item-section>
                                    <span class="text-bold">CONTADO</span>
                                    <ul style="padding-left: 20px; margin: 0">
                                        <li>
                                            pago inicial
                                            {{ product.first_payment }} €
                                        </li>
                                        <li>
                                            {{ product.total_payments }} pagos
                                            menusales de
                                            {{
                                                (product.price -
                                                    product.first_payment) /
                                                product.total_payments
                                            }}
                                            €
                                        </li>
                                    </ul>
                                </q-item-section>
                                <q-item-section avatar>
                                    {{ product.price }} €
                                </q-item-section>
                            </q-item>
                        </q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section avatar></q-item-section>
                        <q-item-section></q-item-section>
                        <q-item-section avatar>
                            <q-btn
                                label="comprar"
                                :color="Dark.isActive ? 'primary' : 'black'"
                                @click="
                                    {
                                        emits('add-product');
                                        showDialog = false;
                                    }
                                "
                                v-if="btn"
                            />
                        </q-item-section>
                    </q-item>
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
import { ref, computed } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import { usePage } from "@inertiajs/vue3";
import { Dark } from "quasar";

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

const authenticated = computed(() => {
    return usePage().props.auth;
});
</script>
