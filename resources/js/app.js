import { createInertiaApp, router, usePage } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Quasar, Loading, Notify, QSpinnerFacebook, Dialog } from "quasar";
import quasarIconSet from "quasar/icon-set/svg-mdi-v6";
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
            .use(Quasar, {
                plugins: {
                    Loading,
                    Notify,
                    Dialog,
                },
                iconSet: quasarIconSet,
                config: {},
            })
            .mount(el);
    },
});

const page = usePage();

router.on("success", (event) => {
    setMessages();
});

router.on("error", (event) => {
    setMessages();
});

router.on("start", (event) => {
    const routes = [
        "/",
        "/consulta_individual",
        "/taller_online",
        "/publicaciones",
        "/contactame",
        "/contacts/store",
    ];
    if (!routes.includes(event.detail.visit.url.pathname)) {
        Loading.show({
            //spinner: QSpinnerFacebook,
            //spinnerColor: '#407492'
        });
    }
});

router.on("progress", (event) => { });

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
