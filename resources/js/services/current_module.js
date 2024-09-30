import { usePage } from "@inertiajs/vue3";
export const currentModule = (route) => {
    const { applications_with_module, modules_doesnt_have_app } =
        usePage().props.auth.menu;
    for (let i = 0; i < applications_with_module.length; i++) {
        const modules = applications_with_module[i].modules;
        for (let j = 0; j < modules.length; j++) {
            if (modules[j].base_url === route) {
                return {
                    application: applications_with_module[i],
                    module: modules[j],
                };
            }
        }
    }
    for (let i = 0; i < modules_doesnt_have_app.length; i++) {
        if (modules_doesnt_have_app[i].base_url === route) {
            return {
                application: null,
                module: modules_doesnt_have_app[i],
            };
        }
    }
    return null;
};
