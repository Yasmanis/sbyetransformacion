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

            <q-page-sticky
                position="top-right"
                :offset="[45, 148]"
                style="z-index: 9"
            >
                <div
                    class="row q-gutter-y-sm bg-primary q-pa-xs"
                    style="
                        border-top-left-radius: 10px;
                        border-bottom-left-radius: 10px;
                    "
                >
                    <div class="col">
                        <my-wishes-component only-btn tooltips="mis deseos" />
                    </div>

                    <div class="col">
                        <btn-basket-component @click="showBasket = true">
                            <q-badge
                                floating
                                style="margin-top: -3px; margin-right: -5px"
                                v-if="selectedProducts.length > 0"
                                >{{ selectedProducts.length }}</q-badge
                            ></btn-basket-component
                        >
                    </div>
                </div>
            </q-page-sticky>

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
                <q-item-section avatar v-if="Screen.xs || Screen.sm">
                    <btn-list-component size="lg" v-if="Screen.xs || Screen.sm">
                        <q-menu>
                            <menu-component
                                :categories="$page.props.categories"
                                :category="category"
                                @change="
                                    (data) => {
                                        category = data.category;
                                        withOfferOrPromo =
                                            data.withOfferOrPromo;
                                    }
                                "
                            />
                        </q-menu>
                    </btn-list-component>
                </q-item-section>
                <template v-if="!Screen.xs">
                    <q-item-section avatar>
                        <select-field
                            label="categoria"
                            name="category"
                            :model-value="category"
                            :options="allCategories"
                            @update="(name, val) => (category = val)"
                        />
                    </q-item-section>
                    <q-item-section avatar>
                        <select-field
                            label="subcategoria"
                            name="subcategory"
                            :model-value="subcategory"
                            :options="
                                $page.props.subcategories
                                    .filter((c) => c.category_id === category)
                                    .map((s) => {
                                        return {
                                            ...s,
                                            label: s.name,
                                            value: s.id,
                                        };
                                    }) ?? []
                            "
                            :disable="!category"
                            @update="
                                (name, val) => {
                                    subcategory = val;
                                }
                            "
                        />
                    </q-item-section>
                    <q-item-section avatar>
                        <text-field
                            label="buscar por producto"
                            name="search"
                            @update="(name, val) => (query = val)"
                        >
                            <template #append>
                                <q-btn-component icon="search" />
                            </template>
                        </text-field>
                    </q-item-section>
                </template>

                <q-item-section />
                <q-item-section
                    avatar
                    style="min-width: 20px; width: 30px; padding: 0"
                >
                </q-item-section>
                <q-item-section
                    avatar
                    class="q-ml-sm"
                    style="min-width: 20px; width: 30px; padding: 0"
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
                    />
                </q-item-section>
            </q-item>
            <div class="row" v-if="Screen.xs">
                <div class="col">
                    <q-list dense>
                        <q-item>
                            <q-item-section>
                                <select-field
                                    label="categoria"
                                    name="category"
                                    :filterable="false"
                                    :model-value="category"
                                    :options="allCategories"
                                    @update="(name, val) => (category = val)"
                                />
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section>
                                <select-field
                                    label="subcategoria"
                                    name="subcategory"
                                    :filterable="false"
                                    :model-value="subcategory"
                                    :options="
                                        $page.props.subcategories
                                            .filter(
                                                (c) =>
                                                    c.category_id === category,
                                            )
                                            .map((s) => {
                                                return {
                                                    ...s,
                                                    label: s.name,
                                                    value: s.id,
                                                };
                                            }) ?? []
                                    "
                                    :disable="!category"
                                    @update="
                                        (name, val) => {
                                            subcategory = val;
                                        }
                                    "
                                />
                            </q-item-section>
                        </q-item>
                        <q-item>
                            <q-item-section>
                                <text-field
                                    label="buscar por producto"
                                    name="search"
                                    @update="(name, val) => (query = val)"
                                >
                                    <template #append>
                                        <q-btn-component icon="search" />
                                    </template>
                                </text-field>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </div>
                <div class="col-auto cursor-pointer" @click="showBasket = true">
                    <div
                        class="bg-primary q-mr-md"
                        style="width: 30px; margin-top: -4px; height: 100%"
                    ></div>
                </div>
            </div>

            <div class="row">
                <div
                    class="col col-auto q-pt-lg q-pl-md"
                    v-if="!Screen.xs && !Screen.sm"
                >
                    <menu-component
                        :categories="$page.props.categories"
                        :category="category"
                        @change="
                            (data) => {
                                category = data.category;
                                withOfferOrPromo = data.withOfferOrPromo;
                            }
                        "
                    />
                </div>
                <div class="col q-pa-lg">
                    <template v-if="categories.length > 0">
                        <template
                            v-for="(category, indexCategory) in categories"
                            :key="`category-${category.id}`"
                        >
                            <q-item-label
                                class="q-mb-md"
                                :class="{
                                    'q-mt-lg': indexCategory !== 0,
                                }"
                            >
                                <q-item dense style="padding: 0">
                                    <q-item-section
                                        avatar
                                        style="min-width: 10px; padding: 0"
                                    >
                                        <q-icon
                                            :name="`img:${$page.props.public_path}storage/${category.image}`"
                                            size="30px"
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <h4
                                            class="q-ml-sm q-pt-xs text-bold text-uppercase"
                                        >
                                            {{ category.name }}
                                        </h4>
                                    </q-item-section>
                                </q-item>
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
                                v-for="(
                                    subcategory, indexSubcategory
                                ) in category.subcategories"
                                :key="`subcategory-${indexSubcategory.id}`"
                            >
                                <div
                                    class="q-pa-md"
                                    :class="
                                        indexSubcategory % 2 === 0
                                            ? 'bg-primary'
                                            : null
                                    "
                                >
                                    <q-item-label class="q-mb-sm">
                                        <q-item dense style="padding: 0">
                                            <q-item-section
                                                avatar
                                                style="
                                                    padding: 0;
                                                    min-width: 10px;
                                                "
                                            >
                                                <q-icon
                                                    :name="`img:${
                                                        $page.props.public_path
                                                    }storage/${
                                                        indexSubcategory % 2 ===
                                                        0
                                                            ? subcategory.white_image
                                                            : subcategory.black_image
                                                    }`"
                                                    size="20px"
                                                />
                                            </q-item-section>
                                            <q-item-section>
                                                <h4
                                                    class="q-ml-sm text-lowercase text-bold"
                                                    :class="
                                                        indexSubcategory % 2 ===
                                                        0
                                                            ? 'text-white'
                                                            : null
                                                    "
                                                >
                                                    {{ subcategory.name }}
                                                </h4>
                                            </q-item-section>
                                        </q-item>
                                    </q-item-label>
                                    <q-item-label
                                        :class="
                                            indexSubcategory % 2 === 0
                                                ? 'text-white'
                                                : null
                                        "
                                        v-if="subcategory.description"
                                    >
                                        <span
                                            v-html="subcategory.description"
                                        ></span>
                                    </q-item-label>
                                    <q-item-label
                                        :class="
                                            indexSubcategory % 2 === 0
                                                ? 'text-white'
                                                : null
                                        "
                                    >
                                        <q-expansion-item
                                            group="somegroup"
                                            expand-separator
                                            v-for="subtitle in subcategory.subtitles"
                                            :key="`subtitle-${subtitle.id}`"
                                            :label="subtitle.name"
                                        >
                                            <q-card
                                                :class="
                                                    indexSubcategory % 2 === 0
                                                        ? 'bg-primary'
                                                        : null
                                                "
                                            >
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

                                    <q-item-label
                                        :class="
                                            indexSubcategory % 2 === 0
                                                ? 'text-white'
                                                : null
                                        "
                                        v-if="subcategory.end_text"
                                    >
                                        <span
                                            v-html="subcategory.end_text"
                                        ></span>
                                    </q-item-label>
                                </div>
                                <div
                                    class="bg-primary q-my-md"
                                    style="height: 5px"
                                    v-if="
                                        category.end_text &&
                                        indexSubcategory % 2 !== 0
                                    "
                                ></div>
                            </template>

                            <q-item-label
                                class="q-mt-sm"
                                v-if="category.end_text"
                            >
                                <span
                                    v-html="category.end_text"
                                    :class="
                                        indexCategory % 2 === 0
                                            ? 'text-white'
                                            : null
                                    "
                                ></span>
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
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import DialogAuthComponent from "../../components/landing/store/DialogAuthComponent.vue";
import CarComponent from "../../components/modules/shopping/components/CarComponent.vue";
import StoreComponent from "../../components/modules/store/StoreComponent.vue";
import SelectField from "../../components/form/input/SelectField.vue";
import TextField from "../../components/form/input/TextField.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import BtnBasketComponent from "../../components/btn/BtnBasketComponent.vue";
import BtnListComponent from "../../components/btn/BtnListComponent.vue";
import MyWishesComponent from "../../components/modules/store/MyWishesComponent.vue";
import MenuComponent from "../../components/modules/store/MenuComponent.vue";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";
import { usePage, Head } from "@inertiajs/vue3";
import {
    updateProductsStorage,
    products as selectedProducts,
    loadProductsFromStorage,
    removeAllProductsFromStorage,
} from "../../services/shopping";
import { success } from "../../helpers/notifications";
import { Screen } from "quasar";
import { cloneDeep } from "lodash";

defineOptions({
    name: "Store",
});

const page = usePage();
const showBasket = ref(false);
const showAuth = ref(false);
const showPaymentOnLogin = ref(false);
const query = ref(null);
const category = ref(null);
const subcategory = ref(null);
const withOfferOrPromo = ref(false);
const categories = ref([]);
let fromHash = false;

onBeforeMount(() => {
    loadProductsFromStorage();
});

onMounted(() => {
    let categoriesList = page.props.categories;
    if (page.props.flash_success) {
        success(page.props.flash_success);
        removeAllProductsFromStorage();
    }
    if (location.hash) {
        let subCategId = parseInt(location.hash.substring(1));
        for (let i = 0; i < categoriesList.length; i++) {
            let temp = categoriesList[i].subcategories.find(
                (s) => s.id === subCategId,
            );
            if (temp) {
                category.value = temp.category_id;
                subcategory.value = subCategId;
                fromHash = true;
                break;
            }
        }
        setTimeout(() => {
            location.hash = "";
        }, 600);
    } else {
        filter();
    }
});

watch(category, () => {
    if (!fromHash) {
        subcategory.value = null;
    }
    fromHash = false;
    filter();
});

watch(subcategory, () => {
    filter();
});

watch(withOfferOrPromo, () => {
    filter();
});

watch(query, () => {
    filter();
});

const allCategories = computed(() => {
    return page.props.categories.map((c) => {
        return {
            ...c,
            label: c.name,
            value: c.id,
        };
    });
});

const filter = () => {
    let list = cloneDeep(allCategories.value);
    let c = category.value,
        q = query.value,
        s = subcategory.value;
    if (c) {
        let categ = list.find((cat) => cat.id === c);
        list = categ ? [categ] : [];
    }
    if (s && list.length > 0) {
        list[0].subcategories = [
            list[0].subcategories.find((ss) => ss.id === s),
        ];
    }
    if (withOfferOrPromo.value) {
        list.forEach((categ) => {
            categ.subcategories.forEach((subcateg) => {
                subcateg.products = subcateg.products.filter(
                    (p) => p.offers_or_promo,
                );
            });
        });
    }
    if (q) {
        const searchTerm = q.toLowerCase().trim();
        list.forEach((cat) => {
            cat.subcategories.forEach((sub) => {
                sub.products = sub.products.filter((p) =>
                    p.name.toLowerCase().includes(searchTerm),
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
.text-white > span > p > span {
    color: white !important;
}
</style>
