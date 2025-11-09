<template>
    <Head>
        <title>
            Cursos y consulta online – Aprender a liberar y Crear la realidad
            conscientemente | Sbye Transformación
        </title>
        <meta
            name="description"
            content="Cursos de María Garriga Domínguez para liberar emociones, transformar creencias y crear conscientemente la vida que deseas. Aprende a vivir desde tu esencia."
        />
        <meta
            name="keywords"
            content="cursos liberación emocional, crear la realidad, consciencia, desprogramación emocional, maria garriga, consulta desarrollo personal"
        />
    </Head>
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
                    :show-payment-on-login="showPaymentOnLogin"
                    @hide="
                        {
                            showAuth = false;
                            showPaymentOnLogin = false;
                        }
                    "
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
                                    <q-item-section avatar></q-item-section>
                                </q-item>
                                <q-item
                                    clickable
                                    @click="
                                        withOfferOrPromo = !withOfferOrPromo
                                    "
                                >
                                    <q-item-section>
                                        <q-item-label>
                                            ofertas y promociones
                                        </q-item-label>
                                    </q-item-section>
                                    <q-item-section avatar>
                                        <q-icon
                                            name="check"
                                            v-if="withOfferOrPromo"
                                        />
                                    </q-item-section>
                                </q-item>
                                <q-item
                                    v-for="c in categories"
                                    :key="`category-${c.id}`"
                                    clickable
                                    @click="
                                        category =
                                            category === c.id ? null : c.id
                                    "
                                >
                                    <q-item-section>
                                        <q-item-label>
                                            {{ c.name }}
                                        </q-item-label>
                                    </q-item-section>
                                    <q-item-section avatar>
                                        <q-icon
                                            name="check"
                                            v-if="category === c.id"
                                        />
                                    </q-item-section>
                                </q-item>
                                <q-item
                                    clickable
                                    @click="showLegalConditions = true"
                                >
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
                        :model-value="category"
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
                        @hide="
                            {
                                showBasket = false;
                                showPaymentOnLogin = false;
                            }
                        "
                        @show-auth="
                            {
                                showAuth = true;
                                showPaymentOnLogin = true;
                            }
                        "
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

    <legal-contracting
        :show="showLegalConditions"
        @hide="showLegalConditions = false"
    />
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
import LegalContracting from "../../components/others/LegalContracting.vue";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";
import { usePage, Head } from "@inertiajs/vue3";
import {
    updateProductsStorage,
    products as selectedProducts,
    loadProductsFromStorage,
    removeAllProductsFromStorage,
} from "../../services/shopping";
import { success } from "../../helpers/notifications";
import { useQuasar } from "quasar";
defineOptions({
    name: "ConsultaIndividual",
});

const page = usePage();
const $q = useQuasar();
const showBasket = ref(false);
const showAuth = ref(false);
const showPaymentOnLogin = ref(false);
const products = ref([]);
const query = ref(null);
const category = ref(null);
const withOfferOrPromo = ref(false);
const allNodes = ref([]);
const categories = ref([]);
const showLegalConditions = ref(false);

onBeforeMount(() => {
    loadProductsFromStorage();
});

onMounted(() => {
    products.value = page.props.products;
    if (page.props.flash_success) {
        success(page.props.flash_success);
        removeAllProductsFromStorage();
    }
    if (location.hash) {
        let product = products.value.find(
            (p) => p.id === parseInt(location.hash.split("-")[2])
        );
        $q.dialog({
            title: "info",
            message: `usted fue redirigido a la tienda, para continuar debe comprar el producto <b>${product?.name}</b>`,
            persistent: true,
            html: true,
            icon: "info",
        }).onOk(() => {
            location.hash = "";
            query.value = product?.name;
            filterProducts();
        });
    }
    allNodes.value = page.props.all_nodes;
    categories.value = page.props.categories;
});

watch(category, () => {
    filterProducts();
});

watch(withOfferOrPromo, () => {
    filterProducts();
});

watch(query, () => {
    filterProducts();
});

const nodeMap = computed(() => {
    const map = {};
    allNodes.value.forEach((item) => {
        map[item.key] = { ...item, children: [] };
    });
    return map;
});

const treeData = computed(() => {
    const map = nodeMap.value;
    const tree = [];
    allNodes.value.forEach((item) => {
        const node = map[item.key];
        if (item.parent === null) {
            tree.push(node);
        } else {
            const parentNode = map[item.parent_key];
            if (parentNode) {
                parentNode.children.push(node);
            }
        }
    });
    return tree;
});

const filterProducts = () => {
    const c = category.value;
    const q = query.value;
    let temp = page.props.products;
    if (c) {
        temp = temp.filter((p) => p.category_id === c);
    }
    if (withOfferOrPromo.value) {
        temp = temp.filter((p) => p.offers_or_promo);
    }
    if (q) {
        temp = temp.filter((p) => p.name.includes(q));
    }
    console.log(temp);

    products.value = temp;
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
