<template></template>

<script setup>
import { useQuasar } from "quasar";
import { watch } from "vue";

defineOptions({
    name: "ConfirmComponent",
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    message: {
        type: String,
        default: "seguro que desea eliminar este objeto",
    },
});

const emits = defineEmits(["ok", "cancel"]);

const $q = useQuasar();

watch(
    () => props.show,
    (n, o) => {
        if (n) {
            $q.dialog({
                title: "confirmacion",
                message: props.message,
                cancel: {
                    label: "cancelar",
                    icon: "mdi-cancel",
                },
                ok: {
                    label: "si",
                    icon: "mdi-check",
                    color: "red",
                },
                persistent: true,
            })
                .onOk(() => {
                    emits("ok");
                })
                .onCancel(() => {
                    emits("cancel");
                });
        }
    }
);
</script>
