<template>
    <q-menu
        v-model="model"
        :target="target"
        transition-show="scale"
        transition-hide="scale"
        @show="emits('show')"
        @hide="emits('hide')"
        class="q-pa-xs"
    >
        <q-input
            v-model="filter"
            ref="filterRef"
            dense
            clearable
            placeholder="Filtrar..."
            @clear="filter = ''"
        >
            <template v-slot:append>
                <q-icon name="search" />
            </template>
        </q-input>

        <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="danger"
            indicator-color="primary"
            narrow-indicator
            v-if="filter !== ''"
        >
            <q-tab
                name="tab-filter"
                label="RESULTADOS OBTENIDOS"
                style="padding: 0px !important"
            ></q-tab>
            <q-tab
                label="CERRAR"
                name="tab-close"
                style="padding: 0px !important"
            >
            </q-tab>
        </q-tabs>
        <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="danger"
            indicator-color="primary"
            narrow-indicator
            v-else
        >
            <q-tab
                v-for="(c, index) in categories"
                :key="`tab-${index}`"
                :icon="c.ico"
                :name="`tab-${c.group}`"
                style="padding: 0px !important"
            ></q-tab>
            <q-tab
                icon="close"
                name="tab-close"
                style="padding: 0px !important"
            >
                <q-tooltip class="text-body2">cerrar</q-tooltip></q-tab
            >
        </q-tabs>
        <q-separator />
        <q-tab-panels
            v-model="tab"
            animated
            style="padding: 0px !important"
            v-if="filter !== ''"
        >
            <q-tab-panel name="tab-filter" style="padding: 0px !important">
                <q-scroll-area
                    style="height: 200px; width: 435px; padding: 0px !important"
                >
                    <p
                        class="text-bold text-justify"
                        style="
                            padding: 30px !important;
                            margin-top: 30px !important;
                        "
                        v-if="filter_result.length === 0"
                    >
                        no existen coincidencias, cambie la frase para una nueva
                        busqueda
                    </p>
                    <q-btn
                        dense
                        flat
                        size="20px"
                        v-for="(b, indexBtn) in filter_result"
                        :key="`btn-${b.order}`"
                        :label="b.unicode"
                        @click="onClick(b.unicode)"
                    >
                        <q-tooltip class="text-body2">{{ b.label }}</q-tooltip>
                    </q-btn>
                </q-scroll-area>
            </q-tab-panel>
        </q-tab-panels>
        <q-tab-panels
            v-model="tab"
            animated
            style="padding: 0px !important"
            v-else
        >
            <q-tab-panel
                v-for="(c, index) in categories"
                :key="`tab-panel-${index}`"
                :name="`tab-${c.group}`"
                style="padding: 0px !important"
            >
                <p
                    class="text-uppercase"
                    style="
                        margin-top: 5px !important;
                        margin-bottom: 5px !important;
                    "
                >
                    {{ c.label }}
                </p>
                <q-scroll-area
                    style="height: 200px; width: 410px; padding: 0px !important"
                >
                    <q-btn
                        dense
                        flat
                        size="20px"
                        v-for="(b, indexBtn) in c.emojis"
                        :key="`btn-${b.order}`"
                        :label="b.unicode"
                        @click="onClick(b.unicode)"
                    >
                        <q-tooltip class="text-body2">{{ b.label }}</q-tooltip>
                    </q-btn>
                </q-scroll-area>
            </q-tab-panel>
        </q-tab-panels>
    </q-menu>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { categories, emojis } from "../../../../helpers/emojis";

defineOptions({
    name: "EmojisMenuComponent",
});

const props = defineProps({
    target: String,
});

const emits = defineEmits(["show", "hide", "selected"]);
const model = ref(null);
const tab = ref(null);
const filter = ref("");
const filter_result = ref([]);
const filterRef = ref(null);

onMounted(async () => {
    model.value = props.target !== null;
    categories.forEach((c) => {
        c["emojis"] = emojis.filter((e) => e.group == c.group);
    });
    tab.value = `tab-${categories[0].group}`;
});

watch(
    () => props.target,
    (n, o) => {
        model.value = n !== null;
    }
);

watch(filter, () => {
    filter_result.value = [];
    if (filter.value !== "") {
        emojis.forEach((e) => {
            if (e.label.includes(filter.value)) {
                filter_result.value.push(e);
            }
        });
        if (filter_result.value.length > 0) {
            tab.value = "tab-filter";
        }
    } else {
        tab.value = `tab-${categories[0].group}`;
    }
});

watch(tab, () => {
    if (tab.value === "tab-close") {
        model.value = false;
    }
});

const onClick = (e) => {
    emits("selected", e);
};

const onHide = () => {
    filter.value = "";
    tab.value = `tab-${categories[0].group}`;
};
</script>
