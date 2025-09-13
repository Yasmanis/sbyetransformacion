import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/mdi-v6/mdi-v6.css";
import "@quasar/extras/fontawesome-v6/fontawesome-v6.css";
import "@quasar/extras/animate/animate-list.js";
import "@quasar/extras/animate/fadeInLeft.css";
import "quasar/src/css/index.sass";
import "../css/app.css";
import "animate.css";
import { createInertiaApp, router, usePage } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { CkeditorPlugin } from "@ckeditor/ckeditor5-vue";
import {
    Quasar,
    Loading,
    Notify,
    QSpinnerFacebook,
    Dialog,
    Meta,
    AppFullscreen,
    date,
} from "quasar";
import quasarIconSet from "quasar/icon-set/svg-mdi-v6";
import lang from "quasar/lang/es";
import { createApp, h } from "vue";
import permissions from "./plugins/permissions";
import VueGates from "vue-gates";
import { ZiggyVue } from "ziggy-js";
import { success, error, errorValidation } from "./helpers/notifications";
import * as PusherPushNotifications from "@pusher/push-notifications-web";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import Swal from "sweetalert2";
import axios from "axios";
createInertiaApp({
    title: (title) => "SBYE-transformacion",
    progress: false,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob("./pages/**/*.vue")
        ),

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueGates)
            .use(permissions)
            .use(ZiggyVue)
            .use(CkeditorPlugin)
            .use(Quasar, {
                plugins: {
                    Loading,
                    Notify,
                    Dialog,
                    Meta,
                    AppFullscreen,
                },
                iconSet: quasarIconSet,
                lang: lang,
            })
            .mount(el);
        setTimeout(() => {
            document.getElementById("app").removeAttribute("data-page");
        }, 0);
    },
});

const page = usePage();

router.on("success", (event) => {
    if (!router.page.props.exclude_flash) {
        setMessages();
    }
});

router.on("error", (event) => {
    setMessages();
});

router.on("start", (event) => {
    const routes = [
        // "/",
        // "/consulta_individual",
        // "/taller_online",
        // "/publicaciones",
        // "/contactame",
        //"/contacts/store",
        "/admin/schooltopics/update-video-percentaje-to-user",
    ];
    if (!routes.includes(event.detail.visit.url.pathname)) {
        Loading.show();
    }
});

router.on("progress", (event) => {});

router.on("finish", (event) => {
    Loading.hide();
});

const setMessages = () => {
    if (page.props.flash_error) {
        error(page.props.flash_error);
    } else if (page.props.flash_success) {
        success(page.props.flash_success);
    } else if (Object.keys(page.props.errors).length > 0) {
        errorValidation();
    }
};

var pusher = new Pusher("e63f90f776ecf0234b4e", {
    cluster: "us2",
    channelAuthorization: {
        endpoint: "/pusher/auth",
    },
    // userAuthentication: {
    //     endpoint: "/pusher/user-auth",
    // },
});

var channel = pusher.subscribe("my-channel");

channel.bind("pusher:subscription_succeeded", () => {
    console.log("subscription_succeeded");
});

channel.bind("pusher:subscription_error", (error) => {
    console.log("subscription_error", error);
});

channel.bind("my-event", function (data) {
    let auth = page.props.auth;
    if (auth) {
        showPush(data);
    }
});

const showPush = (data) => {
    if (!("Notification" in window)) {
        Notify.create({
            message: "este navegador no soporta notificaciones",
            position: "top-right",
            color: "negative",
            timeout: 0,
            actions: [
                {
                    label: "cerrar",
                    color: "white",
                    handler: () => {
                        // Acción al cerrar la notificación
                    },
                },
            ],
        });
    } else if (Notification.permission === "granted") {
        showAlert(data);
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission(function (permission) {
            if (permission === "granted") {
                showAlert(data);
            }
        });
    }
};

const showAlert = (data) => {
    // Swal.fire({
    //     title: data.title,
    //     text: data.text,
    //     icon: data.icon,
    //     confirmButtonText: "ok",
    //     position: "top-end",
    // });

    Notify.create({
        message: `${data.title} <br> ${data.text}`,
        position: "top-right",
        color: "negative",
        html: true,
        timeout: 0,
        caption: date.formatDate(new Date(data.sent_at), "MMMM DD, YYYY"),
        avatar: "https://cdn.quasar.dev/img/boy-avatar.png",
        actions: [
            {
                icon: "close",
                color: "white",
                handler: () => {
                    // Acción al cerrar la notificación
                },
            },
        ],
    });

    Notify.create({
        message: `${data.title} <br> ${data.text}`,
        position: "top-right",
        html: true,
        timeout: 0,
        caption: "hace 2 minutos",
        avatar: "https://cdn.quasar.dev/img/boy-avatar.png",
        actions: [
            {
                icon: "close",
                color: "white",
                handler: () => {
                    // Acción al cerrar la notificación
                },
            },
        ],
    });
};
