<template>
    <Layout title="publicaciones">
        <div
            class="row container q-mt-xl"
            :style="{ 'padding-top': screen.xs || screen.sm ? '40px' : '' }"
        >
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="row" v-if="files.length > 0">
                    <template
                        v-for="(f, indexFile) in files"
                        :key="`file-${indexFile}`"
                    >
                        <div
                            class="col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pa-sm text-center"
                            :class="screen.xs || screen.sm ? 'q-mb-md' : ''"
                            v-if="
                                currentCategory.name.toLowerCase() ===
                                    'newsletters' ||
                                currentCategory.name.toLowerCase() ===
                                    'newsletter'
                            "
                        >
                            <div class="q-pa-none" style="height: 200px">
                                <video-player
                                    :src="`${$page.props.public_path}storage/${f.path}`"
                                    :poster="
                                        f.poster
                                            ? `${$page.props.public_path}storage/${f.poster}`
                                            : null
                                    "
                                    controls
                                    responsive
                                    :volume="0.6"
                                    class="full-width full-height"
                                    v-if="f.type.startsWith('video/')"
                                />
                                <a
                                    class="glightbox"
                                    :href="`${$page.props.public_path}storage/${f.path}`"
                                    v-else-if="f.type.startsWith('image/')"
                                >
                                    <q-img
                                        :ratio="16 / 9"
                                        fit="fill"
                                        :src="`${$page.props.public_path}storage/${f.path}`"
                                    />
                                </a>
                                <a
                                    :href="`${$page.props.public_path}storage/${f.path}`"
                                    target="_blank"
                                    v-else
                                >
                                    <q-img
                                        class="full-width full-height"
                                        :src="`${$page.props.public_path}images/others/file.png`"
                                    />
                                </a>
                            </div>
                        </div>
                        <file-category-component
                            v-else-if="
                                currentCategory.name === 'posts' ||
                                currentCategory.name === 'post'
                            "
                        />
                        <div
                            class="col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pa-sm"
                            style="height: 250px !important"
                            v-else-if="
                                currentCategory.name === 'posts' ||
                                currentCategory.name === 'post'
                            "
                        >
                            <video-player
                                :src="`${$page.props.public_path}storage/${f.path}`"
                                :poster="
                                    f.poster
                                        ? `${$page.props.public_path}storage/${f.poster}`
                                        : null
                                "
                                controls
                                responsive
                                :volume="0.6"
                                class="full-width full-height"
                                v-if="
                                    f.type.startsWith('video/') ||
                                    f.type.startsWith('audio/')
                                "
                            />
                            <q-img
                                fit="fill"
                                width="100%"
                                height="100%"
                                :src="`${$page.props.public_path}storage/${f.path}`"
                                v-else-if="f.type.startsWith('image/')"
                            />
                            <q-item
                                v-else
                                clickable
                                target="_blank"
                                :href="`${$page.props.public_path}storage/${f.path}`"
                                ><q-img
                                    class="full-width full-height"
                                    :src="`${$page.props.public_path}images/others/file.png`"
                            /></q-item>
                        </div>
                        <div
                            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
                            v-else
                        >
                            <q-card class="my-card q-ma-sm rounded">
                                <q-card-section
                                    class="q-pa-sm q-pa-none bg-black"
                                    style="background-color: #000 !important"
                                >
                                    <video-player
                                        :src="`${$page.props.public_path}storage/${f.path}`"
                                        :poster="
                                            f.poster
                                                ? `${$page.props.public_path}storage/${f.poster}`
                                                : null
                                        "
                                        controls
                                        responsive
                                        :volume="0.6"
                                        class="full-width header-card"
                                        v-if="
                                            f.type.startsWith('video/') ||
                                            f.type.startsWith('audio/')
                                        "
                                    />
                                    <a
                                        :href="`${$page.props.public_path}storage/${f.path}`"
                                        target="_blank"
                                        v-else
                                    >
                                        <q-img
                                            :src="`${$page.props.public_path}images/group/6.jpg`"
                                            class="rounded-top full-width header-card"
                                        />
                                        <div class="column items-center">
                                            <i
                                                class="fa fa-file fa-4x text-white"
                                                style="margin-top: -120px"
                                            ></i>
                                        </div>
                                    </a>
                                </q-card-section>
                                <q-card-section class="text-center">
                                    <q-item-label lines="3">
                                        {{
                                            f.name.indexOf(".") >= 0
                                                ? f.name.substring(
                                                      0,
                                                      f.name.lastIndexOf(".")
                                                  )
                                                : f.name
                                        }}
                                    </q-item-label>
                                    <q-item-label
                                        class="q-pt-sm cursor-pointer text-primary"
                                    >
                                        <a
                                            class="text-uppercase text-primary"
                                            :href="`${$page.props.public_path}storage/${f.path}`"
                                            target="_blank"
                                            ><small>ver</small></a
                                        >
                                    </q-item-label>
                                </q-card-section>
                            </q-card>
                        </div>
                    </template>
                </div>
                <div class="row text-center q-mb-md" v-else>
                    <h3>
                        lo sentimos, aun no se han hecho publicaciones en esta
                        categoria
                    </h3>
                </div>
                <div
                    class="row q-pa-md"
                    v-if="currentCategory?.name === 'testimonios'"
                >
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
                                    si estas leyendo el libro o haces consulta
                                    conmigo tendras mucho que compartir con los
                                    demas. inicia sesion y podras escribir y/o
                                    subir un video con tu testimonio. la mejor
                                    opcion es siempre el video ya que llega a
                                    mas personas, ademas te ayuda a desprogramar
                                    miedos escenicos ligados a la aceptacion
                                    social. ya sabes que los miedos se deben
                                    enfrentar, pero si todavia no estas
                                    preparado para ello, por favor escribe lo
                                    que sientas, pues ayudaras a muchas personas
                                    <br />
                                    gracias!
                                </p>
                                <q-form ref="formRef" greedy v-if="showForm">
                                    <div class="row">
                                        <div
                                            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                        >
                                            <i
                                                class="mdi mdi-asterisk text-red"
                                                style="margin-left: 75px"
                                                v-if="!form.name"
                                            />
                                            <q-input
                                                v-model="form.name"
                                                name="name"
                                                placeholder="nombre"
                                                required
                                                dense
                                                rounded
                                                outlined
                                                bg-color="white"
                                                :class="
                                                    !screen.xs ? 'q-mr-xs' : ''
                                                "
                                                :rules="[
                                                    (val) =>
                                                        !!val || 'requerido',
                                                ]"
                                                hide-bottom-space
                                            />
                                        </div>
                                        <div
                                            class="col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                            :class="screen.xs ? 'q-mt-md' : ''"
                                        >
                                            <i
                                                class="mdi mdi-asterisk text-red"
                                                style="margin-left: 88px"
                                                v-if="!form.surname"
                                            />
                                            <q-input
                                                v-model="form.surname"
                                                type="text"
                                                name="surname"
                                                placeholder="apellidos"
                                                required
                                                dense
                                                rounded
                                                outlined
                                                bg-color="white"
                                                :class="
                                                    !screen.xs ? 'q-ml-xs' : ''
                                                "
                                                :rules="[
                                                    (val) =>
                                                        !!val || 'requerido',
                                                ]"
                                                hide-bottom-space
                                            />
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                        >
                                            <i
                                                class="mdi mdi-asterisk text-red"
                                                style="margin-left: 58px"
                                                v-if="!form.email"
                                            />
                                            <q-input
                                                v-model="form.email"
                                                name="email"
                                                placeholder="email"
                                                required
                                                dense
                                                rounded
                                                outlined
                                                bg-color="white"
                                                :rules="[
                                                    (val) =>
                                                        !!val || 'requerido',
                                                    (val, rules) =>
                                                        !!rules.email(val) ||
                                                        'email no valido',
                                                ]"
                                                hide-bottom-space
                                            />
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                        >
                                            <i
                                                class="mdi mdi-asterisk text-red"
                                                style="margin-left: 158px"
                                                v-if="!form.msg_title"
                                            />
                                            <q-input
                                                v-model="form.msg_title"
                                                type="text"
                                                name="msg_title"
                                                placeholder="titulo del mensaje"
                                                required
                                                dense
                                                rounded
                                                outlined
                                                bg-color="white"
                                                :rules="[
                                                    (val) =>
                                                        !!val || 'requerido',
                                                ]"
                                                hide-bottom-space
                                            />
                                        </div>
                                        <div
                                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                        >
                                            <i
                                                class="mdi mdi-asterisk text-red img-aster-msg"
                                                v-if="!form.message"
                                            />
                                            <q-input
                                                type="textarea"
                                                v-model="form.message"
                                                placeholder="mensaje"
                                                name="message"
                                                required
                                                dense
                                                rounded
                                                outlined
                                                bg-color="white"
                                                :rules="[
                                                    (val) =>
                                                        !!val || 'requerido',
                                                ]"
                                                hide-bottom-space
                                            >
                                            </q-input>
                                            <div class="column items-end">
                                                <q-btn
                                                    :icon="`img:${$page.props.public_path}images/icon/clipper.png`"
                                                    dense
                                                    flat
                                                    @click="fileRef.pickFiles()"
                                                    style="
                                                        margin-top: -52px;
                                                        margin-right: 10px;
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="row q-pt-md"
                                        v-if="form.attachments?.length > 0"
                                    >
                                        <q-list dense>
                                            <q-item
                                                class="q-ma-none"
                                                style="padding: 0"
                                            >
                                                <q-item-section
                                                    avatar
                                                    class="q-pa-none"
                                                    style="min-width: 30px"
                                                    v-if="
                                                        form.attachments
                                                            ?.length > 1
                                                    "
                                                >
                                                    <q-btn
                                                        flat
                                                        icon="fa fa-times-circle"
                                                        color="red"
                                                        padding="0"
                                                        @click="
                                                            form.attachments =
                                                                null
                                                        "
                                                    >
                                                        <q-tooltip
                                                            >quitar todos los
                                                            adjuntos</q-tooltip
                                                        >
                                                    </q-btn>
                                                </q-item-section>
                                                <q-item-section
                                                    class="text-white"
                                                >
                                                    <q-item-label
                                                        >adjuntos</q-item-label
                                                    >
                                                </q-item-section>
                                            </q-item>
                                            <q-separator
                                                color="white"
                                            ></q-separator>
                                            <q-item
                                                v-for="(
                                                    f, index
                                                ) in form.attachments"
                                                :key="`attachment_${index}`"
                                                class="q-ma-none"
                                                style="padding: 0"
                                            >
                                                <q-item-section
                                                    avatar
                                                    class="q-pa-none"
                                                    style="min-width: 30px"
                                                >
                                                    <q-btn
                                                        flat
                                                        icon="fa fa-times-circle"
                                                        color="red"
                                                        padding="0"
                                                        @click="
                                                            fileRef.removeAtIndex(
                                                                index
                                                            )
                                                        "
                                                    >
                                                        <q-tooltip
                                                            >quitar
                                                            adjunto</q-tooltip
                                                        >
                                                    </q-btn>
                                                </q-item-section>
                                                <q-item-section
                                                    class="text-white"
                                                >
                                                    <q-item-label>{{
                                                        f.name
                                                    }}</q-item-label>
                                                </q-item-section>
                                            </q-item>
                                        </q-list>
                                    </div>
                                    <q-file
                                        ref="fileRef"
                                        v-model="form.attachments"
                                        multiple
                                        class="hidden"
                                    />
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
                                @click="showForm = true"
                                v-if="!showForm"
                            />
                        </q-card>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="column items-center q-px-sm">
                    <list-category-component
                        :categories="categories"
                        :current="currentCategory"
                        :sticky="screen.xs || screen.sm"
                    />
                    <q-card
                        class="my-card rounded shadow-4 full-width q-mt-lg"
                        v-if="recent_files.length > 0"
                    >
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">mas recientes</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <q-list>
                                <q-item
                                    v-for="(f, indexRecent) in recent_files"
                                    :key="`recent-file-${indexRecent}`"
                                    class="q-py-md q-px-none"
                                    :class="
                                        indexRecent === recent_files.length - 1
                                            ? 'q-pb-none'
                                            : 'border-dashed-bottom-1'
                                    "
                                    :href="`${$page.props.public_path}storage/${f.path}`"
                                    target="_blank"
                                    clickable
                                >
                                    <q-item-section
                                        avatar
                                        style="width: 70px"
                                        class="q-pr-none"
                                    >
                                        <q-img
                                            :src="`${$page.props.public_path}images/others/publicaciones-recientes.png`"
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label
                                            lines="3"
                                            class="text-lowercase text-primary text-weight-bold"
                                            >{{
                                                f.name.substring(
                                                    0,
                                                    f.name.lastIndexOf(".")
                                                )
                                            }}</q-item-label
                                        >
                                        <q-item-label
                                            ><small>{{
                                                f.date_for_human
                                            }}</small></q-item-label
                                        >
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>

                    <q-card class="my-card rounded shadow-4 full-width q-my-lg">
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">redes sociales</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <div class="row">
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-facebook-f"
                                        label="facebook"
                                        class="full-width"
                                        no-caps
                                        href="https://www.facebook.com/profile.php?id=61563937152210"
                                        target="_blank"
                                        align="left"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-youtube"
                                        label=" youtube"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.youtube.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-instagram"
                                        label="instagram"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.instagram.com/sbyetransformacion/"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-tiktok"
                                        label="tiktok"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.tiktok.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import ListCategoryComponent from "../../components/landing/ListCategoryComponent.vue";

