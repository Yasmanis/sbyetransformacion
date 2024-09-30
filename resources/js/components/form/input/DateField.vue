<template>
    <q-input
        filled
        v-model="model"
        :name="props.name"
        :label="props.label"
        class="full-width"
        cleareable
        @update:model-value="onUpdate"
    >
        <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                    @before-show="onBeforeShowProxy"
                >
                    <q-date v-model="proxy" mask="DD/MM/YYYY">
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
    </q-input>
</template>

<script setup>
import { onMounted, ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";

defineOptions({
    name: "DateField",
});

const props = defineProps({
    modelValue: String,
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    options: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update"]);

const model = ref(null);
const proxy = ref(null);

onMounted(() => {
    model.value = props.modelValue;
});

function onUpdate(val) {
    emits("update", props.name, val);
}

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
</script>
