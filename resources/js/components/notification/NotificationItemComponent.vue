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
                :object="
                    notification.data[0].code === 'help_from_contact'
                        ? {
                              id: notification.id,
                              model_id: notification.data[0].model_id,
                          }
                        : null
                "
            />
        </q-item-section>

        <q-item-section avatar>
            <btn-show-hide-component
                :public="false"
                titlePublic="ver"
                @click="router.visit(`/auth/profile#${getStr(notification)}`)"
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

const getStr = (n) => {
    return btoa(
        JSON.stringify({
            tab: "notifications",
            filters: {
                uniqueId: n.id,
            },
        }),
    );
};
</script>
