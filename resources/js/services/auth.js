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
    Loading.show();
    location.href = "/logout";
};
