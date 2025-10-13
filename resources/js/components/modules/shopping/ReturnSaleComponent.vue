<template>
    <btn-return-sale-component @click="showDialog = true" />

    <q-dialog v-model="showDialog">
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                icon="mdi-credit-card-sync-outline"
                title="elige los productos a devolver"
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <q-list class="q-mt-sm">
                    <q-form greedy ref="formRef">
                        <q-item>
                            <q-item-section avatar side>
                                <checkbox-field
                                    v-model="selected.product1"
                                    :dense="false"
                                />
                            </q-item-section>
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
                            <q-item-section>
                                <select-field
                                    label="porque quieres devolverlo?"
                                    :disable="false"
                                    :othersProps="{
                                        required: true,
                                        url_to_options: '/reasons-for-return',
                                    }"
                                />
                                <text-field
                                    label="explicanos que ha sucedido"
                                    autogrow
                                    :disable="false"
                                    :othersProps="{
                                        required: true,
                                    }"
                                    class="q-mt-sm"
                                />
                            </q-item-section>
                        </q-item>
                    </q-form>
                </q-list>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn-component
                    label="devolver"
                    padding="5px 10px"
                    :round="false"
                    :flat="false"
                    @click="save"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnReturnSaleComponent from "../../btn/BtnReturnSaleComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import SelectField from "../../form/input/SelectField.vue";
import TextField from "../../form/input/TextField.vue";
import { errorValidation } from "../../../helpers/notifications";
defineOptions({
    name: "ReturnSaleComponent",
});

const props = defineProps({});

const showDialog = ref(false);

const formRef = ref(null);
const selected = ref({
    product1: false,
});

const save = () => {
    formRef.value.validate().then((success) => {
        if (success) {
        } else {
            errorValidation();
        }
    });
};
</script>
