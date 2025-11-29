import { usePage } from "@inertiajs/vue3";
import { LocalStorage } from "quasar";
import { computed, ref, watch } from "vue";

export const products = ref([]);

watch(
    products,
    (n) => {
        LocalStorage.setItem("products_to_car", n);
    },
    { deep: true }
);

export const loadProductsFromStorage = () => {
    if (products.value.length === 0) {
        products.value = LocalStorage.getItem("products_to_car") ?? [];
    }
};

export const updateProductsStorage = (prod) => {
    const list = products.value;
    let index = list.findIndex((p) => p.id === prod.id);
    if (index >= 0) {
        list[index].total_to_car = parseInt(list[index].total_to_car) + 1;
    } else {
        list.push({
            ...prod,
            total_to_car: 1,
        });
    }
};

export const getProductFromStorage = (prod) => {
    return products.value.find((p) => p.id === prod.id) ?? null;
};

export const addProductToStorage = (prod) => {
    const exist = getProductFromStorage(prod);
    if (exist === null) {
        products.value.push(prod);
    }
};

export const removeProductFromStorage = (prod) => {
    products.value = products.value.filter((p) => p.id !== prod.id);
};

export const getProductByIdFromBasket = (id) => {
    const products = LocalStorage.getItem("products_to_car") ?? [];
    return products.find((p) => p.id === id) ?? null;
};

export const getProductByNameFromBasket = (name) => {
    const products = LocalStorage.getItem("products_to_car") ?? [];
    return products.find((p) => p.name === name) ?? null;
};

export const removeAllProductsFromStorage = () => {
    products.value = [];
};

export const subtotalAmount = computed(() => {
    let total = 0;
    products.value.forEach((p) => {
        total += p.final_price;
    });
    return total;
});

export const pendingAmount = computed(() => {
    let total = 0;
    products.value.forEach((p) => {
        total += p.total_to_car * (p.price - p.first_payment);
    });
    return total;
});

export const paymentsMethods = computed(() => {
    return usePage().props.auth?.user?.payment_methods ?? [];
});

export const billingsInformation = computed(() => {
    return usePage().props.auth?.user?.billings_information ?? [];
});

export const currentPaymentMethod = ref(null);
export const currentBillingInformation = ref(null);
