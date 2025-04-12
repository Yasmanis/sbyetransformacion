<template>
    <btn-show-hide-component :public="false" @click="showDialog = true" />

    <q-dialog v-model="showDialog">
        <q-card style="width: 400px; max-width: 50vw">
            <q-toolbar>
                <q-toolbar-title style="padding-left: 5px">{{
                    data.title
                }}</q-toolbar-title>
                <q-btn-component
                    tooltips="configurar notificacion"
                    icon="mdi-cog-outline"
                >
                    <q-menu ref="menuConfig">
                        <q-card style="width: 270px">
                            <q-card-section>
                                <q-icon name="mdi-bell-off-outline" />
                                desactivar notificaciones
                            </q-card-section>
                            <q-separator />
                            <q-card-section class="q-pt-none">
                                <q-form ref="formRef" greedy>
                                    <text-field
                                        name="by"
                                        type="number"
                                        label="por"
                                        :model-value="formData.config.by"
                                        @update="onUpdate"
                                        :othersProps="{
                                            required: true,
                                        }"
                                    />
                                    <select-field
                                        name="period"
                                        :model-value="formData.config.period"
                                        class="q-mt-sm"
                                        label="periodo"
                                        dense
                                        :filterable="false"
                                        options-dense
                                        :othersProps="{
                                            required: true,
                                        }"
                                        :options="[
                                            {
                                                label: 'dia',
                                                value: 'day',
                                            },
                                            {
                                                label: 'semana',
                                                value: 'week',
                                            },
                                            {
                                                label: 'mes',
                                                value: 'month',
                                            },
                                            {
                                                label: 'año',
                                                value: 'year',
                                            },
                                        ]"
                                        @update="onUpdate"
                                    />
                                </q-form>
                            </q-card-section>
                            <q-card-actions>
                                <q-btn
                                    class="full-width"
                                    no-caps
                                    label="desactivar"
                                    color="primary"
                                    @click="disableNotification"
                                />
                            </q-card-actions>
                        </q-card>
                    </q-menu>
                </q-btn-component>
            </q-toolbar>
            <q-card-section>
                <div class="row">
                    <div
                        class="col-xs-5 col-md-12 col-lg-12 col-sm-12 col-xl-12"
                        v-if="data.image"
                    >
                        <q-img
                            :src="`${$page.props.public_path}${
                                data.image.startsWith('image')
                                    ? data.image
                                    : `storage/${data.image}`
                            }`"
                            :ratio="1"
                            fit="fill"
                        />
                    </div>
                    <div
                        class="col-xs-7 col-md-12 col-lg-12 col-sm-12 col-xl-12"
                        :class="Screen.xs ? 'q-pl-sm' : 'q-pt-sm'"
                    >
                        <span v-html="data.message"></span>
                    </div>
                    <div
                        class="full-width text-center q-pt-md"
                        v-if="data.logo"
                    >
                        <q-img
                            :src="`${$page.props.public_path}${data.logo}`"
                            width="100px"
                        />

                        <q-btn-component
                            icon="mdi-video"
                            class="absolute-bottom-right q-ma-xs"
                            tooltips="ver video"
                            @click="dialogVideo = true"
                            v-if="data.video"
                        />
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>

    <confirm-component
        iconHeader="mdi-bell-off-outline"
        title="desactivar notificaciones"
        message="contempla la opcion de silenciar estas notificaciones <br/> las ideas breves de sbye transformacion son una forma<br/> sencilla y facil de aprender lo mas importante"
        :show="show"
        width="500px"
        @ok="disableNotification"
        @hide="show = false"
    />

    <q-dialog v-model="dialogVideo" persistent v-if="data.video">
        <q-card>
            <q-card-section style="width: 400px">
                <q-responsive :ratio="1">
                    <video-player
                        :src="`${$page.props.public_path}storage/${data.video}`"
                        controls
                        aspectRatio="16:9"
                        :volume="0.6"
                    />
                </q-responsive>
                <q-btn
                    label="cerrar"
                    no-caps
                    color="primary"
                    outline
                    class="full-width q-mt-sm"
                    @click="dialogVideo = false"
                />
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import ConfirmComponent from "../../../base/ConfirmComponent.vue";
import BtnShowHideComponent from "../../../btn/BtnShowHideComponent.vue";
import QBtnComponent from "../../../base/QBtnComponent.vue";
import SelectField from "../../../form/input/SelectField.vue";
import TextField from "../../../form/input/TextField.vue";
import { router, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { Screen } from "quasar";
import { errorValidation } from "../../../../helpers/notifications";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

defineOptions({
    name: "ViewBriefIdeaComponent",
});

const props = defineProps({
    data: Object,
});

const show = ref(false);
const showDialog = ref(false);
const dialogVideo = ref(false);
const formData = useForm({
    config: {
        by: null,
        period: null,
    },
});
const menuConfig = ref(false);
const formRef = ref(null);

onMounted(() => {
    if (props.data.notification_config) {
        formData.config = {
            by: props.data.notification_config.by,
            period: props.data.notification_config.period,
        };
    }
});

const onUpdate = (name, val) => {
    formData.config[name] = val;
};

const disableNotification = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            save();
        } else {
            errorValidation();
        }
    });
};

const save = () => {
    formData.post(`/admin/briefideas/config-notification/${props.data.id}`, {
        onSuccess: () => {
            show.value = false;
            menuConfig.value.hide();
        },
    });
};
</script>
