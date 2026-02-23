import { usePage } from "@inertiajs/vue3";

const page = usePage();

export const modules = () => {
    return page.props.auth.menu.modules;
};

export const getActiveModule = () => {
    let url = page.url.split("?")[0];
    if (url.includes("?")) {
        url = url.split("?")[0];
    } else if (url.includes("#")) {
        url = url.split("#")[0];
    }
    const data = modules();
    let active = data.find((m) => m.base_url === url);
    return active;
};

export const getModuleFromUrl = (url) => {
    return modules().find((m) => m.base_url === url);
};

export const getChildrenFromParent = (parent) => {
    return modules().filter((m) => m.parent_id === parent.id);
};
