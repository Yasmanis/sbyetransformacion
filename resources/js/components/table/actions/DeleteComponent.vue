<template>
    <btn-delete-component @click="confirm = true" :disable="disable" />
    <confirm-component
        :show="confirm"
        title="confirmar eliminacion"
        :message="
            objects.length > 1
                ? 'confirma que deseas eliminar los objetos seleccionados'
                : 'confirma que deseas eliminar este objeto'
        "
        @ok="handleDelete"
        @hide="confirm = false"
    />
</template>

<script setup>
import { ref } from "vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import ConfirmComponent from "../../base/ConfirmComponent.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { Loading } from "quasar";
import { success } from "../../../helpers/notifications";
defineOptions({
    name: "DeleteComponent",
});

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
    objects: {
        type: Array,
        required: true,
        default: () => [],
    },
    size: {
        type: String,
        default: "sm",
    },
    disable: {
        type: Boolean,
        defaul: false,
    },
    axios: Boolean,
});

const emit = defineEmits(["deleted"]);

const confirm = ref(false);

const handleDelete = async () => {
    if (props.axios) {
        Loading.show();
        axios
            .delete(`${props.url}/${props.objects.map((o) => o.id).toString()}`)
            .then((res) => {
                emit("deleted");
                confirm.value = false;
                if (res.success) {
                    success(res.message);
                }
            })
            .finally(() => {
                Loading.hide();
            });
    } else {
        const send = useForm({ ids: props.objects.map((o) => o.id) });
        send.delete(
            `${props.url}/${props.objects.map((o) => o.id).toString()}`,
            {
                onSuccess: () => {
                    emit("deleted");
                    confirm.value = false;
                },
            }
        );
    }
};
</script>
