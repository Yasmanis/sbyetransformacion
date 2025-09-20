<template>
    <Layout>
        <q-page padding class="bg-grey-1">
            <div class="row justify-center">
                <div class="col-12 col-md-6">
                    <q-card class="q-pa-lg">
                        <q-card-section>
                            <div class="text-h5 text-center text-primary">
                                Checkout de Pago
                            </div>
                        </q-card-section>

                        <q-card-section>
                            <q-form @submit="createPayment" class="q-gutter-md">
                                <q-input
                                    v-model="form.amount"
                                    label="Monto"
                                    type="number"
                                    step="0.01"
                                    min="0.01"
                                    required
                                    filled
                                    :rules="[
                                        (val) =>
                                            val > 0 ||
                                            'El monto debe ser mayor a 0',
                                    ]"
                                />

                                <q-input
                                    v-model="form.description"
                                    label="Descripción"
                                    type="textarea"
                                    filled
                                    rows="2"
                                />

                                <div class="text-center">
                                    <q-btn
                                        label="Pagar con PayPal"
                                        type="submit"
                                        color="primary"
                                        :loading="loading"
                                        icon="paypal"
                                        size="lg"
                                    />
                                </div>
                            </q-form>
                        </q-card-section>
                    </q-card>

                    <!-- Historial de pagos -->
                    <!-- <q-card class="q-mt-md">
                    <q-card-section>
                        <div class="text-h6">Historial de Pagos</div>
                    </q-card-section>
                    <q-card-section>
                        <PaymentHistory />
                    </q-card-section>
                </q-card> -->
                </div>
            </div>
        </q-page></Layout
    >
</template>

<script setup>
import { ref, reactive } from "vue";
import { useQuasar, openURL, LocalStorage } from "quasar";
import { router } from "@inertiajs/vue3";
import Layout from "../../layouts/MainLayout.vue";
import axios from "axios";
import { error } from "../../helpers/notifications";
//import PaymentHistory from "@/Components/PaymentHistory.vue";

const $q = useQuasar();
const loading = ref(false);

const form = reactive({
    amount: 100.0,
    description: "Compra de producto/servicio",
});

const createPayment = async () => {
    loading.value = true;
    try {
        const response = await axios.post("/payments/store", form);
        if (response.data.id) {
            LocalStorage.setItem("paypal_payment_id", response.data.id);
            const approveLink = response.data.links.find(
                (link) => link.rel === "approve"
            );
            if (approveLink) {
                window.location.href = approveLink.href;
            }
        }
    } catch (err) {
        error(
            `error al crear el pago: ${
                err.response?.data?.message || err.message
            }`
        );
    } finally {
        loading.value = false;
    }
};
</script>
