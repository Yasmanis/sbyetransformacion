<template>
    <btn-edit-component @click="showDialog = true" tooltips="editar" />

    <q-dialog v-model="showDialog" persistent @before-show="onBeforeShow">
        <q-card>
            <dialog-header-component
                icon="mdi-credit-card-check-outline"
                title="selecciona datos de facturacion"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll">
                <q-list dense class="q-gutter-md">
                    <q-item
                        style="padding: 0"
                        v-for="(item, index) in billingsInformation"
                        :key="`biling-information-${index}`"
                    >
                        <q-item-section avatar>
                            <checkbox-field
                                :dense="false"
                                :model-value="item.predetermined"
                                name="predetermined"
                                @update="onUpdatePredetermined(item)"
                            />
                        </q-item-section>
                        <q-item-section
                            @click="onUpdatePredetermined(item)"
                            class="cursor-pointer"
                        >
                            <q-item-label>
                                {{ item.full_name }}
                            </q-item-label>
                            <q-item-label> {{ item.address }} </q-item-label>
                            <q-item-label> pueblo – ciudad </q-item-label>
                            <q-item-label>
                                {{ item.postal_code }} – {{ item.province }} ({{
                                    item.country_str
                                }})
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item style="padding: 0">
                        <q-item-section
                            avatar
                            v-if="billingsInformation.length > 0"
                        >
                        </q-item-section>
                        <q-item-section
                            avatar
                            :class="
                                billingsInformation.length === 0
                                    ? 'no-padding'
                                    : 'q-pl-lg'
                            "
                            ><form-billing-information @created="onBeforeShow"
                        /></q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-confirm-component
                    @click="onConfirm"
                    v-if="currentBilling?.predetermined"
                />
                <btn-cancel-component cancel @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../../btn/BtnCancelComponent.vue";
import BtnConfirmComponent from "../../../btn/BtnConfirmComponent.vue";
import BtnEditComponent from "../../../btn/BtnEditComponent.vue";
import CheckboxField from "../../../form/input/CheckboxField.vue";
import FormBillingInformation from "./FormBillingInformation.vue";
import { usePage, useForm } from "@inertiajs/vue3";

defineOptions({
    name: "ListBillingInformation",
});

const props = defineProps({
    current: Object,
    predetermined: Boolean,
});

const emits = defineEmits(["change"]);

const showDialog = ref(false);
const currentBilling = ref(null);
const billingsInformation = ref([]);

const user = computed(() => {
    return usePage().props.auth.user;
});

const onBeforeShow = (billing) => {
    let current = billing?.predetermined ?? props.current;
    currentBilling.value = current;
    let billings = [];
    user.value.billings_information.forEach((b) => {
        let bill = { ...b };
        if (!props.predetermined) {
            Object.assign(bill, {
                predetermined: b.id === current.id,
            });
        }
        billings.push(bill);
    });
    billingsInformation.value = billings;
};

const onUpdatePredetermined = (item) => {
    item.predetermined = !item.predetermined;
    let old = billingsInformation.value.find(
        (b) => b.predetermined && b.id !== item.id
    );
    if (old) {
        old.predetermined = false;
    }
    currentBilling.value = item;
};

const onConfirm = async () => {
    if (props.predetermined) {
        const send = useForm({});
        await send.post(
            `/admin/users/billing-information/predetermined/${currentBilling.value.id}`,
            {
                onSuccess: () => {
                    user.value.billings_information.forEach((b) => {
                        if (b.id === currentBilling.value.id) {
                            b.predetermined = true;
                        } else {
                            b.predetermined = false;
                        }
                    });
                    showDialog.value = false;
                },
            }
        );
    } else {
        emits("change", currentBilling.value);
        showDialog.value = false;
    }
};
</script>
