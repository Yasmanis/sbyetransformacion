<template>
    <btn-share-component>
        <q-menu style="max-width: 300px">
            <q-card flat>
                <q-card-section>
                    <q-input
                        v-model="fullPath"
                        type="textarea"
                        autogrow
                        readonly
                    >
                        <template #after>
                            <btn-copy-component @click="copy" />
                            <btn-show-hide-component
                                :public="false"
                                tooltips="vista en pagina"
                                @click="open"
                            />
                        </template>
                    </q-input>
                </q-card-section>
            </q-card>
        </q-menu>
    </btn-share-component>
</template>

<script setup>
import { ref, computed } from "vue";
import BtnShareComponent from "../btn/BtnShareComponent.vue";
import BtnCopyComponent from "../btn/BtnCopyComponent.vue";
import BtnShowHideComponent from "../btn/BtnShowHideComponent.vue";
import { copyToClipboard, openURL } from "quasar";
import { success, error500 } from "../../helpers/notifications";

defineOptions({
    name: "SharedLinkComponent",
});

const props = defineProps({
    url: {
        type: String,
        required: true,
    },
    params: Object,
});

const attributes = computed(() => {
    let params = props.params;
    for (const key in params) {
        params[key] = btoa(params[key]);
    }
    return params;
});

const fullPath = ref(route(props.url, attributes.value));

const copy = () => {
    copyToClipboard(fullPath.value)
        .then(() => {
            success("link copiado al portapapeles correctamente");
        })
        .catch(() => {
            error500();
        });
};

const open = () => {
    openURL(fullPath.value, undefined);
};
</script>
