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
                                        !!rules.email(val) || 'email no valido',
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
                                        @click="fileRef.removeAtIndex(index)"
                                    >
                                        <q-tooltip>quitar adjunto</q-tooltip>
                                    </q-btn>
                                </q-item-section>
                                <q-item-section class="text-white">
                                    <q-item-label>{{ f.name }}</q-item-label>
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
                @click="checkAuth"
                v-if="!showForm"
            />
        </q-card>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";
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

const fileRef = ref(null);

const formRef = ref(null);

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

const checkAuth = () => {
    showForm.value = true;
    // if (usePage().props.auth) {
    //     showForm.value = true;
    // } else {
    //     $q.notify({
    //         progress: true,
    //         position: "top-right",
    //         timeout: 20000,
    //         multiLine: true,
    //         textColor: "black",
    //         color: "white",
    //         badgeClass: "bg-custom-blue",
    //         badgeTextColor: "dark",
    //         type: "info",
    //         message: `para subir tu testimonio debes ser usuario registrado. inicia sesion en el <a href="/login">area privada</a> o registrate en <a href="/contactame">contactame</a>`,
    //         html: true,
    //         actions: [
    //             {
    //                 icon: "mdi-close-circle-outline",
    //                 color: "black",
    //                 handler: () => {
    //                     /* ... */
    //                 },
    //             },
    //         ],
    //     });
    // }
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
