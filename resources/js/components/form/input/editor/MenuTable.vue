<template>
    <q-menu
        v-model="model"
        :target="target"
        transition-show="scale"
        transition-hide="scale"
        @show="emits('show')"
        @hide="emits('hide')"
    >
        <q-btn
            label="en linea"
            @click="emits('change-position', 'text-left')"
        />
        <q-btn
            label="izquierda"
            @click="emits('change-position', 'float-left')"
        />
        <q-btn
            label="centro"
            @click="emits('change-position', 'text-center')"
        />
        <q-btn
            label="derecha"
            @click="emits('change-position', 'float-right')"
        />
    </q-menu>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";

defineOptions({
    name: "EditorField",
});

const props = defineProps({
    target: String,
});

const model = ref(null);

const emits = defineEmits(["show", "hide", "change-position"]);

onMounted(() => {
    model.value = props.target !== null;
});

watch(
    () => props.target,
    (n, o) => {
        model.value = n !== null;
    }
);
</script>
