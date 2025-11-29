<template>
    <div class="row">
        <div class="col">
            <q-card flat>
                <q-card-section class="q-pa-none">
                    <q-list dense>
                        <q-item style="padding-left: 0">
                            <q-item-section avatar top>
                                <q-img
                                    :src="`${$page.props.public_path}${
                                        product.image_path?.substring(1) ??
                                        'images/logo/2.png'
                                    }`"
                                    width="70px"
                                />
                            </q-item-section>
                            <q-item-section top>
                                <q-item-label class="text-bold">
                                    {{ product.name }}
                                </q-item-label>
                                <q-item-label>
                                    Precio: {{ product.final_price }} €
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar top>
                                <btn-delete-component
                                    @click="removeProductFromStorage(product)"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import BtnDeleteComponent from "../../../btn/BtnDeleteComponent.vue";
import { removeProductFromStorage } from "../../../../services/shopping";

defineOptions({
    name: "Products",
});

const props = defineProps({
    object: Object,
});

const product = ref(null);

onBeforeMount(() => {
    product.value = props.object;
});
</script>
