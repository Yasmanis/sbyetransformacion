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
        :grid="$q.screen.lt.sm"
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
            </td>
        </template>

        <template v-slot:item="props">
            <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <q-card style="margin-left: 10px; margin-right: 10px">
                    <q-list>
                        <q-item
                            v-for="col in props.cols"
                            :key="col.name"
                            :class="col.type === 'hidden' ? 'hidden' : ''"
                        >
                            <slot
                                :name="`item-section-${col.name}`"
                                :props="props"
                            >
                                <q-item-section v-if="col.name !== 'actions'">
                                    <q-item-label v-if="col.type !== 'avatar'">
                                        {{ col.label }}
                                    </q-item-label>
                                    <q-item-label
                                        v-if="
                                            col.type === 'avatar' ||
                                            col.type === 'image'
                                        "
                                        class="text-center"
                                    >
                                        <q-avatar v-if="col.type === 'avatar'">
                                            <q-img
                                                :src="col.value"
                                                loading="lazy"
                                            />
                                        </q-avatar>
                                        <q-img
                                            :src="col.value"
                                            loading="lazy"
                                            width="100px"
                                            v-else
                                        />
                                    </q-item-label>
                                    <q-item-label
                                        v-else-if="col.type === 'boolean'"
                                    >
                                        <q-chip
                                            dense
                                            size="sm"
                                            style="max-width: min-content"
                                            :color="
                                                col.value ? 'black' : 'blue-2'
                                            "
                                            :text-color="
                                                col.value ? 'white' : 'black'
                                            "
                                            :icon="
                                                col.value ? 'check' : 'error'
                                            "
                                            :label="col.value ? 'Si' : 'No'"
                                        />
                                    </q-item-label>
                                    <q-item-label caption v-else>
                                        <span
                                            v-html="col.value ? col.value : ''"
                                        ></span>
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section
                                    v-else-if="col.name === 'actions'"
                                >
                                    <q-separator />
                                    <div class="q-pa-sm q-gutter-sm text-right">
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
                                    </div>
                                </q-item-section>
                            </slot>
                        </q-item>
                    </q-list>
                </q-card>
            </div>
        </template>
    </q-table>
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
        type: "boolean",
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
