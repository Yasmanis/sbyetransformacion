<template>
    <q-table
        wrap-cells
        flat
        :filter="filter"
        :columns="columns"
        :rows="paymentsMethods"
        :pagination="{ rowsPerPage: 0 }"
        v-model:selected="selected"
        selection="multiple"
        hide-pagination
        row-key="id"
    >
        <template v-slot:top>
            <q-toolbar class="no-padding">
                <div class="col col-auto no-padding">
                    <q-input
                        dense
                        clearable
                        debounce="300"
                        v-model="filter"
                        placeholder="filtrar"
                    >
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </div>
                <q-space />
                <div class="col-auto">
                    <card-component />
                    <delete-component
                        url="/admin/users/payment-methods"
                        :objects="selected"
                        @deleted="selected = []"
                        v-if="selected.length > 0"
                    /></div
            ></q-toolbar>
        </template>

        <template v-slot:header-selection="scope">
            <q-checkbox v-model="scope.selected" size="sm" />
        </template>

        <template v-slot:body-selection="scope">
            <q-checkbox v-model="scope.selected" size="sm" />
        </template>

        <template v-slot:body-cell-predetermined="props">
            <td class="text-center">
                <q-chip
                    dense
                    size="sm"
                    style="max-width: min-content"
                    :color="props.value ? 'black' : 'blue-2'"
                    :text-color="props.value ? 'white' : 'black'"
                    :icon="props.value ? 'check' : 'error'"
                    :label="props.value ? 'Si' : 'No'"
                />
            </td>
        </template>
        <template v-slot:body-cell-actions="props">
            <td class="text-center" width="120px">
                <payment-method :object="props.row" />
                <btn-confirm-component
                    :disabled="props.row.predetermined"
                    tooltips="establecer como predeterminado"
                    @click="
                        router.post(
                            `/admin/users/payment-methods/predetermined/${props.row.id}`,
                        )
                    "
                />
                <delete-component
                    url="/admin/users/payment-methods"
                    :objects="[props.row]"
                />
            </td> </template
    ></q-table>
</template>

<script setup>
import { computed, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import DeleteComponent from "../../table/actions/DeleteComponent.vue";
import BtnConfirmComponent from "../../btn/BtnConfirmComponent.vue";
import { paymentsMethods } from "../../../services/shopping";
import CardComponent from "../../modules/shopping/userdata/CardComponent.vue";
import PaymentMethod from "../../modules/shopping/userdata/PaymentMethod.vue";

defineOptions({
    name: "ListPaymentMethod",
});

const filter = ref("");

const selected = ref([]);

const columns = [
    {
        name: "name",
        field: "name",
        label: "nombre",
        align: "left",
    },
    {
        name: "number",
        field: "number",
        label: "numero",
        align: "left",
    },
    {
        name: "defeat",
        field: "defeat",
        label: "vencimiento",
        align: "left",
    },
    {
        name: "predetermined",
        field: "predetermined",
        label: "predeterminado",
        align: "center",
    },
    {
        name: "actions",
        field: "actions",
        label: "",
        align: "center",
    },
];

const user = computed(() => {
    return usePage().props.auth.user;
});
</script>
