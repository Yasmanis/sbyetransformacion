<template>
    <q-btn
        label="entrar"
        outline
        no-caps
        color="primary"
        href="/admin"
        v-if="authenticated"
    />

    <q-btn
        label="entrar"
        outline
        no-caps
        color="primary"
        @click="showDialog = true"
        v-else
    />

    <q-dialog v-model="showDialog" @hide="onHide">
        <q-card class="bg-primary" style="width: 800px; max-width: 80vw">
            <dialog-header-component
                icon="mdi-key"
                title="ACCESO ASBYETRANSFORMACION APP PARA FORMALIZAR TU COMPRA"
                closable
                class="text-white"
            />
            <q-card-section>
                <div class="row bg-white">
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-xl self-center text-center"
                    >
                        <form-register-component />
                    </div>
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-xl bg-primary"
                    >
                        <div class="column items-center">
                            <form-login-component />
                        </div>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import FormLoginComponent from "./FormLoginComponent.vue";
import FormRegisterComponent from "./FormRegisterComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "DialogAuthComponent",
});

const props = defineProps({
    show: Boolean,
});

const emits = defineEmits(["hide"]);

const showDialog = ref(false);

watch(
    () => props.show,
    (n) => {
        showDialog.value = n;
    }
);

const onHide = () => {
    usePage().props.errors = {};
    emits("hide");
};

const authenticated = computed(() => {
    return usePage().props.auth;
});
</script>
