<template>
    <q-intersection
        v-for="t in messages"
        :key="`reply-${t.id}`"
        @visibility="(entry) => handleVisibility(entry, t)"
    >
        <q-chat-message
            :name="t.send ? 'tu' : t.user_str"
            :sent="t.send"
            :bg-color="t.send ? 'grey-3' : 'teal-1'"
            :stamp="t.date_humans"
        >
            <template #default>
                <q-item dense style="padding: 0">
                    <q-item-section>
                        <q-item-label>
                            <span
                                v-html="t.description"
                                class="no-padding"
                            ></span>
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar v-if="hasReply && !t.send">
                        <form-reply-component
                            :tiket-id="parseInt(t.id)"
                            :target="target"
                        />
                    </q-item-section>
                    <q-item-section avatar v-if="t.send">
                        <form-reply-component
                            :tiket-id="parseInt(t.id)"
                            :target="target"
                            :object="t"
                        />
                    </q-item-section>
                </q-item>
            </template>
            <template #avatar>
                <q-icon name="mdi-account-circle" size="50px" />
            </template>
        </q-chat-message>
    </q-intersection>
</template>

<script setup>
import FormReplyComponent from "../auth/FormReplyComponent.vue";
const props = defineProps({
    messages: {
        type: Array,
        default: [],
    },
    target: String,
    hasReply: Boolean,
});

const handleVisibility = (entry, msg) => {
    console.log(entry);

    if (entry.isIntersecting && msg.send) {
        setTimeout(async () => {
            if (entry.isIntersecting) {
                console.log("leido");

                // Notificamos al servidor
                // try {
                //     await api.post(`/respuestas/${respuesta.id}/marcar-leida`);
                // } catch (e) {
                //     console.error("Error al marcar como leída", e);
                // }
            }
        }, 1500);
    }
};
</script>
