<template>
    <Layout>
        <q-page padding>
            <div class="row items-center q-mb-md">
                <div class="col">
                    <q-item class="no-padding">
                        <q-item-section avatar>
                            <btn-reply-component
                                color="white"
                                tooltips="volver a usuarios"
                                @click="back"
                            />
                        </q-item-section>
                    </q-item>
                </div>
            </div>
            <vue-cal
                v-bind="config"
                watch-real-time
                :events="events"
                events-on-month-view
                :views="{
                    day: {},
                    days: { cols: 5, rows: 1 },
                    week: {},
                    month: {},
                }"
                :disable-views="['years', 'year']"
                :min-event-width="0"
                all-day-events
                :time-from="7 * 60"
                :time-to="23 * 60"
                :week-numbers="true"
                @event-create="createEvent"
                @event-drop="onEventDrop"
                @event-resize="onEventResize"
                @event-resize-end="onEventResizeEnd"
                @ready="onReady"
                @view-change="onViewChange"
                @event-click="logEvents('event-click', $event)"
                @event-dblclick="logEvents('event-dblclick', $event)"
                @event-hold="logEvents('event-hold', $event)"
                @event-drag-start="logEvents('event-drag-start', $event)"
                @event-drag="logEvents('event-drag', $event)"
                @event-drag-end="logEvents('event-drag-end', $event)"
                @event-contextmenu="logEvents('event-contextmenu', $event)"
                @cell-click="logEvents('cell-click', $event)"
                @cell-dblclick="logEvents('cell-dblclick', $event)"
                @cell-drag-start="logEvents('cell-drag-start', $event)"
                @cell-drag="logEvents('cell-drag', $event)"
                @cell-drag-end="logEvents('cell-drag-end', $event)"
                @cell-hold="logEvents('cell-hold', $event)"
            >
                <!-- <template #event="{ event }">
                    <div class="custom-event">
                        <span>{{ event.title }}</span>
                    </div>
                </template> 
                :editable-events="{ resizeX: true }"
                view="month"
                style="height: 100%"
                -->
            </vue-cal>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import BtnReplyComponent from "../../components/btn/BtnReplyComponent.vue";

import { VueCal } from "vue-cal";
import "vue-cal/style";

import { router } from "@inertiajs/vue3";
import { computed, defineComponent, ref } from "vue";

defineOptions({
    name: "Calendar",
});

const config = {
    time: true,
    locale: "es",
};

const mode = ref("month");
const calendar = ref(null);

const createDate = (dateStr, timeStr = null) => {
    const date = new Date(dateStr);
    if (timeStr) {
        const [hours, minutes] = timeStr.split(":").map(Number);
        date.setHours(hours, minutes);
    } else {
        date.setHours(0, 0, 0);
    }
    return date;
};
const events = ref([
    {
        id: 1,
        title: "1st of the Month",
        details:
            "Everything is funny as long as it is happening to someone else",
        start: createDate("2026-06-01"),
        end: createDate("2026-06-01"),
        bgcolor: "orange",
        allDay: true,
    },
    {
        id: 2,
        title: "Sisters Birthday",
        details: "Buy a nice present",
        start: createDate("2026-06-04"),
        end: createDate("2026-06-04"),
        bgcolor: "green",
        icon: "fas fa-birthday-cake",
        allDay: true,
    },
    {
        id: 3,
        title: "Meeting",
        details: "Time to pitch my idea to the company",
        start: createDate("2026-06-10", "10:00"),
        end: createDate("2026-06-10", "12:00"), // 10:00 + 120 minutos
        bgcolor: "red",
        icon: "fas fa-handshake",
    },
    {
        id: 4,
        title: "Lunch",
        details: "Company is paying!",
        start: createDate("2026-06-10", "11:30"),
        end: createDate("2026-06-10", "13:00"), // 11:30 + 90 minutos
        bgcolor: "teal",
        icon: "fas fa-hamburger",
    },
    {
        id: 5,
        title: "Visit mom",
        details: "Always a nice chat with mom",
        start: createDate("2026-06-20", "17:00"),
        end: createDate("2026-06-20", "18:30"), // 17:00 + 90 minutos
        bgcolor: "grey",
        icon: "fas fa-car",
    },
    {
        id: 6,
        title: "Conference",
        details: "Teaching Javascript 101",
        start: createDate("2026-06-22", "08:00"),
        end: createDate("2026-06-22", "17:00"), // 8:00 + 9 horas (540 min)
        bgcolor: "blue",
        icon: "fas fa-chalkboard-teacher",
    },
    {
        id: 7,
        title: "Girlfriend",
        details: "Meet GF for dinner at Swanky Restaurant",
        start: createDate("2026-06-22", "19:00"),
        end: createDate("2026-06-22", "22:00"), // 19:00 + 3 horas (180 min)
        bgcolor: "teal",
        icon: "fas fa-utensils",
    },
    {
        id: 8,
        title: "Rowing",
        details: "Stay in shape!",
        start: createDate("2026-06-27"),
        end: createDate("2026-06-29"), // 2 días después
        bgcolor: "purple",
        icon: "rowing",
        allDay: true,
    },
    {
        id: 9,
        title: "Fishing",
        details: "Time for some weekend R&R",
        start: createDate("2026-06-27"),
        end: createDate("2026-06-29"),
        bgcolor: "purple",
        icon: "fas fa-fish",
        allDay: true,
    },
    {
        id: 10,
        title: "Vacation",
        details:
            "Trails and hikes, going camping! Don't forget to bring bear spray!",
        start: createDate("2026-06-29"),
        end: createDate("2026-07-04"), // 5 días después
        bgcolor: "purple",
        icon: "fas fa-plane",
        allDay: true,
    },
]);

const createEvent = ({ event, resolve }) => {
    createEventFn.value = resolve;
};

const createEventFn = ref(null);
const newEvent = ref({
    title: "",
    background: false,
    class: "",
});

const cancelCreation = () => {
    createEventFn.value(false);
};

const onEventDrop = ({ e, event, cell, overlaps }) => !overlaps.length;

const onEventResize = ({ e, event, overlaps }) => {
    return !overlaps.length;
};

const onEventResizeEnd = ({ e, event, overlaps }) => {
    return !overlaps.length;
};

const onReady = () => {};

const onViewChange = (view) => {
    console.log(view.start, view.end);
};

const logEvents = (name, evt) => {
    console.log(name, evt);
};

const back = () => {
    router.visit("/admin/users", {
        method: "get",
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
