<template>
    <q-card flat>
        <q-card-section style="padding: 0">
            <q-list dense>
                <q-item
                    style="padding-right: 0px; padding-left: 0px"
                    v-if="current_selected && current_selected.length > 0"
                >
                    <users-selected-component
                        :imgbase="imgbase"
                        :list="current_selected"
                        @clear="onClearSelected"
                        @remove-item="onRemoveItemSelected"
                    />
                </q-item>
                <q-item style="padding-right: 0px; padding-left: 0px">
                    <q-item-section>
                        <q-input
                            outlined
                            v-model="search"
                            placeholder="filtrar"
                            clearable
                            dense
                        >
                            <template v-slot:append>
                                <q-icon name="search"></q-icon> </template
                        ></q-input>
                    </q-item-section>
                </q-item>
                <q-item style="padding-right: 0px; padding-left: 0px">
                    <q-item-section>
                        <select-field
                            label="rol"
                            :othersProps="{
                                url_to_options: '/roles',
                            }"
                            @update="onUpdateRole"
                        />
                    </q-item-section>
                </q-item>
                <q-item
                    style="padding-right: 0px; padding-left: 0px"
                    v-if="lists && lists.length > 0 && multiple"
                >
                    <q-item-section
                        avatar
                        style="min-width: 20px !important; padding-right: 5px"
                    >
                        <q-checkbox
                            dense
                            v-model="selectAllRole"
                            @update:model-value="onUpdateSelectAllRole"
                            label="todos los usuarios"
                        ></q-checkbox>
                    </q-item-section>
                </q-item>
                <q-item
                    style="padding-right: 0px; padding-left: 0px"
                    v-for="(u, indexUser) in paginatedLists"
                    :key="`user_${indexUser}`"
                >
                    <q-item-section
                        avatar
                        style="min-width: 20px !important; padding-right: 5px"
                    >
                        <q-icon name="mdi-account-circle" size="22px"></q-icon>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>{{ u.label }}</q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <q-checkbox
                            dense
                            v-model="u.checked"
                            @update:model-value="onChangeUser(u)"
                            v-if="multiple"
                        ></q-checkbox>
                        <q-radio
                            v-model="u.checked"
                            checked-icon="task_alt"
                            unchecked-icon="panorama_fish_eye"
                            :val="u"
                            @update:model-value="onChangeUser(u)"
                            color="red"
                            v-else
                        ></q-radio>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
        <q-card-section style="padding: 0" v-if="lists && lists.length > 0">
            <pagination-component
                :current_list="lists"
                @change-paginate="onChangePaginate"
            />
        </q-card-section>
        <q-inner-loading
            :showing="loading"
            color="danger"
            size="30px"
        ></q-inner-loading>
    </q-card>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import PaginationComponent from "../../others/PaginationComponent.vue";
import SelectField from "../../form/input/SelectField.vue";
import UsersSelectedComponent from "./UsersSelectedComponent.vue";
import axios from "axios";
import { error, error500 } from "../../../helpers/notifications";

defineOptions({
    name: "UsersSelectComponent",
});

const props = defineProps({
    url: String,
    imgbase: String,
    default_users: {
        type: Array,
        default: [],
    },
    multiple: {
        type: Boolean,
        default: true,
    },
    remove_item: {
        type: Number,
        default: -1,
    },
});

const emits = defineEmits(["change"]);
const loading = ref(false);
const search = ref(null);
const role = ref(null);
const selectAllRole = ref(false);
const lists = ref([]);
const paginatedLists = ref([]);
const shared = ref(-1);
const current_selected = ref([]);

onMounted(() => {
    current_selected.value = props.default_users;
    getList();
});

watch(
    () => props.default_users,
    (n, o) => {
        current_selected.value = n;
    }
);

watch(search, () => {
    getList();
});

const onUpdateRole = (f, val, opt) => {
    role.value = val;
    selectAllRole.value = false;
    getList();
};

const getList = () => {
    let data = {
        regex: search.value,
        role: role.value,
    };
    loading.value = true;
    axios
        .post("/users", data)
        .then((response) => {
            let data = response.data.options;
            data.forEach((d) => {
                const checked = props.default_users.find((u) => u.id === d.id);
                d["checked"] = checked ? true : false;
            });
            lists.value = data;
        })
        .catch((error) => {
            error500();
        })
        .finally(() => {
            loading.value = false;
        });
};

const onUpdateSelectAllRole = () => {
    lists.value.forEach((e) => {
        e["checked"] = selectAllRole.value;
        onChangeUser(e);
    });
};

const onChangePaginate = (l) => {
    paginatedLists.value = l;
    refreshList();
};

const onChangeUser = async (u) => {
    if (props.multiple) {
        const index = current_selected.value.findIndex(
            (c) => c.value === u.value
        );
        if (index === -1 && u.checked) {
            current_selected.value.push(u);
        } else {
            if (!u.checked) {
                current_selected.value.splice(index, 1);
            }
        }
    } else {
        if (current_selected.value && current_selected.value.length > 0) {
            let user = lists.value.find(
                (e) => e.id === current_selected.value[0].id
            );
            if (user) {
                user.checked = false;
            }
        }
        current_selected.value = [u];
    }
    emits("change", current_selected.value);
};

const onClearSelected = async () => {
    selectAllRole.value = false;
    current_selected.value = [];
    emits("change", current_selected.value);
    refreshList();
};

const onRemoveItemSelected = (usr) => {
    current_selected.value = current_selected.value.filter(
        (u) => u.value !== usr.value
    );
    emits("change", current_selected.value);
    refreshList();
};

const refreshList = () => {
    paginatedLists.value.forEach((l) => {
        l.checked =
            current_selected.value.find((u) => u.value === l.value) !==
            undefined;
    });
};
</script>
