<template>
    <Layout>
        <q-page padding>
            <div class="row bg-red q-pa-md text-h5 text-white q-my-sm">
                <div class="col text-center">
                    esta pagina no funciona correctamente dado que está en
                    desarrollo
                </div>
            </div>
            <q-tabs
                v-model="tab"
                no-caps
                inline-label
                align="left"
                class="text-white"
            >
                <q-tab name="payments" icon="mdi-cart" label="mis compras" />
                <q-tab name="wishes" icon="mdi-cart-heart" label="mis deseos" />
                <q-tab name="store" icon="mdi-cart-variant" label="tienda" />
                <q-space />
                <template v-if="tab === 'payments'">
                    <filter-component
                        color="white"
                        :fields="filterFields"
                        @refresh-data="onChangeFilters"
                    />
                    <q-btn-component
                        tooltips="limpiar todo"
                        icon="mdi-eraser"
                        color="white"
                        @click="router.get('/admin/shopping')"
                        v-if="currentFilters"
                    />
                </template>
                <car-component
                    :only-btn="true"
                    size="15px"
                    color="white"
                    style="margin-right: 5px !important"
                    v-if="tab !== 'store'"
                />
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated class="q-mt-xs">
                <q-tab-panel name="payments" style="padding: 0px !important">
                    <payments-users @sales-again="(p) => onNewSale(p)" />
                </q-tab-panel>

                <q-tab-panel name="wishes"> panel mis deseos </q-tab-panel>

                <q-tab-panel name="store">
                    <shopping-component />
                </q-tab-panel>
            </q-tab-panels>
            <!--  -->
        </q-page>
    </Layout>
</template>

<script setup>
import { computed, onBeforeMount, ref, watch } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import ShoppingComponent from "../../components/modules/shopping/ShoppingComponent.vue";
import PaymentsUsers from "../../components/modules/shopping/PaymentsUsers.vue";
import { router, usePage } from "@inertiajs/vue3";
import FilterComponent from "../../components/table/actions/FilterComponent.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import CarComponent from "../../components/modules/shopping/components/CarComponent.vue";

defineOptions({
    name: "SalesPage",
});

const tab = ref(null);
const page = usePage();

const currentFilters = ref(null);

const filterFields = [
    {
        field: "created_at",
        name: "created_at",
        label: "fecha",
        type: "date",
    },
];

onBeforeMount(() => {
    tab.value = page.props.show_payment ? "store" : "payments";
});

const properties = computed(() => {
    return page.props;
});

watch(
    properties,
    (val) => {
        currentFilters.value = val.filters ? JSON.stringify(val.filters) : null;
    },
    {
        immediate: true,
        deep: true,
    },
);

const onNewSale = (p) => {
    // let data = {
    //     scrollTo: `#product-store-${p.id}`,
    // };
    // location.hash = btoa(JSON.stringify(data));
    tab.value = "store";
};

const onChangeFilters = (name, data) => {
    router.get(
        "",
        { filters: data ? JSON.stringify(data) : null },
        {
            preserveState: true,
        },
    );
};
</script>
