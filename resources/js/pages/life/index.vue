<template>
    <Layout>
        <q-page padding>
            <div class="row">
                <div
                    class="col-md-4 col-lg-4 col-sm-4 col-xs-12 q-sm-pr-md"
                    :class="screen.xs ? 'q-mb-md' : 'q-pr-md'"
                >
                    <q-card class="q-mb-md">
                        <q-card-section class="text-center">
                            <mgr-private-msg-component />
                        </q-card-section>
                    </q-card>
                    <q-card class="q-mb-md">
                        <q-card-section class="text-center">
                            <p class="q-mb-none">
                                {{ Math.round(course_percentage * 100) / 100 }}%
                                COMPLETO
                            </p>
                            <q-linear-progress
                                :value="course_percentage / 100"
                                size="10px"
                            />
                        </q-card-section>
                    </q-card>

                    <q-card>
                        <q-card-section class="text-bold">
                            <p class="text-bold">avisos</p>
                        </q-card-section>
                    </q-card>
                </div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <q-card>
                        <q-card-section
                            class="q-pa-none"
                            v-if="has_add || (has_edit && sections.length > 0)"
                        >
                            <q-toolbar class="q-gutter-x-sm">
                                <section-add-component
                                    v-if="has_add"
                                    :segment="segment"
                                    :skip="modules_skip"
                                />
                                <section-edit-component
                                    :segment="segment"
                                    :skip="modules_skip"
                                    :has_add="has_add"
                                    :has_edit="has_edit"
                                    :has_delete="has_delete"
                                    v-if="has_edit && sections.length > 0"
                                />
                                <!-- <notification-component /> -->
                            </q-toolbar>
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <section-component
                                :section="currentSection"
                                :topic="currentTopic"
                                :index="sIndex"
                                :indexTopic="tIndex"
                                :totalSections="sections.length"
                                :has_edit="has_edit"
                                :show-chat="show_chat"
                                :segment="segment"
                                :skip="modules_skip"
                                @change-section="onChangeSection"
                                @change-topic="
                                    (i) => {
                                        resetHash();
                                        currentTopic =
                                            sections[sIndex].topics[i];
                                    }
                                "
                                v-if="sections.length > 0"
                            />
                            <div v-else>
                                aun no existen secciones publicadas
                            </div>
                        </q-card-section>
                    </q-card>

                    <section-item-component
                        v-for="(section, index) in sections"
                        :key="index"
                        :sectionIndex="index"
                        :section="section"
                        :topics="topics"
                        :current-topic="currentTopic"
                        :segment="segment"
                        :skip="modules_skip"
                        :expand="index === 0"
                        class="q-mt-md"
                        @change-topic="onChangeTopic"
                    />
                </div>
            </div>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import SectionAddComponent from "../../components/modules/school/SectionAddComponent.vue";
import SectionEditComponent from "../../components/modules/school/SectionEditComponent.vue";
import SectionComponent from "../../components/modules/school/SectionComponent.vue";
import SectionItemComponent from "../../components/modules/school/SectionItemComponent.vue";
import NotificationComponent from "../../components/modules/school/notification/NotificationComponent.vue";
import MgrPrivateMsgComponent from "../../components/modules/privatemsg/MgrPrivateMsgComponent.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, onBeforeMount, onMounted, ref, watch } from "vue";
import { useQuasar } from "quasar";
import { getActiveModule } from "../../services/current_module";
import axios from "axios";

