<template>
    <q-list :class="Screen.xs || Screen.sm ? null : 'bg-primary text-white'">
        <q-item clickable>
            <q-item-section>
                <q-item-label> novedades </q-item-label>
            </q-item-section>
            <q-item-section avatar></q-item-section>
        </q-item>
        <q-item
            clickable
            @click="filter.withOfferOrPromo = !filter.withOfferOrPromo"
        >
            <q-item-section>
                <q-item-label> ofertas y promociones </q-item-label>
            </q-item-section>
            <q-item-section avatar>
                <q-icon name="check" v-if="filter.withOfferOrPromo" />
            </q-item-section>
        </q-item>
        <q-item
            v-for="c in categories"
            :key="`category-${c.id}`"
            clickable
            @click="filter.category = category === c.id ? null : c.id"
        >
            <q-item-section>
                <q-item-label>
                    {{ c.name }}
                </q-item-label>
            </q-item-section>
            <q-item-section avatar>
                <q-icon name="check" v-if="filter.category === c.id" />
            </q-item-section>
        </q-item>
        <q-item clickable @click="showLegalConditions = true">
            <q-item-section>
                <q-item-label> terminos y condiciones legales </q-item-label>
            </q-item-section>
        </q-item>
    </q-list>

    <legal-contracting
        :show="showLegalConditions"
        :show-title="false"
        @hide="showLegalConditions = false"
    />
</template>

<script setup>
import { ref, watch } from "vue";
import LegalContracting from "../../others/LegalContracting.vue";
import { Screen } from "quasar";

defineOptions({
    name: "HelpQuestion",
});

const props = defineProps({
    product: Object,
    categories: {
        type: Array,
        default: [],
    },
    category: Number | String,
});

const emits = defineEmits(["change"]);

const filter = ref({
    withOfferOrPromo: false,
    category: null,
});

const showLegalConditions = ref(false);

watch(
    filter,
    (n) => {
        emits("change", n);
    },
    { deep: true }
);

watch(
    () => props.category,
    (n) => {
        filter.value.category = n;
    }
);
</script>
