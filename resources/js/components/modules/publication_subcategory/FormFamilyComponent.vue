<template>
    <q-btn-component
        icon="mdi-format-list-checks"
        tooltips="agrupar en familias"
        :disable="!allSameCategory"
        @click="showDialog = true"
    />

    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        @before-show="onBeforeShowDialog"
        @hide="onHide"
    >
        <q-card style="width: 800px">
            <dialog-header-component
                icon="mdi-format-list-checks"
                title="agrupar en familias"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form ref="formRef" greedy>
                    <checkbox-group-field
                        name="subcategories"
                        :model-value="formData.subcategories"
                        :options="
                            allSubcategories.map((c) => {
                                return {
                                    label: c.name,
                                    value: c.id,
                                };
                            })
                        "
                        dense
                        @update="(name, val) => (formData[name] = val)"
                    />

                    <select-field
                        name="family_id"
                        label="familia"
                        option-label="name"
                        option-value="id"
                        :model-value="formData.family_id"
                        :othersProps="{
                            required: true,
                            url_to_options: `/selects/families/${props.subcategories[0].category_id}`,
                        }"
                        @update="onChangeFamily"
                        v-if="hasFamilies && !newFam"
                    >
                        <template #after>
                            <btn-add-component @click="onAlternateFam" />
                        </template>
                    </select-field>

                    <text-field
                        name="family_name"
                        label="familia"
                        :model-value="formData.family_name"
                        :othersProps="{
                            required: true,
                        }"
                        @update="(name, val) => (formData[name] = val)"
                        v-else
                    >
                        <template #after>
                            <q-btn-component
                                tooltips="volver"
                                icon="mdi-keyboard-backspace"
                                @click="onAlternateFam"
                            />
                        </template>
                    </text-field>
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    tooltips="guardar"
                    icon="mdi-content-save-outline"
                    class="r-position"
                    @click="store"
                />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { computed, ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import CheckboxGroupField from "../../form/input/CheckboxGroupField.vue";
import TextField from "../../form/input/TextField.vue";
import SelectField from "../../form/input/SelectField.vue";
import DynamicCascadingSelects from "../../form/input/DynamicCascadingSelects.vue";
import BtnAddComponent from "../../btn/BtnAddComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../../helpers/notifications.js";

defineOptions({
    name: "SectionAddComponent",
});

const props = defineProps({
    subcategories: {
        type: Array,
        default: [],
    },
});

const formRef = ref(null);
const page = usePage();

const emits = defineEmits(["reload-sections"]);
const showDialog = ref(false);
const newFam = ref(false);

const allSubcategories = ref([]);

const formData = ref({
    category_id: null,
    family_id: null,
    family_name: null,
    subcategories: [],
});

const families = computed(() => page.props.othersProps.families ?? []);

const hasFamilies = computed(() => families.value.length > 0);

const allSameCategory = computed(() => {
    const list = props.subcategories;
    if (!list.length) return false;
    const firstId = list[0].category_id;
    return list.every((item) => item.category_id === firstId);
});

const onBeforeShowDialog = () => {
    allSubcategories.value = [...props.subcategories];
    formData.value.subcategories = props.subcategories.map((s) => s.id);
    formData.value.category_id = props.subcategories[0].category_id;
};

const onChangeFamily = (name, val, full) => {
    formData.value[name] = val;
    full.subcategories.forEach((s) => {
        const found = allSubcategories.value.find((a) => a.id === s.id);
        if (!found) {
            allSubcategories.value.push(s);
            formData.value.subcategories.push(s.id);
        }
    });
};

const onAlternateFam = () => {
    newFam.value = !newFam.value;
    formData.value.family_id = null;
    formData.value.family_name = null;
};

const onHide = () => {
    formData.value = {
        family_id: null,
        family_name: null,
        subcategories: [],
    };
};

const store = async () => {
    const valid = await formRef.value.validate();
    if (!valid) {
        errorValidation();
        return;
    }
    const send = useForm(formData.value);
    send.post("/admin/families", {
        onSuccess: (data) => {
            emits("created", data.props.object);
            showDialog.value = false;
        },
    });
};
</script>
