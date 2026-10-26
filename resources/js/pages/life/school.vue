<template>
    <Layout>
        <q-page padding>
            <course-template>
                <template #panel-left>
                    <q-card>
                        <q-card-section class="text-center">
                            <mgr-private-msg-component />
                        </q-card-section>
                    </q-card>

                    <q-card>
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
                        <q-card-section>
                            <p class="text-bold">aviso editorial</p>

                            <text-truncate
                                text-more="leer aviso completo"
                                :text="editorialNotification"
                                style="text-align: justify"
                            />
                        </q-card-section>
                    </q-card>

                    <q-card>
                        <q-card-section>
                            <p class="text-bold">avisos</p>
                        </q-card-section>
                    </q-card>

                    <calculator-component />
                </template>
            </course-template>
        </q-page>
    </Layout>

    <q-dialog v-model="showDialog" persistent allow-focus-outside>
        <q-card>
            <dialog-header-component
                icon="mdi-bell-outline"
                title="aviso editorial"
                :closable="false"
            />

            <q-card-section class="justify">
                <p>{{ editorialNotification }}</p>
                <checkbox-field
                    name="read"
                    v-model="read"
                    label="he leído y comprendido la información del aviso editorial"
                    @update="(name, val) => (read = val)"
                />
            </q-card-section>

            <q-card-actions>
                <q-btn
                    :color="read ? 'black' : 'grey-3'"
                    :text-color="read ? 'white' : 'black'"
                    label="continuar al video libro"
                    no-caps
                    class="full-width"
                    :disable="!read"
                    @click="onRead"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import CourseTemplate from "../../components/others/CourseTemplate.vue";
import MgrPrivateMsgComponent from "../../components/modules/privatemsg/MgrPrivateMsgComponent.vue";
import CalculatorComponent from "../../components/life/CalculatorComponent.vue";
import TextTruncate from "../../components/others/TextTruncate.vue";

import DialogHeaderComponent from "../../components/base/DialogHeaderComponent.vue";
import CheckboxField from "../../components/form/input/CheckboxField.vue";
import { computed, onMounted, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";

const page = usePage();

const course_percentage = computed(() => {
    return page.props.course_percentage;
});

const showDialog = ref(false);

const read = ref(false);

const editorialNotification = `Las opiniones, reflexiones y experiencias recogidas en esta obra expresan la perspectiva personal de su autora y tienen una finalidad divulgativa y de desarrollo personal. No constituyen indicaciones individualizadas sobre tratamientos médicos o psicológicos. Las decisiones relativas a la salud y a los tratamientos corresponden a cada lector, quien deberá valorar sus circunstancias y los posibles riesgos antes de adoptarlas, con el asesoramiento profesional que resulte necesario.`;

onMounted(() => {
    const user = page.props.auth.user;
    if (!user?.editorial_notification) {
        showDialog.value = true;
    }
});

const onRead = () => {
    router.post(
        "/auth/read-editorial-notification",
        {},
        {
            onSuccess: () => {
                showDialog.value = false;
            },
        },
    );
};
</script>
