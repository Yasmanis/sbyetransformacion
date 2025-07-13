<template>
    <q-btn-component
        label="toda la informacion"
        class="full-width"
        :flat="false"
        :round="false"
        :color="Dark.isActive ? 'primary' : ''"
        square
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" @hide="onHide">
        <q-card style="width: 800px; max-width: 80vw">
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
                                    product.image_path?.substring(1) ?? ''
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
                            <q-item>
                                <q-item-section avatar>
                                    <checkbox-field name="count" />
                                </q-item-section>
                                <q-item-section>
                                    <span class="text-bold">CONTADO</span>
                                    <ul>
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
                            <q-btn-component
                                label="comprar"
                                :flat="false"
                                :round="false"
                                :color="Dark.isActive ? 'primary' : ''"
                                padding="5px"
                                square
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
});

const showDialog = ref(false);

const onHide = () => {
    usePage().props.errors = {};
};

const authenticated = computed(() => {
    return usePage().props.auth;
});
</script>
