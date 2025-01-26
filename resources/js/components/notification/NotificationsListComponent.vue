<template>
    <q-btn-component
        icon="mdi-bell-outline"
        color="white"
        class="q-mr-sm"
        v-if="notifications.length > 0"
    >
        <q-badge
            :color="Dark.isActive ? 'primary' : 'black'"
            floating
            class="fa-beat"
            >{{ notifications.length }}</q-badge
        >
        <q-menu
            style="min-width: 300px"
            transition-show="scale"
            transition-hide="scale"
        >
            <q-toolbar class="bg-indigo-5 text-white shadow-2">
                <q-toolbar-title
                    >usted tiene
                    {{
                        notifications.length === 1
                            ? "una notificaion"
                            : `${notifications.length} notificaciones`
                    }}</q-toolbar-title
                >
            </q-toolbar>
            <q-list style="min-width: 100px">
                <notification-item-component
                    v-for="n in notifications"
                    :key="n.id"
                    :notification="n"
                />
            </q-list>
        </q-menu>
    </q-btn-component>
</template>

<script setup>
import { computed } from "vue";
import NotificationItemComponent from "./NotificationItemComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import { usePage, router } from "@inertiajs/vue3";
import { Dark } from "quasar";

defineOptions({
    name: "NotificationsListComponent",
});

const notifications = computed(() => {
    return usePage().props.auth.user.notifications.filter(
        (n) => n.read_at === null
    );
});
</script>
