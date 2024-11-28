<template>
    <btn-delete-component @click="handleDelete" />
</template>

<script setup>
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
defineOptions({
    name: "DeleteComponent",
});

const props = defineProps({
    module: Object,
    objects: {
        type: Array,
        required: true,
        default: () => [],
    },
    size: {
        type: String,
        default: "sm",
    },
});

const emit = defineEmits(["deleted"]);

const $q = useQuasar();

const handleDelete = async () => {
    $q.dialog({
        title: "confirmacion",
        message:
            props.objects.length === 1
                ? "seguro que desea eliminar este registro"
                : "seguro que desea eliminar los registros seleccionados",
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
    }).onOk(() => {
        const send = useForm({ ids: props.objects.map((o) => o.id) });
        send.delete(
            `${props.module.base_url}/${props.objects
                .map((o) => o.id)
                .toString()}`,
            {
                onSuccess: () => {
                    emit("deleted");
                },
            }
        );
    });
};
</script>
