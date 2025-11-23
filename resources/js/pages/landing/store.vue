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
                                    v-for="c in $page.props.categories"
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
                        :options="
                            categories.map((c) => {
                                return {
                                    label: c.name,
                                    value: c.id,
                                };
                            })
                        "
                        @update="
                            (name, val) => {
                                category = val;
                                filter();
                            }
                        "
                    />
                </q-item-section>
                <q-item-section avatar>
                    <select-field
                        label="subcategoria"
                        name="subcategory"
                        :model-value="subcategory"
                        :options="subcategories"
                        :disable="!category"
                        @update="(name, val) => (subcategory = val)"
                    />
                </q-item-section>
                <q-item-section avatar>
                    <text-field
                        label="buscar"
                        name="search"
                        @update="
                            (name, val) => {
                                query = val;
                                filter();
                            }
                        "
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
            <div class="row">
                <div class="col q-pa-lg">
                    <template v-if="categories.length > 0">
                        <template
                            v-for="category in categories"
                            :key="`category-${category.id}`"
                        >
                            <q-item-label>
                                <q-icon
                                    :name="`img:${$page.props.public_path}storage/${category.image}`"
                                    size="20px"
                                />
                                {{ category.name }}
                            </q-item-label>
                            <q-item-label>
                                <span v-html="category.description"></span>
                            </q-item-label>
                            <q-item-label v-if="category.subtitles.length > 0">
                                <q-expansion-item
                                    group="somegroup"
                                    expand-separator
                                    v-for="subtitle in category.subtitles"
                                    :key="`subtitle-${subtitle.id}`"
                                    :label="subtitle.name"
                                >
                                    <q-card>
                                        <q-card-section>
                                            <span
                                                v-html="subtitle.description"
                                            ></span>
                                        </q-card-section>
                                    </q-card>
                                </q-expansion-item>
                            </q-item-label>
                            <template
                                v-for="subcategory in category.subcategories"
                                :key="`subcategory-${subcategory.id}`"
                            >
                                <q-item-label>
                                    <q-icon
                                        :name="`img:${$page.props.public_path}storage/${subcategory.image}`"
                                        size="20px"
                                    />
                                    {{ subcategory.name }}
                                </q-item-label>
                                <q-item-label v-if="subcategory.description">
                                    <span
                                        v-html="subcategory.description"
                                    ></span>
                                </q-item-label>
                                <q-item-label>
                                    <q-expansion-item
                                        group="somegroup"
                                        expand-separator
                                        v-for="subtitle in subcategory.subtitles"
                                        :key="`subtitle-${subtitle.id}`"
                                        :label="subtitle.name"
                                    >
                                        <q-card>
                                            <q-card-section>
                                                <span
                                                    v-html="
                                                        subtitle.description
                                                    "
                                                ></span>
                                            </q-card-section>
                                        </q-card>
                                    </q-expansion-item>
                                </q-item-label>
                                <q-item-label>
                                    <store-component
                                        :products="subcategory.products"
                                        @add-product="
                                            (prod) =>
                                                updateProductsStorage(prod)
                                        "
                                    />
                                </q-item-label>

                                <q-item-label v-if="subcategory.end_text">
                                    <span v-html="subcategory.end_text"></span>
                                </q-item-label>
                            </template>

                            <q-item-label v-if="category.end_text">
                                <span v-html="category.end_text"></span>
                            </q-item-label>
                        </template>
                    </template>
                    <q-item-label class="text-center text-h5 q-mt-xl" v-else>
                        no existen productos
                    </q-item-label>
                </div>
                <div class="col-auto cursor-pointer" @click="showBasket = true">
                    <div
                        class="bg-primary q-mr-md"
                        style="width: 30px; margin-top: -6px; height: 100%"
                    ></div>
                </div>
            </div>
        </div>
    </Layout>

    <legal-contracting
        :show="showLegalConditions"
        :show-title="false"
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
import { cloneDeep } from "lodash";

defineOptions({
    name: "Store",
});

const page = usePage();
const $q = useQuasar();
const showBasket = ref(false);
const showAuth = ref(false);
const showPaymentOnLogin = ref(false);
const query = ref(null);
const category = ref(null);
const subcategory = ref(null);
const withOfferOrPromo = ref(false);
const showLegalConditions = ref(false);
const categories = ref([]);
const subcategories = ref([]);
let allCategories = [];

onBeforeMount(() => {
    loadProductsFromStorage();
});

onMounted(() => {
    let list = [];
    page.props.categories.forEach((c) => {
        list.push({
            ...c,
            all_subcategories: c.subcategories,
        });
    });
    categories.value = list;
    allCategories = list;
    if (page.props.flash_success) {
        success(page.props.flash_success);
        removeAllProductsFromStorage();
    }
    if (location.hash) {
        // let product = products.value.find(
        //     (p) => p.id === parseInt(location.hash.split("-")[2])
        // );
        // $q.dialog({
        //     title: "info",
        //     message: `usted fue redirigido a la tienda, para continuar debe comprar el producto <b>${product?.name}</b>`,
        //     persistent: true,
        //     html: true,
        //     icon: "info",
        // }).onOk(() => {
        //     location.hash = "";
        //     query.value = product?.name;
        //     filterProducts();
        // });
    }
});

watch(category, (n) => {
    subcategory.value = null;
    subcategories.value = [];
    if (n) {
        let categ = categories.value.find((c) => c.id === n);
        if (categ) {
            subcategories.value = categ.all_subcategories.map((s) => {
                return {
                    label: s.name,
                    value: s.id,
                };
            });
        }
    }
    filter();
});

watch(withOfferOrPromo, () => {
    filter();
});

const filter = () => {
    let list = cloneDeep(allCategories);
    let c = category.value,
        q = query.value,
        s = subcategory.value;
    if (c) {
        let categ = list.find((cat) => cat.id === c);
        list = categ ? [categ] : [];
    }
    if (s && list.length > 0) {
        let subcateg = list[0].all_subcategories.find((sub) => sub.id === s);
        list[0].subcategories = subcateg ? [subcateg] : [];
    }
    if (withOfferOrPromo.value) {
        list.forEach((categ) => {
            categ.subcategories.forEach((subcateg) => {
                subcateg.products = subcateg.products.filter(
                    (p) => p.offers_or_promo
                );
            });
        });
    }
    if (q) {
        list.forEach((categ) => {
            categ.subcategories.forEach((subcateg) => {
                subcateg.products = subcateg.products.filter((p) =>
                    p.name.includes(q)
                );
            });
        });
    }

    list.forEach((l) => {
        l.subcategories = l.subcategories.filter((s) => s.products.length > 0);
    });

    categories.value = list.filter((l) => l.subcategories.length > 0);
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