import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";

import FileCategoryComponent from "../../components/landing/FilesCategoryComponent.vue";

import { useQuasar } from "quasar";
import { errorValidation } from "../../helpers/notifications.js";

defineOptions({
    name: "Publicaciones",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const page = usePage();

onMounted(() => {
    var lightbox = GLightbox();
});

const currentCategory = computed(() => {
    return page.props.current_category;
});

const categories = computed(() => {
    return page.props.categories;
});

const recent_files = computed(() => {
    return page.props.recent_files;
});

const files = computed(() => {
    return page.props.files;
});

const cls = computed(() => {
    let category = currentCategory.value;
    if (category) {
        category = category.toLowerCase();
        if (category === "post" || category === "posts") {
            return "col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pa-sm";
        } else if (category === "newsletter" || category === "newsletters") {
            return "col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pa-sm text-center";
        } else {
            return "col-lg-6 col-md-6 col-sm-6 col-xs-12";
        }
    }
    return null;
});

const showForm = ref(false);

const fileRef = ref(null);

const formRef = ref(null);

const sending = ref(false);
const form = useForm({
    name: null,
    surname: null,
    email: null,
    msg_title: null,
    message: null,
    attachments: null,
});

const onCancel = () => {
    form.reset();
    showForm.value = false;
};

const onSubmit = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            // sending.value = true;
            // form.post("/contacts/store", {
            //     preserveScroll: true,
            //     onSuccess: () => {
            //         sending.value = false;
            //         iAmNot.value = false;
            //         contactPrivateArea.value = false;
            //         book_date.value = "text";
            //         form.reset();
            //         formRef.value.reset();
            //     },
            //     onError: () => {
            //         sending.value = false;
            //     },
            // });
        } else {
            errorValidation();
        }
    });
};
</script>

<style scope>
.border-dashed-bottom-1 {
    border-bottom: 1px dashed #70707057;
}

.list-unstyled {
    padding-left: 0;
    list-style: none;
}

.mdi-asterisk {
    opacity: 0.8;
    position: absolute;
    font-size: 12px;
    z-index: 9;
    margin-top: 5px;
}

.img-aster-msg {
    margin-top: 5px !important;
    margin-left: 83px;
    z-index: 9;
}

.q-field__control::before,
.q-field__control::after {
    border: 0.5px solid !important;
}

.q-textarea .q-field__native {
    resize: none !important;
}

.q-field__messages {
    font-size: 14px;
}

.rounded-top {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

.header-card {
    height: 160px;
}
.vjs-big-play-button {
    top: 50% !important;
    left: 50% !important;
    width: 40px !important;
    height: 40px !important;
    border-radius: 20px !important;
    border: none !important;
    line-height: 1.4em !important;
    margin-top: -20px !important;
    margin-left: -20px !important;
}
</style>
