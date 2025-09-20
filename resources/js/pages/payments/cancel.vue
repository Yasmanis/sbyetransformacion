<template>
    <q-card class="q-pa-lg text-center">
        <q-card-section>
            <q-icon name="cancel" color="negative" size="64px" />
            <div class="text-h4 q-mt-md">Pago Cancelado</div>
            <div class="text-subtitle1 q-mt-md">
                Has cancelado el proceso de pago.
            </div>
        </q-card-section>

        <q-card-actions align="center">
            <q-btn
                label="Intentar de Nuevo"
                href="/payments/create"
                color="primary"
            />
        </q-card-actions>
    </q-card>
</template>
