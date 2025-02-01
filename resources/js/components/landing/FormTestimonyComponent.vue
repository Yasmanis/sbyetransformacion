<template>
    <div class="col-lg-12 p-4 mt-4">
        <q-card
            class="my-card rounded bg-primary shadow-4"
            :class="showForm ? 'bg-company' : 'text-center'"
        >
            <q-card-section>
                <p class="text-white" style="font-size: 26px">
                    sube tu testimonio
                </p>
                <p class="text-white">
                    si estas leyendo el libro o haces consulta conmigo tendras
                    mucho que compartir con los demas. inicia sesion y podras
                    escribir y/o subir un video con tu testimonio. la mejor
                    opcion es siempre el video ya que llega a mas personas,
                    ademas te ayuda a desprogramar miedos escenicos ligados a la
                    aceptacion social. ya sabes que los miedos se deben
                    enfrentar, pero si todavia no estas preparado para ello, por
                    favor escribe lo que sientas, pues ayudaras a muchas
                    personas
                    <br />
                    gracias!
                </p>
                <q-form ref="formRef" greedy v-if="showForm">
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <q-input
                                v-model="form.name_to_show"
                                name="name_to_show"
                                placeholder="nombre que quieres que salga en el testimonio"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                hide-bottom-space
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.anonimous"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="marca esta casilla si quieres hacer un testimonio anonimo, aunque es preferible que utilices un pseudonimo o solo tu nombre o diminutivo"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <i
                                class="mdi mdi-asterisk text-red"
                                style="margin-left: 173px"
                                v-if="!form.title"
                            />
                            <q-input
                                v-model="form.title"
                                name="title"
                                placeholder="titulo del testimonio"
                                dense
                                rounded
                                outlined
                                :rules="[(val) => !!val || 'requerido']"
                                bg-color="white"
                                hide-bottom-space
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <span class="text-white"
                                >aqui tienes dos formas no excluyentes para
                                subir tu testimonio</span
                            >
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.testimonyTextCheck"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="escribir el testimonio"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                            v-if="form.testimonyTextCheck"
                        >
                            <i
                                class="mdi mdi-asterisk text-red img-aster-testimony"
                                v-if="!form.testimonyText"
                            />
                            <q-input
                                type="textarea"
                                v-model="form.testimonyText"
                                placeholder="testimonio"
                                name="testimonyText"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                :rules="[(val) => !!val || 'requerido']"
                                hide-bottom-space
                            >
                            </q-input>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.testimonyVideoCheck"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="subir testimonio en forma de video"
                                @update:model-value="onChangeTestimonyType"
                            />
                            <br />
                            <q-btn
                                icon="logout"
                                class="rotate-270"
                                flat
                                size="xl"
                                rounded
                                padding="5px"
                                @click="fileRef.pickFiles()"
                                v-if="
                                    form.testimonyVideoCheck &&
                                    !form.testimonyVideo
                                "
                            />
                            <q-file
                                style="display: none"
                                v-model="form.testimonyVideo"
                                accept="video/*"
                                ref="fileRef"
                                @rejected="onRejected"
                            ></q-file>
                            <q-item
                                class="q-ma-none"
                                style="padding: 0"
                                v-if="form.testimonyVideo"
                            >
                                <q-item-section
                                    avatar
                                    class="q-pa-none"
                                    style="min-width: 30px"
                                >
                                    <btn-delete-component
                                        color="white"
                                        @click="form.testimonyVideo = null"
                                    />
                                </q-item-section>
                                <q-item-section class="text-white">
                                    <q-item-label>{{
                                        form.testimonyVideo.name
                                    }}</q-item-label>
                                </q-item-section>
                            </q-item>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.amazonImgAttach"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="adjuntar imagen del testimonio de amazon"
                                @update:model-value="onChangeTestimonyType"
                            />
                            <br />
                            <q-btn
                                icon="mdi-image"
                                flat
                                size="xl"
                                rounded
                                padding="5px"
                                @click="fileAmazonImg.pickFiles()"
                                v-if="form.amazonImgAttach && !form.amazonImg"
                            />
                            <q-file
                                style="display: none"
                                v-model="form.amazonImg"
                                accept="image/*"
                                ref="fileAmazonImg"
                                @rejected="onRejected"
                            ></q-file>
                            <q-item
                                class="q-ma-none"
                                style="padding: 0"
                                v-if="form.amazonImg"
                            >
                                <q-item-section
                                    avatar
                                    class="q-pa-none"
                                    style="min-width: 30px"
                                >
                                    <btn-delete-component
                                        color="white"
                                        @click="form.amazonImg = null"
                                    />
                                </q-item-section>
                                <q-item-section class="text-white">
                                    <q-item-label>{{
                                        form.amazonImg.name
                                    }}</q-item-label>
                                </q-item-section>
                            </q-item>
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                        >
                            <span class="text-white"
                                >necesitas aclararnos algo o hablar con nosotros
                                para ayudarte?</span
                            >
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md text-white"
                        >
                            <q-checkbox
                                v-model="form.sendAdmMsg"
                                color="white"
                                checked-icon="mdi-circle"
                                dense
                                label="hablar con el administrador del sitio web"
                            />
                        </div>
                        <div
                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                            v-if="form.sendAdmMsg"
                        >
                            <i
                                class="mdi mdi-asterisk text-red img-aster-adm-msg"
                                v-if="!form.msg_to_admin"
                            />
                            <q-input
                                type="textarea"
                                v-model="form.msg_to_admin"
                                placeholder="mensaje"
                                name="msg_to_admin"
                                required
                                dense
                                rounded
                                outlined
                                bg-color="white"
                                :rules="[(val) => !!val || 'requerido']"
                                hide-bottom-space
                            >
                            </q-input>
                        </div>
                    </div>
                    <q-btn
                        rounded
                        color="black"
                        label="publicar"
                        no-caps
                        icon="mdi-upload"
                        class="q-mt-md q-ml-xs"
                        @click="onSubmit"
                    />
                    <q-btn
                        rounded
                        color="black"
                        label="cancelar"
                        no-caps
                        class="q-mt-md q-ml-xs"
                        icon="mdi-window-close"
                        @click="onCancel"
                    />
                </q-form>
            </q-card-section>

            <q-btn
                label="sube tu testimonio"
                rounded
                color="black"
                no-caps
                class="q-mb-md"
                @click="checkAuth"
                v-if="!showForm"
            />
        </q-card>
    </div>

    <confirm-component
        :show="confirm"
        width="500px"
        title=""
        iconHeader=""
        question="estas
    seguro de publicar</br>tu testimonio de forma anonima?"
        :message="`las personas que todavia no conocen</br>sbye transformacion preferiran ver tu nombre</br>si no
    quieres ser identificado simplemente usa tu nombre</br>o incluso un diminutivo o un pseudonimo
    <img src='${$page.props.public_path}images/icon/smile-2.png' width='20px' style='position: absolute; margin-top: 2px' />`"
        @ok="submit"
        @hide="confirm = false"
    />
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation, error } from "../../helpers/notifications";
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";
import ConfirmComponent from "../base/ConfirmComponent.vue";
import { useQuasar } from "quasar";

defineOptions({
    name: "FormTestimonyComponent",
});

const props = defineProps({
    category: Object,
});
const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const showForm = ref(false);
const confirm = ref(false);
const fileAmazonImg = ref(null);
const fileRef = ref(null);

const formRef = ref(null);

const form = useForm({
    name_to_show: null,
    anonimous: false,
    title: null,
    testimonyTextCheck: false,
    testimonyVideoCheck: false,
    amazonImgAttach: false,
    amazonImg: null,
    testimonyText: null,
    testimonyVideo: null,
    sendAdmMsg: false,
    msg_to_admin: null,
});

const onChangeTestimonyType = (val) => {
    if (!val) {
        form.testimonyVideo = null;
    }
};

const onCancel = () => {
    form.reset();
    showForm.value = false;
};

const onRejected = () => {
    error("archivo no admitido");
};

const checkAuth = () => {
    if (usePage().props.auth) {
        showForm.value = true;
    } else {
        $q.notify({
            position: "top-right",
            timeout: 0,
            multiLine: true,
            textColor: "black",
            color: "white",
            badgeTextColor: "dark",
            classes: "bg-custom-blue",
            type: "info",
            message: `para subir tu testimonio debes ser usuario registrado. inicia sesion en el <a href="/login">area privada</a> o registrate en <a href="/contactame">contactame</a>`,
            html: true,
            actions: [
                {
                    icon: "mdi-close-circle-outline",
                    color: "black",
                    handler: () => {
                        /* ... */
                    },
                },
            ],
        });
    }
};

const onSubmit = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            if (
                !form.testimonyVideo &&
                (form.testimonyText === null ||
                    form.testimonyText.trim() === "")
            ) {
                error(
                    "debe al menos especificar un tipo de testimonio; escrito o video"
                );
            } else if (form.anonimous) {
                confirm.value = true;
            } else {
                submit();
            }
        } else {
            errorValidation();
        }
    });
};

const submit = () => {
    form.post("/admin/testimony/store-from-publications", {
        onSuccess: () => {
            form.reset();
            confirm.value = false;
            $q.dialog({
                title: "info",
                message:
                    "revisaremos que tu testimonio cumple con la etica general y tras ello se publicara",
                ok: {
                    flat: true,
                },
            });
        },
    });
};
</script>
<style>
.q-checkbox__bg {
    border-radius: 10px;
    border-color: #fff;
}

.q-checkbox__icon-container i {
    font-size: 0.6em;
}

.q-checkbox__label {
    width: 100%;
}

.img-aster-testimony {
    margin-top: 5px !important;
    margin-left: 98px;
    z-index: 9;
}

.img-aster-adm-msg {
    margin-top: 5px !important;
    margin-left: 82px;
    z-index: 9;
}
</style>
