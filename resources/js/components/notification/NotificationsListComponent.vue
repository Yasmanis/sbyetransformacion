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
            <q-card flat>
                <q-card-section>
                    <div class="text-h6">
                        usted tiene
                        {{
                            notifications.length === 1
                                ? "una notificaion"
                                : `${notifications.length} notificaciones`
                        }}
                    </div>
                </q-card-section>

                <q-separator />
                <q-card-section
                    style="max-height: 40vh"
                    class="scroll no-padding"
                >
                    <notification-item-component
                        v-for="n in notifications.splice(0, 5)"
                        :key="n.id"
                        :notification="n"
                    />
                </q-card-section>
                <q-card-actions v-if="notifications.length > 5">
                    <q-btn
                        color="black"
                        label="mostrar todas"
                        no-caps
                        class="full-width"
                        @click="router.visit(`/auth/profile#${getStr()}`)"
                    />
                </q-card-actions>
            </q-card>

            <q-list style="min-width: 100px"> </q-list>
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
        (n) => n.read_at === null,
    );
});

const getStr = () => {
    return btoa(
        JSON.stringify({
            tab: "notifications",
            filters: {
                reads: [false],
            },
        }),
    );
};
</script>
