<template>
    <Layout>
        <section class="banner page-banner position-relative pb-0">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-title text-center position-relative py-5">
                    <p class="text-white text-uppercase header-title">
                        contactame
                    </p>
                </div>
            </div>
        </section>
        <section class="contact bg-company pb-2 pt-2">
            <div class="container">
                <div class="contact-inner text-center text-md-start">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 text-center">
                            <img
                                :src="`${$page.props.public_path}images/team/maria-contacto.png`"
                                class="w-100"
                                style="
                                    margin-top: -60px;
                                    margin-left: -50px;
                                    margin-bottom: -40px;
                                "
                            />
                        </div>
                        <div class="col-lg-7 col-md-7">
                            <div class="contact-form">
                                <div
                                    class="alert alert-info alert-dismissible fade show"
                                    role="alert"
                                    v-if="flash_success"
                                >
                                    {{ flash_success }}
                                    <button
                                        type="button"
                                        class="btn-close"
                                    ></button>
                                </div>
                                <div
                                    class="alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                    v-if="$page.props.flash_error"
                                >
                                    {{ $page.props.flash_error }}
                                    <button
                                        type="button"
                                        class="btn-close"
                                    ></button>
                                </div>

                                <div class="form-title mb-4">
                                    <p class="text-white">
                                        si quieres registrarte en el area
                                        privada no olvides cubrir todos los
                                        campos para que podamos comprobar y
                                        darte de alta
                                    </p>
                                </div>
                                <div class="form">
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
                                                    v-model="form.surname"
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
                                                    form?.attachments?.length >
                                                    0
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
                                        <div
                                            class="radio mt-0 mb-2 radio-not-found"
                                            style="
                                                text-align: left;
                                                cursor: pointer;
                                            "
                                        >
                                            <i
                                                class="fa text-white"
                                                :class="
                                                    contactPrivateArea
                                                        ? 'fa-circle'
                                                        : 'fa-circle-o'
                                                "
                                                style="
                                                    font-size: 18px;
                                                    cursor: pointer;
                                                "
                                                @click="
                                                    contactPrivateArea =
                                                        !contactPrivateArea
                                                "
                                            ></i>
                                            <label
                                                class="text-white"
                                                style="cursor: pointer"
                                                @click="
                                                    contactPrivateArea =
                                                        !contactPrivateArea
                                                "
                                                >&nbsp;contacto para que me deis
                                                de alta en el area
                                                privada</label
                                            >
                                            <a
                                                class="popover"
                                                tabindex="0"
                                                role="button"
                                                data-bs-toggle="popover"
                                                data-bs-content="vete al area de pedidos de amazon a visualizar el pedido de tu libro, ahi tendras la fecha de compra y el numero de pedido. si no lo has comprado tu y, por ejemplo, ha sido un regalo, pide el ticket regalo para ver estos datos. y si no consigues ver los datos que te pedimos adjuntanos una foto del ticket y lo miraremos por ti. en este caso cubre con “no lo se” los campos requeridos"
                                                style="
                                                    float: right;
                                                    background-color: transparent;
                                                    border: none;
                                                "
                                                ><img
                                                    :src="`${$page.props.public_path}images/icon/info.png`"
                                            /></a>
                                        </div>
                                        <div
                                            class="pedido"
                                            style="text-align: left"
                                            v-if="contactPrivateArea"
                                        >
                                            <input
                                                v-model="form.book_number"
                                                type="text"
                                                name="book_number"
                                                placeholder="numero de pedido de amazon por la compra del libro"
                                                class="mb-3"
                                                required
                                            />
                                            <img
                                                :src="`${$page.props.public_path}images/icon/aster.png`"
                                                style="
                                                    width: 8px;
                                                    margin-top: -40px;
                                                    margin-left: 420px;
                                                    contain: content;
                                                    float: left;
                                                    opacity: 0.6;
                                                "
                                                v-if="!form.book_number"
                                            />
                                            <input
                                                v-model="form.book_date"
                                                :type="book_date"
                                                name="book_date"
                                                placeholder="fecha de compra del libro"
                                                required
                                                class="mb-3"
                                                @focus="onFocusDate"
                                                @blur="onBlurDate"
                                            />
                                            <img
                                                :src="`${$page.props.public_path}images/icon/aster.png`"
                                                style="
                                                    width: 8px;
                                                    margin-top: -40px;
                                                    margin-left: 211px;
                                                    contain: content;
                                                    float: left;
                                                    opacity: 0.6;
                                                "
                                                v-if="
                                                    !form.book_date &&
                                                    book_date === 'text'
                                                "
                                            />
                                        </div>
                                        <div
                                            class="radio mt-0 mb-2 radio-not-found"
                                            style="text-align: left"
                                            @click="iAmNot = !iAmNot"
                                        >
                                            <i
                                                class="fa text-white"
                                                :class="
                                                    iAmNot
                                                        ? 'fa-circle'
                                                        : 'fa-circle-o'
                                                "
                                                style="
                                                    font-size: 18px;
                                                    cursor: pointer;
                                                "
                                            ></i>
                                            <label
                                                for="radio"
                                                class="text-white"
                                                style="cursor: pointer"
                                                >&nbsp;la persona que aparece en
                                                el ticket no soy yo</label
                                            >
                                        </div>
                                        <div v-if="iAmNot">
                                            <input
                                                v-model="form.other_people"
                                                type="text"
                                                name="other_people"
                                                placeholder="nombre de la persona que aparece en el pedido"
                                                class="mb-3"
                                                required
                                            />
                                            <img
                                                :src="`${$page.props.public_path}images/icon/aster.png`"
                                                style="
                                                    width: 8px;
                                                    margin-top: -40px;
                                                    margin-left: 380px;
                                                    contain: content;
                                                    float: left;
                                                    opacity: 0.6;
                                                "
                                                v-if="!form.other_people"
                                            />
                                        </div>
                                        <button
                                            class="btn"
                                            type="submit"
                                            :disabled="sending"
                                        >
                                            enviar<i
                                                class="fa fa-long-arrow-right ms-3"
                                            ></i>
                                        </button>
                                    </form>
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
import Layout from "../../layouts/MainLayout.vue";
import { ref, onMounted, watch, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
defineOptions({
    name: "Contactos",
});

const contactPrivateArea = ref(false);
const iAmNot = ref(false);
const sending = ref(false);
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

const book_date = ref("text");

const page = usePage();

const flash_success = computed(() => {
    return page.props.flash_success;
});

onMounted(() => {
    $(document).ready(function () {
        new bootstrap.Popover(document.querySelector(".popover"), {
            container: "body",
            trigger: "focus",
        });
    });
});

watch(contactPrivateArea, (n, o) => {
    form.reset("book_number");
    form.reset("book_date");
});

watch(iAmNot, (n, o) => {
    form.reset("other_people");
});

const onFocusDate = () => {
    book_date.value = "date";
};

const onBlurDate = () => {
    book_date.value = form.book_date ? "date" : "text";
};

const setHideAlert = () => {
    $(".btn-close").on("click", function (ev) {
        ev.preventDefault();
        page.props.flash_error = null;
        page.props.flash_success = null;
    });
};

const onSubmit = () => {
    sending.value = true;
    form.post("/contacts/store", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            sending.value = false;
            iAmNot.value = false;
            contactPrivateArea.value = false;
            book_date.value = "text";
            setHideAlert();
        },
        onError: () => {
            sending.value = false;
            setHideAlert();
        },
    });
};
</script>
<style scope>
.btn:disabled {
    color: #ffffff !important;
}
.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: 0.25em 0.25em;
    color: #000;
    border: 0;
    border-radius: 0.25rem;
    opacity: 0.5;
}
</style>
