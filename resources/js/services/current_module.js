import { usePage } from "@inertiajs/vue3";

const page = usePage();

export const modules = () => {
    return page.props.auth.menu.modules;
};

export const getActiveModule = () => {
    const url = page.url.split("?")[0];
    const data = modules();
    return data.find((m) => m.base_url === url);
};
