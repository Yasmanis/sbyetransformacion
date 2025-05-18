<template>
    <btn-edit-component @click="showDialog = true" tooltips="editar" />

    <q-dialog v-model="showDialog" persistent>
        <q-card>
            <dialog-header-component
                icon="mdi-credit-card-check-outline"
                title="selecciona datos de facturacion"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-list dense class="q-gutter-md">
                    <q-item style="padding: 0">
                        <q-item-section avatar>
                            <checkbox-field :dense="false" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>
                                nombre apellido apellido
                            </q-item-label>
                            <q-item-label> direccion completa </q-item-label>
                            <q-item-label> pueblo – ciudad </q-item-label>
                            <q-item-label>
                                cp – provincia (pais )
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item style="padding: 0">
                        <q-item-section avatar>
                            <checkbox-field :dense="false" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>
                                nombre apellido apellido
                            </q-item-label>
                            <q-item-label> direccion completa2 </q-item-label>
                            <q-item-label> pueblo – ciudad2 </q-item-label>
                            <q-item-label>
                                cp – provincia (pais )
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item style="padding: 0">
                        <q-item-section avatar> </q-item-section>
                        <q-item-section avatar class="q-pl-lg"
                            ><form-billing-information
                        /></q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import FormBillingInformation from "./FormBillingInformation.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "BillingInformation",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
    has_edit: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);

const user = computed(() => {
    return usePage().props.auth.user;
});
</script>
