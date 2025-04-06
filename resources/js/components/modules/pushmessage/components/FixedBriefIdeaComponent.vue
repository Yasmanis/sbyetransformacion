<template>
    <btn-pin-component :pin="data.is_fixed" @click="show = true" />

    <confirm-component
        :iconHeader="data.is_fixed ? 'mdi-pin-off-outline' : 'mdi-pin-outline'"
        :message="
            data.is_fixed
                ? 'desea dejar de fijar esta idea breve?'
                : 'desea fijar esta idea breve?'
        "
        :show="show"
        @ok="fixed"
        @hide="show = false"
    />
</template>

<script setup>
import BtnPinComponent from "../../../btn/BtnPinComponent.vue";
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
defineOptions({
    name: "FixedBriefIdeaComponent",
});

const props = defineProps({
    data: Object,
});

const show = ref(false);

const fixed = () => {
    router.post(
        `/admin/briefideas/fixed/${props.data.id}`,
        {},
        {
            onSuccess: () => {
                show.value = false;
            },
        }
    );
};
</script>
