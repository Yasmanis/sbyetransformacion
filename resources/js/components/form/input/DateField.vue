<template>
    <q-input
        v-model="model"
        :name="props.name"
        :label="props.label"
        :rules="fieldRules"
        :error="errorMsg !== null"
        :error-message="errorMsg"
        dense
        class="full-width"
        cleareable
        lazy-rules
        reactive-rules
        hide-bottom-space
        bottom-slots
        @update:model-value="onUpdate"
    >
        <template #hint v-if="fieldHelp?.length > 0">
            <ul style="padding: 0; margin-top: 0px; margin-bottom: 0px">
                <li
                    v-for="(h, index) in fieldHelp"
                    :key="`help-${index}`"
                    style="list-style: none"
                >
                    {{ h }}
                </li>
            </ul>
        </template>
        <template v-slot:prepend v-if="time && model">
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                    @before-show="onBeforeShowProxy"
                >
                    <q-date
                        v-model="proxy"
                        :mask="time ? 'DD/MM/YYYY hh:mm a' : 'DD/MM/YYYY'"
                        :options="options"
                    >
                        <div class="row items-center justify-end q-gutter-sm">
                            <q-btn-component
                                icon="check"
                                v-close-popup
                                :tooltips="$q.lang.label.ok"
                                @click="ok(proxy)"
                                v-if="proxy"
                            />
                            <q-btn-component
                                icon="mdi-cancel"
                                color="brown-5"
                                :tooltips="$q.lang.label.cancel"
                                v-close-popup
                            />

                            <q-btn-component
                                icon="mdi-eraser"
                                color="red"
                                :tooltips="$q.lang.label.clear"
                                v-close-popup
                                @click="clear"
                                v-if="proxy"
                            />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-icon>
        </template>
        <template v-slot:append v-else>
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                    @before-show="onBeforeShowProxy"
                >
                    <q-date
                        v-model="proxy"
                        mask="DD/MM/YYYY"
                        :options="options"
                    >
                        <div class="row items-center justify-end q-gutter-sm">
                            <q-btn-component
                                icon="check"
                                v-close-popup
                                :tooltips="$q.lang.label.ok"
                                @click="ok(proxy)"
                                v-if="proxy"
                            />
                            <q-btn-component
                                icon="mdi-cancel"
                                color="brown-5"
                                :tooltips="$q.lang.label.cancel"
                                v-close-popup
                            />

                            <q-btn-component
                                icon="mdi-eraser"
                                color="red"
                                :tooltips="$q.lang.label.clear"
                                v-close-popup
                                @click="clear"
                                v-if="proxy"
                            />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-icon>
        </template>
        <template v-slot:append v-if="time && model">
            <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                >
                    <q-time
                        v-model="model"
                        mask="DD/MM/YYYY hh:mm a"
                        :format24h="false"
                    >
                        <div class="row items-center justify-end">
                            <q-btn v-close-popup icon="check" flat />
                        </div>
                    </q-time>
                </q-popup-proxy>
            </q-icon>
        </template>
    </q-input>
</template>

<script setup>
import { onBeforeMount, onMounted, computed, watch, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { validations } from "../../../helpers/validations";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "DateField",
});

const props = defineProps({
    modelValue: String,
    startDate: String,
    endDate: String,
    time: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    othersProps: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update"]);
const page = usePage();
const model = ref(null);
const proxy = ref(null);
const fieldRules = ref([]);
const fieldHelp = ref([]);

onBeforeMount(() => {
    const { rules, help } = validations.getRules(props.othersProps);
    fieldRules.value = rules;
    fieldHelp.value = help;
});

onMounted(() => {
    model.value = props.modelValue;
});

watch(
    () => props.modelValue,
    (n, o) => {
        model.value = n;
    }
);

const options = (date) => {
    if (props.startDate && props.endDate)
        return date >= props.startDate && date <= props.endDate;
    if (props.startDate) return date >= props.startDate;
    if (props.endDate) return date <= props.endDate;
    return true;
};

const onUpdate = (val) => {
    emits("update", props.name, val);
};

const onBeforeShowProxy = () => {
    proxy.value = model.value;
};

const ok = (val) => {
    model.value = val;
    emits("update", props.name, val);
};

const clear = () => {
    proxy.value = null;
    model.value = null;
    emits("update", props.name, null);
};

const errorMsg = computed(() => {
    return page.props.errors
        ? page.props.errors[props.name]
            ? page.props.errors[props.name]
            : null
        : null;
});
</script>
