<template>
    <q-toolbar class="bg-indigo-5 text-white shadow-2">
        <q-toolbar-title
            >usted tiene
            {{
                messages.length === 1
                    ? "una notificaion"
                    : `${messages.length} notificaciones`
            }}</q-toolbar-title
        >
    </q-toolbar>
    <q-list style="min-width: 100px">
        <q-item
            style="max-width: 460px"
            v-for="msg in messages"
            :key="msg.id"
            clickable
            v-ripple
            @click="onItemClick(msg.data[0])"
        >
            <q-item-section avatar>
                <q-avatar>
                    <q-icon name="mdi-account-circle" size="lg"></q-icon>
                </q-avatar>
            </q-item-section>

            <q-item-section>
                <q-item-label>{{ msg.data[0].title }}</q-item-label>
                <q-item-label caption v-if="msg.data[0].description">
                    <small v-html="msg.data[0].description"></small>
                </q-item-label>
            </q-item-section>

            <q-item-section side>
                <small>{{ msg.time }}</small>
            </q-item-section>
        </q-item>
    </q-list>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
defineOptions({
    name: "NotificationsComponent",
});

const props = defineProps({
    messages: {
        type: Array,
        default: [],
    },
});

const onItemClick = (d) => {
    // const filters = JSON.stringify({
    //     column: "id",
    //     condition: "=",
    //     query: d.user_id,
    // });
    // router.get("/admin/users", { filters });
};
</script>
