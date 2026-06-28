<template>
    <btn-pin-component :pin="data[column]" @click="onHandleClick" />
    <confirm-component
        :iconHeader="data[column] ? 'mdi-pin-off-outline' : 'mdi-pin-outline'"
        :message="
            data[column]
                ? 'desea dejar de fijar este elemento?'
                : 'desea fijar este elemento?'
        "
        :show="show"
        @ok="fixed"
        @hide="show = false"
    />
</template>

<script setup>
import BtnPinComponent from "../btn/BtnPinComponent.vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { error } from "../../helpers/notifications.js";
defineOptions({
    name: "FixedComponent",
});

const props = defineProps({
    data: Object,
    model: {
        type: String,
        required: true,
    },
    column: {
        type: String,
        default: "fixed",
    },
});

const emits = defineEmits(["reload"]);

const show = ref(false);

const onHandleClick = () => {
    if (props.model) {
        show.value = true;
    } else {
        error("modelo no configurado en las props");
    }
};

const fixed = () => {
    router.post(
        `/utils/fixed`,
        {
            modelName: props.model,
            columnName: props.column,
            modelId: props.data.id,
            fixed: !props.data[props.column],
        },
        {
            onSuccess: () => {
                show.value = false;
                emits("reload");
            },
        },
    );
};
</script>
