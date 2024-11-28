<template>
    <q-card>
        <q-card-section class="q-pa-sm">
            <q-list dense>
                <q-item style="padding: 2px 8px">
                    <q-item-section>
                        <q-item-label lines="1" class="text-bold">
                            {{ section.name }}
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar>
                        <btn-down-up-component
                            :up="expand"
                            @click="expand = !expand"
                        />
                    </q-item-section>
                </q-item>
                <q-item style="padding: 2px 8px">
                    <q-item-section avatar style="padding-right: 5px">
                        <q-icon
                            name="mdi-check"
                            v-if="section.topics.length === courses_completed"
                        ></q-icon>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label>
                            {{ courses_completed }}/{{ section.topics.length }}
                            <span
                                v-if="
                                    courses_completed == section.topics.length
                                "
                                >completo</span
                            >
                        </q-item-label>
                    </q-item-section>
                </q-item>
                <q-item v-if="expand">
                    <q-item-section>
                        <q-list dense>
                            <q-item
                                v-for="(topic, topicIndex) in section.topics"
                                :key="topicIndex"
                            >
                                <q-item-section
                                    avatar
                                    top
                                    style="padding-right: 5px"
                                >
                                    <q-icon
                                        name="mdi-checkbox-blank-circle-outline"
                                        v-if="topic.percent === 0"
                                    ></q-icon>
                                    <q-icon
                                        name="mdi-check-circle-outline"
                                        v-else-if="topic.percent === 100"
                                    ></q-icon>
                                    <q-icon v-else>
                                        <q-knob
                                            v-model="topic.percent"
                                            size="18px"
                                            :thickness="1"
                                            color="black"
                                            track-color="transparent"
                                        ></q-knob>
                                    </q-icon>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label
                                        style="cursor: pointer"
                                        @click="changeTopic(topic, section)"
                                        >{{ topic.name }}</q-item-label
                                    >
                                    <q-item-label
                                        v-if="topic.duration_string !== null"
                                    >
                                        <q-icon
                                            name="mdi-video"
                                            size="sm"
                                        ></q-icon>
                                        ({{ topic.duration_string }})
                                        <q-icon
                                            name="mdi-attachment fa-rotate-90"
                                            size="sm"
                                            v-if="topic.has_resources"
                                        ></q-icon>
                                    </q-item-label>
                                </q-item-section>
                                <q-item-section avatar top>
                                    <q-btn-component
                                        tooltips="pasar a pantalla principal"
                                        icon="mdi-play-circle-outline"
                                        @click="changeTopic(topic, section)"
                                    />
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card-section>
    </q-card>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnDownUpComponent from "../../btn/BtnDownUpComponent.vue";

defineOptions({
    name: "SectionItemComponent",
});

const props = defineProps({
    section: Object,
    sectionIndex: Number,
    expand: {
        type: Boolean,
        default: false,
    },
});

const emits = defineEmits(["change-topic"]);

const expand = ref(props.expand);
const courses_completed = ref(0);

onMounted(() => {
    updateViewSection();
});

watch(
    () => props.section,
    (n, o) => {
        updateViewSection();
    }
);

const updateViewSection = () => {
    const topics = props.section.topics;
    let ltopics = topics.length;
    let view = true;
    courses_completed.value = 0;
    for (let i = 0; i < ltopics; i++) {
        view = true;
        const resources = topics[i].resources;
        for (let j = 0; j < resources.length; j++) {
            if (resources[j].video && !resources[j].view) {
                view = false;
                break;
            }
        }
        if (view) {
            courses_completed.value++;
        }
    }
};

const changeTopic = (topic, section) => {
    emits("change-topic", {
        topic: topic,
        section: section,
        sectionIndex: props.sectionIndex,
    });
};
</script>
<style scope>
.q-knob--editable:before {
    border: 1px solid #000;
}
</style>
