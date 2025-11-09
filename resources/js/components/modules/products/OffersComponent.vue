<template>
    <q-btn-component
        icon="mdi-credit-card-clock-outline"
        tooltips="promociones"
        @click="showDialog = true"
    />
    <q-dialog v-model="showDialog" persistent full-width allow-focus-outside>
        <q-card>
            <dialog-header-component
                icon="mdi-credit-card-clock-outline"
                title="promociones"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 70vh" class="scroll">
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
                        <offers-table
                            :object="object"
                            :base-url="baseOfferUrl"
                            :list-url="listOfferUrl"
                            :relation-name="offerRelation"
                            :has-edit="hasEdit"
                        />
                    </q-tab-panel>

                    <q-tab-panel name="discounts" class="q-pa-none">
                        <discounts-table
                            :object="object"
                            :base-url="baseDiscountUrl"
                            :list-url="listDiscountUrl"
                            :relation-name="discountRelation"
                            :only-percent="onlyPercent"
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
    object: Object,
    hasEdit: Boolean,
    baseDiscountUrl: String,
    listDiscountUrl: String,
    baseOfferUrl: String,
    listOfferUrl: String,
    discountRelation: String,
    offerRelation: String,
    onlyPercent: Boolean,
});

const showDialog = ref(false);

const tab = ref("offers");
</script>
