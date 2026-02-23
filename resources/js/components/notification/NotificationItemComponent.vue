<template>
    <q-item style="max-width: 460px" clickable v-ripple>
        <q-item-section avatar>
            <q-avatar>
                <q-icon
                    name="mdi-help"
                    size="lg"
                    v-if="notification.data[0].code === 'help_from_contact'"
                ></q-icon>
                <q-icon
                    name="mdi-key"
                    size="lg"
                    v-else-if="notification.data[0].code === 'password_change'"
                ></q-icon>
                <q-icon name="mdi-account-circle" size="lg" v-else></q-icon>
            </q-avatar>
        </q-item-section>

        <q-item-section>
            <q-item-label>{{ notification.data[0].title }}</q-item-label>
            <q-item-label
                lines="3"
                caption
                v-if="notification.data[0].description"
            >
                <small v-html="notification.data[0].description"></small>
            </q-item-label>
        </q-item-section>

        <q-item-section side>
            <small>{{ notification.time }}</small>
        </q-item-section>

        <q-item-section avatar>
            <form-reply-component
                :tiket-id="
                    notification.data[0].code === 'help_from_contact'
                        ? parseInt(notification.data[0].model_id)
                        : null
                "
                target="notifications"
            />
        </q-item-section>

        <q-item-section avatar>
            <btn-show-hide-component
                :public="false"
                titlePublic="ver"
                @click="showNotification(notification)"
            />
        </q-item-section>
    </q-item>
</template>

<script setup>
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import FormReplyComponent from "../auth/FormReplyComponent.vue";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "NotificationItemComponent",
});

defineProps({
    notification: {
        type: Object,
        required: true,
    },
});

const showNotification = (n) => {
    let code = n.data[0].code,
        attributes = getAttributes(n);
    if (code === "chat_writter") {
        location.href = `/admin/${n.chat}`;
    } else {
        router.visit(`/auth/profile#${attributes}`);
    }
};

const getAttributes = (n) => {
    let data = n.data[0],
        tab = "notifications";
    let { id, target, code, row_id } = data;
    if (code === "help_from_contact" || code === "chat_writter") {
        id = n.id;
    } else if (code === "reply_contact") {
        if (row_id) {
            id = row_id;
            tab = target;
        }
    }
    return btoa(
        JSON.stringify({
            tab: tab,
            filters: {
                uniqueId: id,
            },
        }),
    );
};
</script>
