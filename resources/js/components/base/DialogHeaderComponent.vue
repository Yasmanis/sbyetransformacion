<template>
    <q-toolbar :class="cls" ref="draggableRef">
        <q-icon :name="icon" :size="iconSize"></q-icon>
        <q-toolbar-title style="padding-left: 5px" class="text-lowercase">{{
            title
        }}</q-toolbar-title>
        <q-btn
            dense
            flat
            :icon="maximized ? 'minimize' : 'crop_square'"
            @click="maximized = !maximized"
            v-if="maximizeable"
        />
        <q-btn flat round dense icon="close" v-close-popup v-if="closable" />
    </q-toolbar>
    <q-separator v-if="separator" />
</template>

<script setup>
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { dom } from "quasar";
defineOptions({
    name: "DialogHeaderComponent",
});

const props = defineProps({
    separator: {
        type: Boolean,
        default: true,
    },
    title: String,
    icon: {
        type: String,
    },
    iconSize: {
        type: String,
        default: "20px",
    },
    closable: {
        type: Boolean,
        defaul: true,
    },
    maximizeable: {
        type: Boolean,
        defaul: false,
    },
    draggable: {
        type: Boolean,
        defaul: false,
    },
    class: String,
});

const emits = defineEmits(["fullsize"]);
const draggableRef = ref(null);
const maximized = ref(false);
let pos = { top: 0, left: 0 };
let offset = { x: 0, y: 0 };
let dragging = false;
const { css } = dom;
const cls = ref(null);

watch(maximized, (n) => {
    emits("fullsize", n);
});

onBeforeMount(() => {
    cls.value = "";
    if (props.draggable) {
        cls.value += "move ";
    }
    if (props.class) {
        cls.value += props.class;
    }
});

onMounted(() => {
    if (props.draggable) {
        makeDraggable();
    }
});

const makeDraggable = () => {
    let header = draggableRef.value.$el;
    let dialog = header.closest(".q-card");

    dialog.addEventListener("mousedown", (e) => {
        dragging = true;
        offset.x = dialog.offsetLeft - e.clientX;
        offset.y = dialog.offsetTop - e.clientY;
    });

    document.addEventListener("mousemove", (e) => {
        if (dragging) {
            css(dialog, {
                left: `${e.clientX + offset.x - 380}px`,
                top: `${e.clientY + offset.y - 110}px`,
            });
        }
    });

    document.addEventListener("mouseup", () => {
        dragging = false;
    });
};
</script>
<style>
.move {
    cursor: move;
}
</style>
