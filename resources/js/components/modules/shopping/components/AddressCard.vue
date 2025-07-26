<template>
    <q-item style="padding: 4px">
        <q-item-section>
            <q-item-label>
                {{ object?.full_name ?? "-" }}
            </q-item-label>
            <q-item-label>
                {{ object?.address ?? "-" }}
            </q-item-label>
            <q-item-label> pueblo – ciudad </q-item-label>
            <q-item-label>
                {{ object?.postal_code }}
                –
                {{ object?.province }}
                ({{ object?.country_str }})
            </q-item-label>
        </q-item-section>
    </q-item>
</template>

<script setup>
defineOptions({
    name: "AddressCard",
});

const props = defineProps({
    object: Object,
});
</script>
