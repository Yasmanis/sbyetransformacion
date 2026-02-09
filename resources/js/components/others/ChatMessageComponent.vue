<template>
    <q-chat-message
        v-for="t in messages"
        :key="`reply-${t.id}`"
        :name="t.send ? 'tu' : t.user_str"
        :sent="t.send"
        :bg-color="t.send ? 'grey-3' : 'teal-1'"
        :stamp="t.date_humans"
    >
        <template #default>
            <q-item dense style="padding: 0">
                <q-item-section>
                    <q-item-label>
                        <span v-html="t.description" class="no-padding"></span>
                    </q-item-label>
                </q-item-section>
                <q-item-section avatar v-if="hasReply && !t.send">
                    <form-reply-component :tiket-id="t.id" :target="target" />
                </q-item-section>
            </q-item>
        </template>
        <template #avatar>
            <q-icon name="mdi-account-circle" size="50px" />
        </template>
    </q-chat-message>
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
</script>
