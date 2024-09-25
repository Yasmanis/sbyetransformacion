import { useForm } from "@inertiajs/vue3";
import { Dialog, Loading } from "quasar";
export const login = (email, password, rememberme) => {
    const form = useForm({
        email: email,
        password: password,
        rememberme: rememberme,
    });
    form.post("authenticate");
};
export const logout = () => {
    Dialog.create({
        title: "confirmar",
        message:
            "<i class='fas fa-sign-out-alt'></i> seguro que deseas cerrar la sesion?",
        cancel: true,
        persistent: true,
        html: true,
        cancel: {
            label: "cancelar",
            icon: "mdi-close",
        },
        ok: {
            color: "red",
            icon: "mdi-check",
        },
    }).onOk(() => {
        Loading.show();
        location.href = "/logout";
    });
};
