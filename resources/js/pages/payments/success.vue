<template>
    <q-card class="q-pa-lg text-center">
        <q-card-section>
            <q-icon name="check_circle" color="positive" size="64px" />
            <div class="text-h4 q-mt-md">¡Pago Exitoso!</div>
            <div class="text-subtitle1 q-mt-md">
                Tu pago de ${{ $page.props.payment.amount }}
                {{ $page.props.payment.currency }} se ha procesado
                correctamente.
            </div>
        </q-card-section>

        <q-card-actions align="center">
            <q-btn
                label="Volver al Inicio"
                href="/payments/create"
                color="primary"
            />
        </q-card-actions>
    </q-card>
</template>

<script setup>
defineProps({
    payment: Object,
});
</script>
