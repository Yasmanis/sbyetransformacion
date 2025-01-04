<template>
    <q-item-section>
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
                {{ list[2].label
                }}<q-tooltip
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
            <q-menu transition-show="jump-down" transition-hide="jump-up">
                <q-list dense padding style="width: 300px">
                    <q-item
                        v-for="(u, userIndex) in list"
                        :key="`user_list_${userIndex}`"
                    >
                        <q-item-section avatar>
                            <q-avatar
                                font-size="32px"
                                icon="mdi-account-circle"
                            ></q-avatar>
                        </q-item-section>
                        <q-item-section> {{ u.label }}</q-item-section>
                        <q-item-section side v-if="chip">
                            <btn-delete-component
                                tooltips="quitar de la lista"
                                @click="removeItem(list[userIndex])"
                            />
                        </q-item-section>
                    </q-item>
                </q-list> </q-menu
        ></q-btn-component>
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
import { ref, watch, onMounted } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";

defineOptions({
    name: "UsersSelectedComponent",
});

const props = defineProps({
    imgbase: String,
    chip: {
        type: Boolean,
        default: true,
    },
    list: {
        type: Array,
        default: [],
    },
});

const emits = defineEmits(["remove-item", "clear"]);
const users = ref([]);
const chip_0 = ref(null);
const chip_1 = ref(null);
const chip_2 = ref(null);
onMounted(() => {
    setDefault();
});
watch(
    () => props.list,
    (n, o) => {
        setDefault();
    }
);
const setDefault = () => {
    chip_0.value = null;
    chip_1.value = null;
    chip_2.value = null;
};
const removeItem = (item) => {
    emits("remove-item", item);
};

const clear = () => {
    emits("clear");
};
</script>
