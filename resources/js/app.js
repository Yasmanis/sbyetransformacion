import "@quasar/extras/material-icons/material-icons.css";
import "@quasar/extras/mdi-v6/mdi-v6.css";
import "@quasar/extras/fontawesome-v6/fontawesome-v6.css";
import "@quasar/extras/animate/animate-list.js";
import "quasar/src/css/index.sass";
import "../css/app.css";
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
} from "quasar";
import quasarIconSet from "quasar/icon-set/svg-mdi-v6";
import lang from "quasar/lang/es";
import { createApp, h } from "vue";
import permissions from "./plugins/permissions";
import VueGates from "vue-gates";
import { ZiggyVue } from "ziggy-js";
import { success, error, errorValidation } from "./helpers/notifications";
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
