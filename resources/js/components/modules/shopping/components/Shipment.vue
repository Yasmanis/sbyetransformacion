<template>
    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"
            :class="!Screen.xs ? 'q-pr-xs' : ''"
        >
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense
                        ><q-item class="bg-primary text-white">
                            <q-item-section>
                                1. SELECCIONA LA FORMA DE ENTREGA
                            </q-item-section> </q-item
                        ><q-item class="bg-primary text-white q-mt-md">
                            <q-item-section>
                                2. DIRECCION DE ENVIO
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
                                <q-item-label> pueblo – ciudad </q-item-label>
                                <q-item-label>
                                    cp – provincia (pais)
                                </q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-item style="padding: 0px 0px">
                            <q-item-section>
                                <checkbox-field
                                    name="change_address"
                                    label="direccion nueva para este envio"
                                />
                            </q-item-section>
                            <q-item-section avatar>
                                <btn-edit-component />
                            </q-item-section>
                        </q-item>
                        <q-item class="bg-primary text-white q-mt-md">
                            <q-item-section>
                                3. OBSERVACIONES PARA EL TRANSPORTISTA
                            </q-item-section>
                        </q-item>
                        <q-item style="padding: 10px 0px">
                            <q-item-section>
                                <text-field type="textarea" name="address" />
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
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
</template>

<script setup>
import { computed, ref } from "vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import TextField from "../../../form/input/TextField.vue";
import { Screen } from "quasar";
import { subtotalAmount, pendingAmount } from "../../../../services/shopping";

defineOptions({
    name: "Shipment",
});
</script>
