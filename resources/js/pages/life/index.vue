<template>
    <Layout>
        <q-page padding>
            <q-card>
                <q-card-section class="q-pa-none">
                    <q-toolbar>
                        <section-add-component />
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
const principalVideo = ref(null);

const sections = computed(() => {
    return page.props.sections ? page.props.sections : [];
});

onMounted(() => {
    currentSection.value = sections.value.length > 0 ? sections.value[0] : null;
    currentTopic.value = currentSection.value
        ? currentSection.value.topics.length > 0
            ? currentSection.value.topics[0]
            : null
        : null;
});

const onChangeTopic = (attrs) => {
    const { section, topic, sectionIndex } = attrs;
    currentTopic.value = topic;
    index.value = sectionIndex;
    principalVideo.value = currentTopic.value.resources.find(
        (r) => r.principal
    );
};
</script>
