<template>
    <div ref="paypalContainer" id="paypalContainer"></div>
    <div v-if="error" class="text-red">{{ error }}</div>
    <div v-if="success" class="text-green">¡Pago exitoso!</div>
</template>

<script setup>
import { loadScript } from "@paypal/paypal-js";
import { onMounted, ref } from "vue";

defineOptions({
    name: "PayPalComponent",
});

const error = ref(null);
const success = ref(false);
const paypal = null;

onMounted(() => {
    loadPayPalScript();
});

const loadPayPalScript = async () => {
    try {
        paypal = await loadScript({
            "client-id": "TU_CLIENT_ID_SANDBOX", // Reemplazar con tu Client ID
            currency: "USD",
        });
        renderPayPalButton();
    } catch (err) {
        error.value = "Error al cargar PayPal: " + err.message;
    }
};
const renderPayPalButton = async () => {
    if (!paypal) return;
    paypal
        .Buttons({
            createOrder: async (data, actions) => {
                try {
                    const response = await axios.post("/paypal/create-order", {
                        amount: "10.00",
                    });
                    return response.data.id;
                } catch (err) {
                    error.value = "Error al crear orden: " + err.message;
                    return null;
                }
            },
            onApprove: async (data, actions) => {
                // Llamada a Laravel para capturar pago
                try {
                    const response = await axios.post("/paypal/capture-order", {
                        order_id: data.orderID,
                    });

                    if (response.data.status === "COMPLETED") {
                        success.value = true;
                        // Opcional: redirigir con Inertia
                        // this.$inertia.visit('/success');
                    }
                } catch (error) {
                    error.value = "Error al capturar pago: " + error.message;
                }
            },
            onError: (err) => {
                error.value = "Error en el pago: " + err.message;
            },
        })
        .render($refs.paypalContainer);
};
</script>
