<template>
    <btn-files-folder-component @click="showDialog = true" />

    <q-dialog
        v-model="showDialog"
        persistent
        @before-show="onShow"
        @hide="tab = 'progress'"
        full-width
    >
        <q-card style="max-width: 80vw">
            <dialog-header-component
                icon="mdi-book-open-page-variant-outline"
                :title="`informe de ${object.full_name}`"
                closable
            />
            <q-card-section style="max-height: 50vh" class="scroll q-pa-none">
                <q-tabs
                    v-model="tab"
                    no-caps
                    inline-label
                    :class="Dark.isActive ? '' : 'bg-white text-primary'"
                    align="justify"
                >
                    <q-tab
                        name="progress"
                        icon="mdi-progress-check"
                        label="progreso"
                    />
                    <q-tab
                        name="comments"
                        icon="mdi-comment-processing-outline"
                        label="comentarios"
                    />
                </q-tabs>
                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="progress">
                        <q-card flat>
                            <q-card-section class="no-padding">
                                <q-list dense>
                                    <q-expansion-item
                                        v-for="(s, indexSection) in sections"
                                        :key="`section-${indexSection}`"
                                        dense
                                        :class="
                                            s.sections.length === 0
                                                ? 'hidden'
                                                : null
                                        "
                                    >
                                        <template v-slot:header>
                                            <q-item-section>
                                                {{ s.label }}
                                            </q-item-section>

                                            <q-item-section
                                                style="
                                                    padding-left: 40px !important;
                                                "
                                            >
                                                <q-linear-progress
                                                    :value="s.percent / 100"
                                                    size="20px"
                                                >
                                                    <div
                                                        class="absolute-full flex flex-center"
                                                    >
                                                        <q-badge
                                                            color="white"
                                                            text-color="primary"
                                                            :label="`${
                                                                Math.round(
                                                                    s.percent *
                                                                        100
                                                                ) / 100
                                                            } %`"
                                                        />
                                                    </div>
                                                </q-linear-progress>
                                            </q-item-section>
                                        </template>
                                        <q-list
                                            dense
                                            v-for="(ss, indexST) in s.sections"
                                            :key="`section-topic-${indexST}`"
                                        >
                                            <q-item>
                                                <q-item-section>
                                                    <q-item-label
                                                        class="q-ml-md"
                                                    >
                                                        {{ ss.name }}
                                                    </q-item-label>
                                                </q-item-section>
                                                <q-item-section>
                                                    <q-linear-progress
                                                        :value="
                                                            ss.percent / 100
                                                        "
                                                        size="20px"
                                                    >
                                                        <div
                                                            class="absolute-full flex flex-center"
                                                        >
                                                            <q-badge
                                                                color="white"
                                                                text-color="primary"
                                                                :label="`${
                                                                    Math.round(
                                                                        ss.percent *
                                                                            100
                                                                    ) / 100
                                                                } %`"
                                                            />
                                                        </div>
                                                    </q-linear-progress>
                                                </q-item-section>
                                            </q-item>
                                            <q-list dense>
                                                <q-item
                                                    v-for="(
                                                        t, indexTopix
                                                    ) in ss.topics"
                                                    :key="`topic-${indexTopix}`"
                                                >
                                                    <q-item-section>
                                                        <q-item-label
                                                            class="q-ml-xl"
                                                        >
                                                            {{ t.name }}
                                                        </q-item-label>
                                                    </q-item-section>
                                                    <q-item-section>
                                                        <q-linear-progress
                                                            :value="
                                                                t.percent / 100
                                                            "
                                                            size="20px"
                                                        >
                                                            <div
                                                                class="absolute-full flex flex-center"
                                                            >
                                                                <q-badge
                                                                    color="white"
                                                                    text-color="primary"
                                                                    :label="`${
                                                                        Math.round(
                                                                            t.percent *
                                                                                100
                                                                        ) / 100
                                                                    } %`"
                                                                />
                                                            </div>
                                                        </q-linear-progress>
                                                    </q-item-section>
                                                </q-item>
                                            </q-list>
                                        </q-list>
                                    </q-expansion-item>
                                </q-list>
                            </q-card-section>
                        </q-card>
                    </q-tab-panel>

                    <q-tab-panel name="comments">
                        <comments-component :object="object" />
                    </q-tab-panel>
                </q-tab-panels>
                <q-inner-loading :showing="showLoading" />
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { Dark } from "quasar";
import BtnFilesFolderComponent from "../../btn/BtnFilesFolderComponent.vue";
import CommentsComponent from "./CommentsComponent.vue";
import axios from "axios";
defineOptions({
    name: "ProgressComponent",
});

const props = defineProps({
    object: {
        type: Object,
        required: true,
    },
});

const showDialog = ref(false);

const tab = ref("progress");

const sections = ref([
    {
        name: "school",
        label: "Vivir en plenitud",
        icon: "mdi-emoticon-outline",
        percent: 0,
        sections: [],
    },
    {
        name: "conference",
        label: "Conferencias",
        icon: "mdi-webcam",
        percent: 0,
        sections: [],
    },
    {
        name: "newsletter",
        label: "Newsletters",
        icon: "mdi-email-outline",
        percent: 0,
        sections: [],
    },
    {
        name: "post",
        label: "Posts",
        icon: "mdi-file-sign",
        percent: 0,
        sections: [],
    },
    {
        name: "reality",
        label: "Crear la realidad",
        icon: "mdi-file-sign",
        percent: 0,
        sections: [],
    },
    {
        name: "learning",
        label: "Aprender a liberar",
        icon: "mdi-file-sign",
        percent: 0,
        sections: [],
    },
]);

const showLoading = ref(false);
let loading = 0;

const onShow = async () => {
    sections.value.forEach(async (s) => {
        s.sections = [];
        loading++;
        if (!showLoading.value) {
            showLoading.value = true;
        }
        await axios
            .post(`/admin/users/progress/${props.object.id}`, {
                section: s.name,
            })
            .then((response) => {
                s.sections = response.data.sections.sections;
                s.percent = response.data.sections.percent;
            })
            .finally(() => {
                loading--;
                if (loading === 0) {
                    showLoading.value = false;
                }
            });
    });
};
</script>
