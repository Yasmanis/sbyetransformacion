<template>
    <Layout>
        <q-page padding>
            <div class="row">
                <div
                    class="col-md-4 col-lg-4 col-sm-4 col-xs-12 q-sm-pr-md"
                    :class="screen.xs ? 'q-mb-md' : 'q-pr-md'"
                >
                    <q-card>
                        <q-card-section class="text-center q-pb-sm">
                            <p class="q-mb-none">
                                {{ course_percentage }}% COMPLETO
                            </p>
                            <q-linear-progress
                                :value="course_percentage / 100"
                                size="10px"
                            />
                        </q-card-section>
                    </q-card>

                    <q-card>
                        <q-card-section class="text-bold q-mt-md">
                            <p class="text-bold">avisos</p>
                        </q-card-section>
                    </q-card>
                </div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <q-card>
                        <q-card-section class="q-pa-none">
                            <q-toolbar class="q-gutter-x-sm">
                                <section-add-component />
                                <section-edit-component />
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
                                @change-section="onChangeSection"
                                @change-topic="
                                    (i) =>
                                        (currentTopic =
                                            sections[sIndex].topics[i])
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
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";
import { useQuasar } from "quasar";

defineOptions({
    name: "LifePage",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const page = usePage();
const currentTopic = ref(null);
const currentSection = ref(null);
const sIndex = ref(0);
const tIndex = ref(0);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

const course_percentage = computed(() => {
    return page.props.course_percentage;
});

watch(sections, (n, o) => {
    setDefaults();
});

watch(currentTopic, (n, o) => {
    if (n !== null)
        tIndex.value = currentSection.value.topics.findIndex(
            (t) => t.id === currentTopic.value.id
        );
    else tIndex.value = 0;
});

onMounted(() => {
    setDefaults();
});

const setDefaults = () => {
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
            currentSection.value = n[0];
            sIndex.value = 0;
        }
        if (currentTopic.value !== null) {
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
    setDefaults();
};
</script>
