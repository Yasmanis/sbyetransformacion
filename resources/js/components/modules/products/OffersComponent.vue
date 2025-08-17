<template>
    <q-btn-component
        icon="mdi-credit-card-clock-outline"
        tooltips="promociones"
        @click="showDialog = true"
    />
    <q-dialog v-model="showDialog" persistent allow-focus-outside>
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-credit-card-clock-outline"
                title="promociones"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-tabs
                    v-model="tab"
                    dense
                    align="justify"
                    class="bg-primary text-white shadow-2"
                    :breakpoint="0"
                >
                    <q-tab label="ofertas" no-caps name="offers" />
                    <q-tab label="descuentos" no-caps name="discounts" />
                </q-tabs>
                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="offers" class="q-pa-none">
                        <offers-table :product="product" :has-edit="hasEdit" />
                    </q-tab-panel>

                    <q-tab-panel name="discounts" class="q-pa-none">
                        <discounts-table
                            :product="product"
                            :has-edit="hasEdit"
                        />
                    </q-tab-panel>
                </q-tab-panels>
            </q-card-section>

            <q-separator />

            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import OffersTable from "./OffersTable.vue";
import DiscountsTable from "./DiscountsTable.vue";

defineOptions({
    name: "OffersComponent",
});

const props = defineProps({
    product: Object,
    hasEdit: Boolean,
});

const showDialog = ref(false);

const tab = ref("offers");
</script>
