<template>
    <q-card flat>
        <q-card-section style="padding: 0">
            <q-list dense>
                <q-item
                    style="padding-right: 0px; padding-left: 0px"
                    v-if="selected.length > 0"
                >
                    <users-selected-component
                        :list="selected"
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
                            :model-value="role"
                            :disable="
                                selectedRole !== null &&
                                selectedRole !== undefined
                            "
                            :othersProps="{
                                url_to_options: '/roles',
                            }"
                            @update="onUpdateRole"
                        />
                    </q-item-section>
                </q-item>
                <q-item
                    style="padding-right: 0px; padding-left: 0px"
                    v-if="lists?.length > 0 && multiple"
                >
                    <q-item-section
                        avatar
                        style="min-width: 20px !important; padding-right: 5px"
                    >
                        <q-checkbox
                            dense
                            v-model="selectAllRole"
                            label="todos los usuarios"
                            @update:model-value="onSelectAllRole"
                        ></q-checkbox>
                    </q-item-section>
                </q-item>
                <q-option-group
                    v-model="model"
                    :options="paginatedLists"
                    :type="multiple ? 'checkbox' : 'radio'"
                    left-label
                    class="custom-option-group"
                    @update:model-value="onChangeSelected"
                    v-if="lists?.length > 0"
                >
                    <template v-slot:label="opt">
                        <div
                            class="row items-center justify-between full-width"
                        >
                            <span class="q-mr-sm"
                                ><q-icon
                                    name="mdi-account-circle"
                                    size="22px"
                                />
                                {{ opt.label }}</span
                            >

                            <q-icon
                                :name="
                                    model?.includes(opt.value)
                                        ? 'mdi-checkbox-marked'
                                        : 'mdi-square-outline'
                                "
                                :color="
                                    model?.includes(opt.value)
                                        ? 'primary'
                                        : 'grey'
                                "
                                size="24px"
                                v-if="multiple"
                            />
                            <q-icon
                                :name="
                                    model === opt.value
                                        ? 'check_circle'
                                        : 'radio_button_unchecked'
                                "
                                :color="
                                    model === opt.value ? 'primary' : 'grey'
                                "
                                size="24px"
                                v-else
                            />
                        </div> </template
                ></q-option-group>
                <p v-else>no existen usuarios</p>
            </q-list>
        </q-card-section>
        <q-card-section style="padding: 0" v-if="lists?.length > 0">
            <pagination-component
                :current_list="lists"
                @change-paginate="onChangePaginate"
            />
        </q-card-section>
        <q-inner-loading
            :showing="loading"
            color="primary"
            size="30px"
        ></q-inner-loading>
    </q-card>
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import PaginationComponent from "../../others/PaginationComponent.vue";
import SelectField from "../../form/input/SelectField.vue";
import UsersSelectedComponent from "./UsersSelectedComponent.vue";
import axios from "axios";
import { error500 } from "../../../helpers/notifications";

defineOptions({
    name: "UsersSelectComponent",
});

const props = defineProps({
    modelValue: Array | Number,
    multiple: {
        type: Boolean,
        default: true,
    },
    selectedRole: String | Number,
});

const model = ref(null);

const emits = defineEmits(["change"]);
const loading = ref(false);
const search = ref(null);
const role = ref(null);
const selectAllRole = ref(false);
const lists = ref([]);
const paginatedLists = ref([]);

onMounted(() => {
    if (props.modelValue) {
        model.value = props.modelValue;
    } else {
        model.value = props.multiple ? [] : null;
    }
    getList();
});

watch(search, () => {
    getList();
});

const selected = computed(() => {
    if (props.multiple) {
        return model.value?.length > 0
            ? lists.value.filter((u) => model.value.includes(u.value))
            : [];
    } else {
        return model.value
            ? lists.value.filter((u) => u.value === model.value)
            : [];
    }
});

const onSelectAllRole = (val) => {
    model.value = val ? lists.value.map((u) => u.value) : [];
    onChangeSelected(model.value);
};

const onChangeSelected = (val) => {
    let opts = null;
    if (val) {
        if (!props.multiple) {
            opts = lists.value.find((u) => val === u.value) ?? null;
        } else {
            if (val.length > 0) {
                opts = lists.value.filter((u) => val.includes(u.value));
            }
        }
    }
    emits("change", opts);
};

const onUpdateRole = (f, val, opt) => {
    role.value = val;
    getList();
};

const getList = () => {
    let data = {
        regex: search.value,
        role: role.value,
        roleStr: props.selectedRole,
    };
    loading.value = true;
    axios
        .post("/users", data)
        .then((response) => {
            lists.value = response.data.options;
        })
        .catch((error) => {
            error500();
        })
        .finally(() => {
            loading.value = false;
        });
};

const onChangePaginate = (l) => {
    paginatedLists.value = l;
};

const onClearSelected = async () => {
    model.value = props.multiple ? [] : null;
    selectAllRole.value = false;
    onChangeSelected(model.value);
};

const onRemoveItemSelected = (usr) => {
    if (props.multiple) {
        model.value = model.value.filter((m) => m !== usr.value);
    } else {
        model.value = null;
    }
    onChangeSelected(model.value);
};
</script>
<style lang="scss">
.custom-option-group {
    .q-radio,
    .q-checkbox {
        width: 100%;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .q-radio__inner,
    .q-checkbox__inner {
        display: none;
    }

    .q-radio__label,
    .q-checkbox__label {
        width: 100%;
    }
}
</style>