defineOptions({
    name: "LifePage",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const segment = ref(null);

const page = usePage();
const currentTopic = ref(null);
const currentSection = ref(null);
const sIndex = ref(0);
const tIndex = ref(0);

const has_add = ref(false);
const has_edit = ref(false);
const has_delete = ref(false);
let chat = null;
const show_chat = ref(null);

const modules_skip = ref(["learning", "reality"]);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

const topics = computed(() => {
    const sections = page.props.sections ?? [];
    let temp = [];
    sections.forEach((s) => {
        s.topics.forEach((t) => {
            temp.push(t);
        });
    });
    return temp;
});

const course_percentage = computed(() => {
    return page.props.course_percentage;
});

watch(sections, (n, o) => {
    setDefaults();
});

watch(currentTopic, (n, o) => {
    if (n) {
        tIndex.value = currentSection.value.topics.findIndex(
            (t) => t.id === currentTopic.value.id
        );
        updateLastCourses(n);
    } else tIndex.value = 0;
});

watch(
    () => page.url,
    (n) => {
        setDefaults();
    }
);

onBeforeMount(() => {
    let url = page.url.split("?")[0];
    if (url.includes("#")) {
        chat = url.substring(url.indexOf("#") + 6);
        url = url.substring(0, url.indexOf("#"));
    }
});

onMounted(() => {
    setDefaults();
});

const setDefaults = () => {
    const current_module = getActiveModule();
    const permissions = current_module.permissions.map((p) => p.name);
    const modelName = current_module.model.toLowerCase();
    has_add.value = permissions.includes(`add_${modelName}`);
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);

    const pathSegments = window.location.pathname.split("/");
    segment.value = pathSegments.pop() || pathSegments[pathSegments.length - 2];

    let n = sections.value;
    if (n.length > 0) {
        if (currentSection.value !== null) {
            let exist = n.find((s) => s.id === currentSection.value.id);
            if (exist === null || exist === undefined) {
                currentSection.value = n[0];
                sIndex.value = 0;
            } else {
                currentSection.value = exist;
                for (let i = 0; i < n.length; i++) {
                    if (n[i].id === currentSection.value.id) {
                        sIndex.value = i;
                        break;
                    }
                }
            }
        } else {
            if (chat != null) {
                let ids = chat.split("-");
                const section = n.find((s) => s.id === parseInt(ids[2]));
                if (section) {
                    currentSection.value = section;
                    const topic = section.topics.find(
                        (t) => t.id === parseInt(ids[1])
                    );
                    if (topic) {
                        currentTopic.value = topic;
                        show_chat.value = chat;
                    }
                } else {
                    currentSection.value = n[0];
                }
            } else {
                const latest = getLatest();
                if (latest) {
                    currentSection.value =
                        n.find((s) => s.id === latest.section_id) || n[0];
                    currentTopic.value = currentSection.value.topics.find(
                        (t) => t.id === latest.topic_id
                    );
                    sIndex.value = n.findIndex(
                        (s) => s.id === latest.section_id
                    );
                } else {
                    currentSection.value = n[0];
                    sIndex.value = 0;
                }
            }
        }
        if (currentTopic.value) {
            let exist = currentSection.value.topics.find(
                (t) => t.id === currentTopic.value.id
            );
            currentTopic.value = exist
                ? exist
                : currentSection.value.topics.length > 0
                ? currentSection.value.topics[0]
                : null;
        } else {
            currentTopic.value =
                currentSection.value.topics.length > 0
                    ? currentSection.value.topics[0]
                    : null;
        }
    } else {
        currentSection.value = null;
        currentTopic.value = null;
        sIndex.value = 0;
    }
};

const onChangeTopic = (attrs) => {
    const { section, topic, sectionIndex } = attrs;
    currentSection.value = section;
    currentTopic.value = topic;
    sIndex.value = sectionIndex;
};

const onChangeSection = (i) => {
    currentSection.value = sections.value[i];
    resetHash();
    setDefaults();
};

const resetHash = () => {
    if (chat !== null) {
        location.hash = "";
        chat = null;
    }
};

const getLatest = () => {
    return (
        page.props?.auth.user.latest_courses.find(
            (l) => l.category === segment.value
        ) ?? null
    );
};

const updateLastCourses = (topic) => {
    const latest = getLatest();
    const { id, section_id } = topic;
    if (!latest || id !== latest.topic_id || section_id !== latest.section_id) {
        axios.post("/admin/users/update-last-courses", {
            category: segment.value,
            topic_id: topic.id,
            section_id: topic.section_id,
        });
    }
};
</script>
