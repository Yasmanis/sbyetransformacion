<template>
    <Layout>
        <q-page padding>
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
                        :index="index"
                        :totalSections="sections.length"
                        v-if="sections.length > 0"
                    />
                    <div v-else>aun no existen secciones publicadas</div>
                </q-card-section>
            </q-card>

            <section-item-component
                v-for="(section, sectionIndex) in sections"
                :key="sectionIndex"
                :sectionIndex="sectionIndex"
                :section="section"
                :expand="sectionIndex === 0"
                class="q-mt-md"
                @change-topic="onChangeTopic"
            />
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

defineOptions({
    name: "LifePage",
});

const page = usePage();

const currentTopic = ref(null);
const currentSection = ref(null);
const index = ref(0);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

watch(sections, (n, o) => {
    setDefaults();
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
                index.value = 0;
            } else {
                currentSection.value = exist;
                for (let i = 0; i < n.length; i++) {
                    if (n[i].id === currentSection.value.id) {
                        index.value = i;
                        break;
                    }
                }
            }
        } else {
            currentSection.value = n[0];
            index.value = 0;
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
        index.value = 0;
    }
};

const onChangeTopic = (attrs) => {
    const { section, topic, sectionIndex } = attrs;
    currentSection.value = section;
    currentTopic.value = topic;
    index.value = sectionIndex;
};
</script>
