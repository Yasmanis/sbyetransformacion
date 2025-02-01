<template>
    <Layout title="contactame">
        <div class="row container bg-primary items-center q-pa-md">
            <div class="col-lg-5 col-md-5 text-center">
                <img
                    :src="`${$page.props.public_path}images/team/maria-contacto.png`"
                    style="width: 80%"
                />
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="column self-center">
                    <p
                        class="text-white"
                        :style="{
                            'margin-top': screen.xs || screen.sm ? '-40px' : '',
                        }"
                    >
                        si quieres registrarte en el area privada no olvides
                        cubrir todos los campos para que podamos comprobar y
                        darte de alta
                    </p>
                    <q-form ref="formRef" greedy>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                                    :class="!screen.xs ? 'q-mr-xs' : ''"
                                    :rules="[(val) => !!val || 'requerido']"
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
                                    :class="!screen.xs ? 'q-ml-xs' : ''"
                                    :rules="[(val) => !!val || 'requerido']"
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
                                        (val) => !!val || 'requerido',
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
                                    :rules="[(val) => !!val || 'requerido']"
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
                                    :rules="[(val) => !!val || 'requerido']"
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
                            <div
                                class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11 q-mt-md text-white"
                            >
                                <q-checkbox
                                    v-model="contactPrivateArea"
                                    color="white"
                                    checked-icon="mdi-circle"
                                    dense
                                    label="contacto para que me deis de alta en el
                                                area privada"
                                />
                            </div>
                            <div
                                class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 text-right q-mt-lg"
                            >
                                <div class="column items-end">
                                    <q-icon
                                        :name="`img:${$page.props.public_path}images/icon/info.png`"
                                    >
                                        <q-tooltip
                                            anchor="center right"
                                            self="center left"
                                            class="bg-white text-black"
                                            style="
                                                width: 260px;
                                                font-size: 13px;
                                            "
                                        >
                                            <p>
                                                vete al area de pedidos de
                                                amazon a visualizar el pedido de
                                                tu libro, ahi tendras la fecha
                                                de compra y el numero de pedido.
                                                si no lo has comprado tu y, por
                                                ejemplo, ha sido un regalo, pide
                                                el ticket regalo para ver estos
                                                datos. y si no consigues ver los
                                                datos que te pedimos adjuntanos
                                                una foto del ticket y lo
                                                miraremos por ti. en este caso
                                                cubre con
                                                <b class="text-black"
                                                    >no lo se</b
                                                >
                                                los campos requeridos
                                            </p>
                                        </q-tooltip>
                                    </q-icon>
                                </div>
                            </div>
                            <div
                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                v-if="contactPrivateArea"
                            >
                                <i
                                    class="mdi mdi-asterisk text-red"
                                    style="margin-left: 455px"
                                    v-if="!form.book_number"
                                />
                                <q-input
                                    v-model="form.book_number"
                                    type="text"
                                    name="book_number"
                                    placeholder="numero de pedido de amazon por la compra del libro"
                                    dense
                                    rounded
                                    outlined
                                    bg-color="white"
                                    required
                                    :rules="[(val) => !!val || 'requerido']"
                                    hide-bottom-space
                                />
                            </div>
                            <div
                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                v-if="contactPrivateArea"
                            >
                                <i
                                    class="mdi mdi-asterisk text-red"
                                    style="margin-left: 225px"
                                    v-if="!form.book_date"
                                />
                                <q-input
                                    v-model="form.book_date"
                                    :type="book_date"
                                    name="book_date"
                                    placeholder="fecha de compra del libro"
                                    required
                                    dense
                                    rounded
                                    outlined
                                    bg-color="white"
                                    @focus="onFocusDate"
                                    @blur="onBlurDate"
                                    :rules="[(val) => !!val || 'requerido']"
                                    hide-bottom-space
                                />
                            </div>
                            <div
                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                v-if="contactPrivateArea"
                            >
                                <i
                                    class="mdi mdi-asterisk text-red"
                                    style="margin-left: 58px"
                                    v-if="!form.ticket"
                                />
                                <q-file
                                    v-model="form.ticket"
                                    ref="fileTicket"
                                    name="ticket"
                                    dense
                                    rounded
                                    outlined
                                    :label="form.ticket ? null : 'ticket'"
                                    bg-color="white"
                                    :input-style="{ 'margin-top': '-10px' }"
                                    required
                                    :rules="[(val) => !!val || 'requerido']"
                                    hide-bottom-space
                                    accept="image/*, .pdf"
                                    @rejected="onRejected"
                                >
                                    <template v-slot:append>
                                        <q-btn
                                            flat
                                            dense
                                            rounded
                                            icon="mdi-file-image-outline"
                                            @click="showExplorerTicket"
                                        /> </template
                                ></q-file>
                            </div>
                            <div
                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                            >
                                <q-checkbox
                                    v-model="iAmNot"
                                    color="white"
                                    checked-icon="mdi-circle"
                                    dense
                                >
                                    <span class="text-white"
                                        >la persona que aparece en el ticket no
                                        soy yo</span
                                    >
                                </q-checkbox>
                            </div>
                            <div
                                class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 q-mt-md"
                                v-if="iAmNot"
                            >
                                <i
                                    class="mdi mdi-asterisk text-red"
                                    style="margin-left: 410px"
                                    v-if="!form.other_people"
                                />
                                <q-input
                                    v-model="form.other_people"
                                    type="text"
                                    name="other_people"
                                    placeholder="nombre de la persona que aparece en el pedido"
                                    dense
                                    rounded
                                    outlined
                                    bg-color="white"
                                    required
                                    :rules="[(val) => !!val || 'requerido']"
                                    hide-bottom-space
                                />
                            </div>
                        </div>
                        <div
                            class="row q-pt-md"
                            v-if="form.attachments?.length > 0"
                        >
                            <q-list dense>
                                <q-item class="q-ma-none" style="padding: 0">
                                    <q-item-section
                                        avatar
                                        class="q-pa-none"
                                        style="min-width: 30px"
                                        v-if="form.attachments?.length > 1"
                                    >
                                        <q-btn
                                            flat
                                            icon="fa fa-times-circle"
                                            color="red"
                                            padding="0"
                                            @click="form.attachments = null"
                                        >
                                            <q-tooltip
                                                >quitar todos los
                                                adjuntos</q-tooltip
                                            >
                                        </q-btn>
                                    </q-item-section>
                                    <q-item-section class="text-white">
                                        <q-item-label>adjuntos</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-separator color="white"></q-separator>
                                <q-item
                                    v-for="(f, index) in form.attachments"
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
                                                fileRef.removeAtIndex(index)
                                            "
                                        >
                                            <q-tooltip
                                                >quitar adjunto</q-tooltip
                                            >
                                        </q-btn>
                                    </q-item-section>
                                    <q-item-section class="text-white">
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
                            label="enviar"
                            no-caps
                            :disabled="sending"
                            :loading="sending"
                            class="q-mt-md"
                            @click="onSubmit"
                        >
                            <q-icon
                                name="fa fa-long-arrow-right"
                                class="q-ml-md"
                            />
                        </q-btn>
                    </q-form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { ref, watch, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useQuasar } from "quasar";
import { error, errorValidation } from "../../helpers/notifications.js";
defineOptions({
    name: "Contactos",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const fileRef = ref(null);
const fileTicket = ref(null);

const formRef = ref(null);

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
    ticket: null,
});

const openTiket = ref(false);

const book_date = ref("text");

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

const onRejected = () => {
    error("fichero no admitido, solo se permiten imagenes y documentos pdf");
};

const showExplorerTicket = () => {
    openTiket.value = true;
    fileTicket.value.pickFiles();
};

const onSubmit = () => {
    formRef.value.validate().then((success) => {
        if (success) {
            sending.value = true;
            form.post("/contacts/store", {
                preserveScroll: true,
                onSuccess: () => {
                    sending.value = false;
                    iAmNot.value = false;
                    contactPrivateArea.value = false;
                    book_date.value = "text";
                    form.reset();
                    formRef.value.reset();
                },
                onError: () => {
                    sending.value = false;
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
<style scope>
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
</style>
