<template>
    <q-item-section v-if="list[0]">
        <q-chip
            v-model="chip_0"
            :removable="chip"
            outline
            icon="mdi-account-circle"
            icon-remove="mdi-trash-can-outline"
            @remove="removeItem(list[0])"
            style="
                padding-top: 2px !important;
                padding-bottom: 2px !important;
                padding-left: 7px !important;
            "
        >
            <div class="ellipsis">
                {{ list[0].label }}
                <q-tooltip
                    class="text-body2"
                    anchor="top middle"
                    self="bottom middle"
                    :offset="[5, 5]"
                    >{{ list[0].label }}</q-tooltip
                >
            </div>
        </q-chip>
    </q-item-section>
    <q-item-section v-if="list[1]">
        <q-chip
            v-model="chip_1"
            :removable="chip"
            outline
            icon="mdi-account-circle"
            icon-remove="mdi-trash-can-outline"
            @remove="removeItem(list[1])"
            style="
                padding-top: 2px !important;
                padding-bottom: 2px !important;
                padding-left: 7px !important;
            "
        >
            <div class="ellipsis">
                {{ list[1].label }}
                <q-tooltip
                    class="text-body2"
                    anchor="top middle"
                    self="bottom middle"
                    :offset="[5, 5]"
                    >{{ list[1].label }}</q-tooltip
                >
            </div>
        </q-chip>
    </q-item-section>
    <q-item-section v-if="list[2]">
        <q-chip
            v-model="chip_2"
            :removable="chip"
            outline
            icon="mdi-account-circle"
            icon-remove="mdi-trash-can-outline"
            @remove="removeItem(list[2])"
            style="
                padding-top: 2px !important;
                padding-bottom: 2px !important;
                padding-left: 7px !important;
            "
        >
            <div class="ellipsis">
                {{ list[2].label }}
                <q-tooltip
                    class="text-body2"
                    anchor="top middle"
                    self="bottom middle"
                    :offset="[5, 5]"
                    >{{ list[2].label }}</q-tooltip
                >
            </div>
        </q-chip>
    </q-item-section>
    <q-item-section
        avatar
        style="min-width: 30px; padding-left: 0"
        v-if="list[3]"
    >
        <q-btn-component
            tooltips="ver todos"
            icon="add"
            style="width: 20px !important"
        >
            <q-badge
                color="primary"
                floating
                style="margin-top: -6px; margin-right: -8px"
            >
                {{ list.length }}
            </q-badge>
            <q-menu
                class="q-pa-sm q-gutter-xs"
                transition-show="jump-down"
                transition-hide="jump-up"
                style="width: 400px"
            >
                <text-field
                    name="query"
                    placeholder="filtrar"
                    :model-value="query"
                    @update="
                        (name, val) => {
                            query = val;
                        }
                    "
                >
                    <template #append>
                        <q-icon name="search" />
                    </template>
                </text-field>
                <select-field
                    label="rol"
                    :othersProps="{
                        url_to_options: '/roles',
                    }"
                    @update="
                        (name, val) => {
                            role = val;
                        }
                    "
                />
                <div class="row no-wrap">
                    <div style="max-height: 300px; overflow: auto" class="col">
                        <q-infinite-scroll
                            @load="onLoad"
                            :offset="250"
                            ref="infiniteScrollRef"
                        >
                            <q-list dense>
                                <q-item
                                    v-for="(u, userIndex) in displayedItems"
                                    :key="`user_list_${userIndex}`"
                                >
                                    <q-item-section avatar>
                                        <q-avatar
                                            font-size="32px"
                                            icon="mdi-account-circle"
                                        ></q-avatar>
                                    </q-item-section>
                                    <q-item-section>
                                        {{ u.label }}</q-item-section
                                    >
                                    <q-item-section side v-if="chip">
                                        <btn-delete-component
                                            tooltips="quitar de la lista"
                                            @click="removeItem(u)"
                                        />
                                    </q-item-section>
                                </q-item>
                            </q-list>

                            <template v-slot:loading>
                                <div class="row justify-center q-my-sm">
                                    <q-spinner-dots
                                        color="primary"
                                        size="30px"
                                    />
                                </div>
                            </template>
                        </q-infinite-scroll>
                    </div>
                </div>
            </q-menu>
        </q-btn-component>
    </q-item-section>
    <q-item-section
        avatar
        style="min-width: 30px; padding-left: 0"
        v-if="list[3] && chip"
    >
        <btn-delete-component
            tooltips="quitar todos"
            style="width: 20px !important"
            @click="clear"
        />
    </q-item-section>
</template>

<script setup>
import { ref, watch, onMounted, computed, nextTick } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";

defineOptions({
    name: "UsersSelectedComponent",
});

const props = defineProps({
    chip: {
        type: Boolean,
        default: true,
    },
    list: {
        type: Array,
        default: () => [],
    },
});

const query = ref(null);
const role = ref(null);
const infiniteScrollRef = ref(null);

const emits = defineEmits(["remove-item", "clear", "filter"]);

const chip_0 = ref(null);
const chip_1 = ref(null);
const chip_2 = ref(null);

const itemsPerPage = 20;
const loadedCount = ref(itemsPerPage);

onMounted(() => {
    setDefault();
});

watch(
    () => props.list,
    () => {
        setDefault();
        resetScroll();
    },
    { deep: true },
);

watch(query, () => {
    resetScroll();
});

watch(role, () => {
    resetScroll();
});

const filteredItems = computed(() => {
    if (!props.list) return [];
    return props.list.filter((item) => {
        const matchesQuery = query.value
            ? item.label.toLowerCase().includes(query.value.toLowerCase())
            : true;
        const matchesRole = role.value ? item.roles.includes(role.value) : true;
        return matchesQuery && matchesRole;
    });
});

const displayedItems = computed(() => {
    return filteredItems.value.slice(0, loadedCount.value);
});

const setDefault = () => {
    chip_0.value = null;
    chip_1.value = null;
    chip_2.value = null;
};

const onLoad = (index, done) => {
    if (loadedCount.value >= filteredItems.value.length) {
        infiniteScrollRef.value?.stop();
        return;
    }
    setTimeout(() => {
        if (loadedCount.value >= filteredItems.value.length) {
            infiniteScrollRef.value?.stop();
        } else {
            loadedCount.value += itemsPerPage;
            done();
        }
    }, 400);
};

const resetScroll = () => {
    loadedCount.value = itemsPerPage;
    nextTick(() => {
        infiniteScrollRef.value?.resume();
        infiniteScrollRef.value?.poll();
    });
};

const removeItem = (item) => {
    emits("remove-item", item);
};

const clear = () => {
    emits("clear");
};
</script>
