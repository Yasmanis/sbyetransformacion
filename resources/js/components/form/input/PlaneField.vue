<template>
    <checkbox-field
        v-model="showInFormPlanes"
        v-if="inForm"
        :name="name"
        :label="label"
        @update="(name, val) => (showInFormPlanes = val)"
    />
    <q-btn-component
        icon="attach_money"
        tooltips="planes"
        @click="showDialog = true"
        v-else
    />

    <div class="row q-col-gutter-md q-mt-xs" v-if="inForm && showInFormPlanes">
        <div
            class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4"
            v-for="plan in planes"
            :key="plan.type"
        >
            <q-item dense class="shadow-3 q-pa-xs" style="min-height: 275px">
                <q-item-section avatar top style="width: 10px; max-width: 10px">
                    <checkbox-field
                        :model-value="plan.active"
                        name="active"
                        style="background: transparent; padding: 0px !important"
                        @update="(name, val) => onActivePlan(plan, val)"
                /></q-item-section>
                <q-item-section
                    top
                    class="cursor-pointer"
                    @click="onActivePlan(plan, !plan.active)"
                >
                    <div v-html="plan.content"></div> </q-item-section
                ><q-item-section avatar top style="min-width: 30px">
                    <btn-edit-component
                        @click="onShowForm(plan)"
                        v-if="plan.active"
                /></q-item-section>
            </q-item>
            <q-item dense class="bg-black text-white">
                <q-item-section>
                    <q-item-label class="text-center">
                        {{ plan.price }} €
                    </q-item-label>
                </q-item-section>
            </q-item>
        </div>
    </div>

    <q-dialog
        v-model="showDialog"
        persistent
        allow-focus-outside
        @before-show="onShow"
    >
        <q-card style="width: 1200px; max-width: 1200vw">
            <dialog-header-component
                icon="attach_money"
                title="planes"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 70vh" class="scroll">
                <div class="row q-col-gutter-md">
                    <div
                        class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4"
                        v-for="plan in planes"
                        :key="plan.type"
                    >
                        <q-item
                            dense
                            class="shadow-3 q-pa-xs"
                            style="min-height: 275px"
                        >
                            <q-item-section
                                avatar
                                top
                                style="width: 10px; max-width: 10px"
                            >
                                <checkbox-field
                                    :model-value="plan.active"
                                    name="active"
                                    style="
                                        background: transparent;
                                        padding: 0px !important;
                                    "
                                    @update="(name, val) => (plan[name] = val)"
                            /></q-item-section>
                            <q-item-section
                                top
                                class="cursor-pointer"
                                @click="plan.active = !plan.active"
                            >
                                <div
                                    v-html="plan.content"
                                ></div> </q-item-section
                            ><q-item-section avatar top style="min-width: 30px">
                                <btn-edit-component
                                    @click="onShowForm(plan)"
                                    v-if="plan.active"
                            /></q-item-section>
                        </q-item>
                        <q-item dense class="bg-black text-white">
                            <q-item-section>
                                <q-item-label class="text-center">
                                    {{ plan.price }} €
                                </q-item-label>
                            </q-item-section>
                        </q-item>
                    </div>
                </div>
            </q-card-section>
            <q-separator />

            <q-card-actions align="right">
                <btn-save-component @click="saveProductPlan" />
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="formDialog" persistent allow-focus-outside>
        <q-card>
            <dialog-header-component
                icon="attach_money"
                title="modificar plan"
                closable
                @close="formDialog = false"
            />
            <q-card-section style="max-height: 70vh" class="scroll">
                <q-form greedy ref="form">
                    <editor-field
                        name="content"
                        :model-value="currentPlan.content"
                        :others-props="{
                            required: true,
                        }"
                        @update="(name, val) => (currentPlan[name] = val)"
                    />
                    <number-field
                        name="price"
                        label="precio"
                        :model-value="currentPlan.price"
                        :others-props="{
                            required: true,
                        }"
                        @update="(name, val) => (currentPlan[name] = val)"
                    />
                </q-form>
            </q-card-section>
            <q-separator />

            <q-card-actions align="right">
                <btn-save-component @click="updatePlan" />
                <btn-cancel-component @click="formDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnEditComponent from "../../btn/BtnEditComponent.vue";
import EditorField from "./EditorField.vue";
import NumberField from "./NumberField.vue";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "PlaneComponent",
});

const props = defineProps({
    parent: Object,
    hasEdit: Boolean,
    name: {
        type: String,
        default: "planes",
    },
    label: {
        type: String,
        default: "planes",
    },
    inForm: {
        type: Boolean,
        default: true,
    },
});

const emits = defineEmits(["update"]);

const showInFormPlanes = ref(false);
const showDialog = ref(false);
const formDialog = ref(false);
const currentPlan = ref(null);
const form = ref(null);

const planes = ref([]);

onMounted(() => {
    initDefault();
});

watch(showInFormPlanes, (n) => {
    if (!n) {
        emits("update", props.name, null);
    }
});

const initDefault = () => {
    planes.value = [
        {
            active: false,
            content: `<p style="text-align:center;">🌱</p><p style="text-align:center;">plan basico</p><p style="text-align:center;">🎓️ curso completo</p><p style="text-align:center;">💬 acompañamiento por chat</p>`,
            price: 45,
            type: "basic",
        },
        {
            active: false,
            content: `<p style="text-align:center;">🌿</p><p style="text-align:center;">plan esencial</p><p style="text-align:center;">🎓️ curso completo</p><p style="text-align:center;">💬 acompañamiento por chat</p><p style="text-align:center;">+ 3 respuestas personalizadas en video</p>`,
            price: 75,
            type: "esencial",
        },
        {
            active: false,
            content: `<p style="text-align:center;">🌺</p><p style="text-align:center;">plan premium</p><p style="text-align:center;">🎓️ curso completo</p><p style="text-align:center;">💬 acompañamiento por chat</p><p style="text-align:center;">+ 3 respuestas personalizadas en video</p><p style="text-align:center;">👥 1 sesion individual de 1h</p>`,
            price: 150,
            type: "premium",
        },
    ];
    const actives = props.parent?.planes ?? [];
    actives.forEach((p) => {
        const exists = planes.value.find((dp) => dp.type === p.type);
        if (exists) {
            Object.assign(exists, p);
        }
    });
    currentPlan.value = false;
    if (props.inForm && actives.length > 0) {
        showInFormPlanes.value = true;
    }
};

const onActivePlan = (plan, val) => {
    plan.active = val;
    const data = planes.value.filter((p) => p.active);
    emits("update", props.name, data.length > 0 ? data : null);
};

const onShow = () => {
    initDefault();
};

const onShowForm = (plan) => {
    currentPlan.value = { ...plan };
    formDialog.value = true;
};

const updatePlan = () => {
    const plan = planes.value.find((p) => p.type === currentPlan.value.type);
    const { content, price } = currentPlan.value;
    plan.content = content;
    plan.price = price;
    formDialog.value = false;
    if (props.inForm) {
        const data = planes.value.filter((p) => p.active);
        emits("update", props.name, data.length > 0 ? data : null);
    }
};

const saveProductPlan = () => {
    const data = planes.value.filter((p) => p.active);
    if (props.parent) {
        router.put(
            `/admin/products/${props.parent.id}`,
            {
                planes: data.length > 0 ? data : null,
                name: props.parent.name,
            },
            {
                onSuccess: () => {
                    showDialog.value = false;
                },
            }
        );
    } else {
        emits("update", props.name, data.length > 0 ? data : null);
    }
};
</script>
