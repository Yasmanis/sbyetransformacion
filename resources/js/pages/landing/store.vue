<template>
    <Layout title="tienda">
        <div class="q-py-lg">
            <div class="row bg-red q-pa-md text-h5 text-white">
                <div class="col text-center">
                    esta pagina no funciona correctamente dado que está en
                    desarrollo
                </div>
            </div>
            <q-toolbar>
                <q-toolbar-title></q-toolbar-title>
                <dialog-auth-component
                    :show="showAuth"
                    @hide="showAuth = false"
                />
            </q-toolbar>
            <q-item dense>
                <q-item-section avatar>
                    <btn-list-component size="lg">
                        <q-menu>
                            <q-list dense>
                                <q-item clickable>
                                    <q-item-section>
                                        <q-item-label> novedades </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable>
                                    <q-item-section>
                                        <q-item-label>
                                            ofertas y promociones
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable>
                                    <q-item-section>
                                        <q-item-label>
                                            categoria 1
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable>
                                    <q-item-section>
                                        <q-item-label>
                                            categoria 2
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable>
                                    <q-item-section>
                                        <q-item-label>
                                            terminos y condiciones legales
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-menu>
                    </btn-list-component>
                </q-item-section>
                <q-item-section avatar>
                    <select-field
                        label="categoria"
                        name="category"
                        :others-props="{
                            url_to_options: '/product-categories',
                        }"
                        style="width: 300px !important"
                        @update="(name, val) => (category = val)"
                    />
                </q-item-section>
                <q-item-section avatar>
                    <text-field
                        label="buscar"
                        name="search"
                        @update="(name, val) => (query = val)"
                    >
                        <template #append>
                            <q-btn-component icon="search" />
                        </template>
                    </text-field>
                </q-item-section>
                <q-item-section />
                <q-item-section
                    avatar
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <my-wishes-component only-btn tooltips="mis deseos" />
                </q-item-section>
                <q-item-section
                    avatar
                    class="q-ml-sm"
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <btn-basket-component @click="showBasket = true">
                        <q-badge
                            floating
                            style="margin-top: -3px; margin-right: -5px"
                            v-if="selectedProducts.length > 0"
                            >{{ selectedProducts.length }}</q-badge
                        ></btn-basket-component
                    >
                </q-item-section>
                <q-item-section
                    avatar
                    class="bg-primary q-ml-xl"
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                    <car-component
                        :show="showBasket"
                        :auth-btn="true"
                        @hide="showBasket = false"
                        @show-auth="showAuth = true"
                    />
                </q-item-section>
            </q-item>
            <q-item dense>
                <q-item-section>
                    <store-component
                        :products="products"
                        @add-product="(prod) => updateProductsStorage(prod)"
                        v-if="products.length > 0"
                    />
                    <q-item-label class="text-center text-h5 q-mt-xl" v-else>
                        no existen productos
                    </q-item-label>
                </q-item-section>
                <q-item-section
                    avatar
                    top
                    class="bg-primary q-ml-xl"
                    style="
                        min-width: 20px;
                        width: 30px;
                        padding: 0;
                        margin-top: -6px;
                    "
                >
                </q-item-section>
            </q-item>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";
import CarComponent from "../../components/modules/shopping/components/CarComponent.vue";
import StoreComponent from "../../components/modules/store/StoreComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import SelectField from "../../components/form/input/SelectField.vue";
import TextField from "../../components/form/input/TextField.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import BtnBasketComponent from "../../components/btn/BtnBasketComponent.vue";
import MyWishesComponent from "../../components/modules/store/MyWishesComponent.vue";
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    updateProductsStorage,
    products as selectedProducts,
    loadProductsFromStorage,
} from "../../services/shopping";
defineOptions({
    name: "ConsultaIndividual",
});

const page = usePage();

const showBasket = ref(false);
const showAuth = ref(false);

const products = ref([]);
const query = ref(null);
const category = ref(null);

onBeforeMount(() => {
    loadProductsFromStorage();
});

onMounted(() => {
    products.value = page.props.products;
});

watch(category, () => {
    filterProducts();
});

watch(query, () => {
    filterProducts();
});

const filterProducts = () => {
    const c = category.value;
    const q = query.value;
    if (c && q) {
        products.value = page.props.products.filter(
            (p) => p.categories_id.includes(c) && p.name.includes(q)
        );
    } else if (c) {
        products.value = page.props.products.filter((p) =>
            p.categories_id.includes(c)
        );
    } else if (q) {
        products.value = page.props.products.filter((p) => p.name.includes(q));
    } else {
        products.value = page.props.products;
    }
};
</script>
<style>
figure.media {
    margin: 0px !important;
}
figure.media video {
    width: 30%;
}
</style>
