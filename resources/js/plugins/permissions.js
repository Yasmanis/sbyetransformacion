import { usePage } from "@inertiajs/vue3";
export default {
    install: (app) => {
        app.mixin({
            mounted() {
                const props = usePage().props;
                if (props && props.auth) {
                    //this.$gates.setRoles(authRoles);
                    this.$gates.setPermissions(props.auth.permissions);
                }
            },
        });
    },
};
