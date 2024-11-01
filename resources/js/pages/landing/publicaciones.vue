<template>
    <Layout>
        <section class="banner page-banner position-relative pb-0">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-title text-center position-relative pb-5">
                    <p class="text-white text-uppercase header-title">
                        publicaciones
                    </p>
                </div>
            </div>
        </section>
        <section class="news-archive">
            <div class="container">
                <div class="news-archive-inner">
                    <div class="row gy-5">
                        <div class="col-lg-8">
                            <div class="news-left me-4 m-md-0">
                                <div
                                    class="row g-md-5 gy-5"
                                    v-if="files.length > 0"
                                >
                                    <template
                                        v-for="(f, indexFile) in files"
                                        :key="`file-${indexFile}`"
                                    >
                                        <div
                                            class="col-lg-3 col-md-3"
                                            v-if="
                                                currentCategory.name ===
                                                'newsletters'
                                            "
                                        >
                                            <video
                                                :src="`${$page.props.public_path}storage/${f.path}`"
                                                controls
                                                class="w-100 h-100"
                                                v-if="
                                                    f.type.startsWith('video/')
                                                "
                                            ></video>
                                            <img
                                                class="w-100 h-100"
                                                :src="`${$page.props.public_path}storage/${f.path}`"
                                                v-else-if="
                                                    f.type.startsWith('image/')
                                                "
                                            />
                                            <a
                                                :href="`${$page.props.public_path}storage/${f.path}`"
                                                target="_blank"
                                                v-else
                                            >
                                                <img
                                                    class="blog-img rounded-top w-100 h-auto"
                                                    :src="`${$page.props.public_path}images/others/file.png`"
                                                    style="
                                                        height: 160px !important;
                                                    "
                                                />
                                            </a>
                                        </div>
                                        <div
                                            class="col-lg-4 col-md-4"
                                            style="height: 250px !important"
                                            v-else-if="
                                                currentCategory.name === 'posts'
                                            "
                                        >
                                            <video
                                                :src="`${$page.props.public_path}storage/${f.path}`"
                                                controls
                                                class="w-100 h-100"
                                                v-if="
                                                    f.type.startsWith('video/')
                                                "
                                            ></video>
                                            <img
                                                class="w-100 h-100"
                                                :src="`${$page.props.public_path}storage/${f.path}`"
                                                v-else-if="
                                                    f.type.startsWith('image/')
                                                "
                                            />
                                        </div>
                                        <div class="col-lg-6 col-md-6" v-else>
                                            <div
                                                class="blog-box border border-1 rounded pb-2 text-center"
                                            >
                                                <div class="blog-img">
                                                    <video
                                                        :src="`${$page.props.public_path}storage/${f.path}`"
                                                        controls
                                                        class="blog-img rounded-top w-100"
                                                        v-if="
                                                            f.type.startsWith(
                                                                'video/'
                                                            ) ||
                                                            f.type.startsWith(
                                                                'audio/'
                                                            )
                                                        "
                                                    ></video>
                                                    <a
                                                        :href="`${$page.props.public_path}storage/${f.path}`"
                                                        target="_blank"
                                                        v-else
                                                    >
                                                        <img
                                                            class="blog-img rounded-top w-100 h-auto"
                                                            :src="`${$page.props.public_path}images/group/6.jpg`"
                                                            style="
                                                                height: 160px !important;
                                                            "
                                                        />
                                                    </a>
                                                </div>
                                                <div class="blog-info p-4">
                                                    <h5
                                                        class="mb-2 text-lowercase"
                                                    >
                                                        <a
                                                            :href="`${$page.props.public_path}storage/${f.path}`"
                                                            target="_blank"
                                                            class="font-black"
                                                        >
                                                            {{
                                                                f.name.indexOf(
                                                                    "."
                                                                ) >= 0
                                                                    ? f.name.substring(
                                                                          0,
                                                                          f.name.lastIndexOf(
                                                                              "."
                                                                          )
                                                                      )
                                                                    : f.name
                                                            }}</a
                                                        >
                                                    </h5>
                                                    <a
                                                        class="text-uppercase font-company"
                                                        :href="`${$page.props.public_path}storage/${f.path}`"
                                                        target="_blank"
                                                        ><small>ver</small></a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="row g-md-5 gy-5 text-center" v-else>
                                    <h3>
                                        lo sentimos, aun no se han hecho
                                        publicaciones en esta categoria
                                    </h3>
                                </div>
                                <div
                                    class="row"
                                    v-if="
                                        currentCategory?.name === 'testimonios'
                                    "
                                >
                                    <div
                                        class="col-lg-12 p-4 mt-4"
                                        :class="
                                            showForm
                                                ? 'bg-company'
                                                : 'text-center'
                                        "
                                    >
                                        <div class="form" v-if="showForm">
                                            <p
                                                class="text-white"
                                                style="font-size: 26px"
                                            >
                                                sube tu testimonio
                                            </p>
                                            <p class="text-white">
                                                si estas leyendo el libro o
                                                haces consulta conmigo tendras
                                                mucho que compartir con los
                                                demas. inicia sesion y podras
                                                escribir y/o subir un video con
                                                tu testimonio. la mejor opcion
                                                es siempre el video ya que llega
                                                a mas personas, ademas te ayuda
                                                a desprogramar miedos escenicos
                                                ligados a la aceptacion social.
                                                ya sabes que los miedos se deben
                                                enfrentar, peo si todavia no
                                                estas preparado para ello, por
                                                favor escribe lo que sientas,
                                                pues ayudaras a muchas personas.
                                                <br />
                                                gracias!
                                            </p>
                                            <form
                                                id="form-contact"
                                                @submit.prevent="onSubmit"
                                            >
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input
                                                            v-model="form.name"
                                                            type="text"
                                                            name="name"
                                                            placeholder="nombre"
                                                            required
                                                            class="mb-3"
                                                        />
                                                        <img
                                                            :src="`${$page.props.public_path}images/icon/aster.png`"
                                                            style="
                                                                width: 8px;
                                                                margin-top: -40px;
                                                                margin-left: 77px;
                                                                contain: content;
                                                                float: left;
                                                                opacity: 0.6;
                                                            "
                                                            v-if="!form.name"
                                                        />
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input
                                                            v-model="
                                                                form.surname
                                                            "
                                                            type="text"
                                                            name="surname"
                                                            placeholder="apellidos"
                                                            required
                                                            class="mb-3"
                                                        />
                                                        <img
                                                            :src="`${$page.props.public_path}images/icon/aster.png`"
                                                            style="
                                                                width: 8px;
                                                                margin-top: -40px;
                                                                margin-left: 86px;
                                                                contain: content;
                                                                float: left;
                                                                opacity: 0.6;
                                                            "
                                                            v-if="!form.surname"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="subject">
                                                    <input
                                                        v-model="form.email"
                                                        type="email"
                                                        name="email"
                                                        placeholder="email"
                                                        required
                                                        class="mb-3"
                                                    />
                                                    <img
                                                        :src="`${$page.props.public_path}images/icon/aster.png`"
                                                        style="
                                                            width: 8px;
                                                            margin-top: -40px;
                                                            margin-left: 60px;
                                                            contain: content;
                                                            float: left;
                                                            opacity: 0.6;
                                                        "
                                                        v-if="!form.email"
                                                    />
                                                </div>
                                                <div class="message">
                                                    <input
                                                        v-model="form.msg_title"
                                                        type="text"
                                                        name="msg_title"
                                                        placeholder="titulo del mensaje"
                                                        required
                                                        class="mb-3"
                                                    />
                                                    <img
                                                        :src="`${$page.props.public_path}images/icon/aster.png`"
                                                        style="
                                                            width: 8px;
                                                            margin-top: -40px;
                                                            margin-left: 150px;
                                                            contain: content;
                                                            float: left;
                                                            opacity: 0.6;
                                                        "
                                                        v-if="!form.msg_title"
                                                    />
                                                    <textarea
                                                        v-model="form.message"
                                                        placeholder="mensaje"
                                                        name="message"
                                                        class="mb-3"
                                                        rows="5"
                                                        style="resize: none"
                                                        required
                                                    ></textarea>
                                                    <img
                                                        :src="`${$page.props.public_path}images/icon/aster.png`"
                                                        style="
                                                            width: 8px;
                                                            margin-top: -130px;
                                                            margin-left: 82px;
                                                            contain: content;
                                                            float: left;
                                                            opacity: 0.6;
                                                        "
                                                        v-if="!form.message"
                                                    />
                                                    <label
                                                        id="tooltip-attachments"
                                                        href="javascript:;"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="right"
                                                        title="añadir adjuntos"
                                                        for="attachments"
                                                        style="
                                                            float: right;
                                                            margin-top: -60px;
                                                            contain: content;
                                                            margin-right: 10px;
                                                            cursor: pointer;
                                                        "
                                                    >
                                                        <img
                                                            :src="`${$page.props.public_path}images/icon/clipper.png`"
                                                            style="width: 30px"
                                                        />
                                                    </label>
                                                    <input
                                                        @input="
                                                            form.attachments =
                                                                $event.target.files
                                                        "
                                                        type="file"
                                                        multiple
                                                        style="display: none"
                                                        id="attachments"
                                                    />

                                                    <ul
                                                        v-if="
                                                            form?.attachments
                                                                ?.length > 0
                                                        "
                                                    >
                                                        <li
                                                            class="text-white"
                                                            style="
                                                                list-style: none;
                                                                margin-left: -20px;
                                                            "
                                                        >
                                                            adjuntos
                                                        </li>
                                                        <li
                                                            class="text-white"
                                                            v-for="(
                                                                f, index
                                                            ) in form.attachments"
                                                            :key="`attachment_${index}`"
                                                        >
                                                            {{ f.name }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <button
                                                    class="btn"
                                                    type="submit"
                                                    :disabled="sending"
                                                >
                                                    publicar<i
                                                        class="fa fa-long-arrow-right ms-3"
                                                    ></i>
                                                </button>

                                                <button
                                                    class="btn mx-2"
                                                    @click="onCancel"
                                                >
                                                    <i class="fa fa-times"></i>
                                                    cancelar
                                                </button>
                                            </form>
                                        </div>
                                        <button
                                            class="btn"
                                            style="width: 220px"
                                            @click="showForm = true"
                                            v-if="!showForm"
                                        >
                                            sube tu testimonio
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="news-right ms-4 m-md-0"></div>
                            <div class="catagories p-6 rounded box-shadow mb-6">
                                <h6 class="mb-3">categorias</h6>
                                <div
                                    class="sperator mb-4 m-0 w-20 border-bottom border-2 border-company"
                                ></div>
                                <ul class="m-0 p-0 list-unstyled">
                                    <li
                                        v-for="(c, index) in categories"
                                        :key="`category-${index}`"
                                        class="py-3 border-dashed-bottom-1"
                                    >
                                        <a
                                            href="javascript:;"
                                            @click="currentCategory = c"
                                            class="font-company"
                                            :style="{
                                                'font-weight':
                                                    currentCategory?.id === c.id
                                                        ? 'bold'
                                                        : '',
                                            }"
                                            ><i
                                                class="fa fa-check font-company pe-3"
                                                aria-hidden="true"
                                            ></i
                                            >{{ c.name }}</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div
                                class="recent-post-box p-6 box-shadow rounded mb-6"
                            >
                                <h6 class="mb-2">mas recientes</h6>
                                <div
                                    class="sperator w-20 border-bottom border-2 border-company mb-5"
                                ></div>
                                <div class="recent-post-list">
                                    <div class="row">
                                        <div
                                            v-for="(
                                                f, indexRecent
                                            ) in recent_files"
                                            :key="`recent-file-${indexRecent}`"
                                            class="col-lg-12 col-md-6"
                                        >
                                            <div
                                                class="recent-post d-flex align-items-center mb-4"
                                            >
                                                <div class="post-img">
                                                    <a
                                                        :href="`${$page.props.public_path}storage/${f.path}`"
                                                        target="_blank"
                                                        ><img
                                                            :src="`${$page.props.public_path}images/others/publicaciones-recientes.png`"
                                                    /></a>
                                                </div>
                                                <div
                                                    class="post-detail"
                                                    style="width: 70%"
                                                >
                                                    <a
                                                        :href="`${$page.props.public_path}storage/${f.path}`"
                                                        target="_blank"
                                                        class="font-black fw-bold text-uppercase"
                                                    >
                                                        <q-item-label
                                                            lines="3"
                                                            class="text-lowercase font-company"
                                                            >{{
                                                                f.name.substring(
                                                                    0,
                                                                    f.name.lastIndexOf(
                                                                        "."
                                                                    )
                                                                )
                                                            }}</q-item-label
                                                        >
                                                    </a>
                                                    <p class="mb-0">
                                                        <small>{{
                                                            f.date_for_human
                                                        }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="social-media-links">
                                <h6 class="mb-2">redes sociales</h6>
                                <div
                                    class="sperator m-0 mb-5 w-20 border-bottom border-2 border-company"
                                ></div>
                                <div class="social-media-inner">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a
                                                href="https://www.facebook.com/profile.php?id=61563937152210"
                                                target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"
                                                ><i
                                                    class="fa fa-facebook-official rounded mx-2 me-3"
                                                    aria-hidden="true"
                                                ></i
                                                >facebook</a
                                            >
                                        </div>
                                        <div class="col-6">
                                            <a
                                                href="https://www.youtube.com/@sbyetransformacion"
                                                target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"
                                                ><i
                                                    class="fa fa-youtube-play rounded mx-2 me-3"
                                                    aria-hidden="true"
                                                ></i
                                                >youtube</a
                                            >
                                        </div>
                                        <div class="col-6">
                                            <a
                                                href="https://www.instagram.com/sbyetransformacion/"
                                                target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"
                                                ><i
                                                    class="fa fa-instagram rounded mx-2 me-3"
                                                    aria-hidden="true"
                                                ></i
                                                >instagram</a
                                            >
                                        </div>
                                        <div class="col-6">
                                            <a
                                                href="https://www.tiktok.com/@sbyetransformacion"
                                                target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"
                                            >
                                                <img
                                                    :src="`${$page.props.public_path}images/icon/tiktok.png`"
                                                    class="rounded mx-2 me-3"
                                                    style="width: 20px"
                                                />tiktok</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { Link, usePage, useForm } from "@inertiajs/vue3";
import { QItemLabel } from "quasar";
import "@quasar/extras/animate/animate-list.js";

defineOptions({
    name: "Publicaciones",
});

const page = usePage();

const files = ref([]);

const currentCategory = ref(null);

const categories = computed(() => {
    return page.props.categories;
});

const recent_files = computed(() => {
    return page.props.recent_files;
});

const showForm = ref(false);

const form = useForm({
    name: null,
    surname: null,
    email: null,
    book_number: null,
    book_date: null,
    msg_title: null,
    message: null,
    other_people: null,
    attachments: null,
});

onMounted(() => {
    if (categories.value.length > 0) {
        currentCategory.value = categories.value[0];
    }
});

watch(currentCategory, (n, o) => {
    files.value = n.files;
    if (n.name === "testimonios") {
        onCancel();
    }
});

const onCancel = () => {
    form.reset();
    showForm.value = false;
};
</script>

<style scope>
.ellipsis {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.q-item__label {
    line-height: 1.2em !important;
    max-width: 100%;
}
</style>
