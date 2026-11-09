<template>
    <q-btn-component
        icon="grid_view"
        tooltips="familias"
        :disable="!hasFamilies"
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
                icon="grid_view"
                title="familias"
                closable
                @close="showDialog = false"
            />
            <q-card-section class="col q-pt-none">
                <q-form ref="formRef" greedy class="q-gutter-y-md">
                    <select-field
                        name="family_id"
                        label="familia"
                        option-label="name"
                        option-value="id"
                        :model-value="formData.family_id"
                        :options="families"
                        :othersProps="{
                            required: true,
                        }"
                        @update="onChangeFamily"
                        v-if="hasFamilies && !newFam"
                    >
                        <template #after>
                            <btn-edit-component
                                @click="onAlternateFam"
                                v-if="formData.family_id"
                            />
                        </template>
                    </select-field>

                    <text-field
                        name="name"
                        label="familia"
                        :model-value="formData.name"
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
                        @update="(name, val) => (formData[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <q-btn-component
                    tooltips="guardar"
                    icon="mdi-content-save-outline"
                    class="r-position"
                    @click="save"
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
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
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
    name: null,
    subcategories: [],
});

const selectedFam = computed(() =>
    formData.value.family_id
        ? (families.value.find((f) => f.id === formData.value.family_id) ??
          null)
        : null,
);

const families = computed(() => page.props.othersProps.families ?? []);

const hasFamilies = computed(() => families.value.length > 0);

const onBeforeShowDialog = () => {
    newFam.value = false;
    if (families.value.length > 0) {
        onChangeFamily("family_id", families.value[0].id, families.value[0]);
    } else {
        onChangeFamily("family_id", null, null);
    }
};

const onChangeFamily = (name, val, full) => {
    formData.value[name] = val;
    allSubcategories.value = [];
    if (val) {
        full?.subcategories.forEach((s) => {
            const found = allSubcategories.value.find((a) => a.id === s.id);
            if (!found) {
                allSubcategories.value.push(s);
            }
        });
        const { id, name, category_id } = selectedFam.value;
        formData.value.category_id = category_id;
        formData.value.family_id = id;
        formData.value.name = name;
    }
    formData.value.subcategories = allSubcategories.value.map((s) => s.id);
};

const onAlternateFam = () => {
    newFam.value = !newFam.value;
    if (newFam.value) {
        selectedFam.value =
            families.value.find((f) => f.id === formData.value.family_id) ??
            null;
    } else {
        formData.value.name = selectedFam.value.name;
    }
};

const onHide = () => {
    formData.value = {
        family_id: null,
        name: null,
        subcategories: [],
    };
};

const save = async () => {
    const valid = await formRef.value.validate();
    if (!valid) {
        errorValidation();
        return;
    }
    const send = useForm(formData.value);
    send.put(`/admin/families/${formData.value.family_id}`, {
        onSuccess: (data) => {
            emits("updated", data.props.object);
            showDialog.value = false;
        },
    });
};
</script>
