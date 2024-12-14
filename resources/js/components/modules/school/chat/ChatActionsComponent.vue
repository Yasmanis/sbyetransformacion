<template>
    <q-menu touch-position context-menu ref="menu">
        <q-list bordered dense>
            <form-chat-component :message="message" @hide-menu="menu.hide()" />
            <q-item
                clickable
                v-close-popup
                @click="reactHighligthDelete('react')"
            >
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon
                        name="mdi-emoticon-happy-outline"
                        size="22px"
                    ></q-icon>
                </q-item-section>

                <q-item-section>reaccionar</q-item-section>
            </q-item>

            <q-item
                clickable
                v-close-popup
                @click="reactHighligthDelete('highligth')"
            >
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon name="mdi-star-outline" size="22px"></q-icon>
                </q-item-section>

                <q-item-section>destacar</q-item-section>
            </q-item>

            <q-item clickable v-close-popup @click="confirm = true">
                <q-item-section
                    avatar
                    style="
                        padding-right: 5px !important;
                        min-width: 0px !important;
                    "
                >
                    <q-icon name="mdi-trash-can-outline" size="22px"></q-icon>
                </q-item-section>

                <q-item-section>eliminar</q-item-section>
            </q-item>
        </q-list>
    </q-menu>

    <confirm-component
        :show="confirm"
        @ok="
            router.delete(`/admin/schooltopics/delete-message/${message?.id}`, {
                onSuccess: () => {
                    confirm = false;
                },
            })
        "
        @hide="confirm = false"
        title="confirmar eliminacion"
        message="seguro que deseas eliminar este mensaje"
    />
</template>

<script setup>
import { ref } from "vue";
import FormChatComponent from "./FormChatComponent.vue";
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import { useForm, router } from "@inertiajs/vue3";

defineOptions({
    name: "ChatActionsComponent",
});

const props = defineProps({
    message: Object,
    topic: Object,
});

const menu = ref(null);

const confirm = ref(false);

const reactHighligthDelete = async (action) => {
    const send = useForm({});
    const url = `/admin/schooltopics/${action}-message/${props.message.id}`;
    if (action === "delete") send.delete(url);
    else send.post(url);
};
</script>
