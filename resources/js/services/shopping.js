import { LocalStorage } from "quasar";
import { ref, watch } from "vue";

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

export const removeProductFromStorage = (prod) => {
    products.value = products.value.filter((p) => p.id !== prod.id);
};
