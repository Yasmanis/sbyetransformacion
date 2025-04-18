<template>
    <q-btn
        label="entrar"
        outline
        no-caps
        color="primary"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" @hide="onHide">
        <q-card style="width: 800px; max-width: 80vw">
            <dialog-header-component
                icon="mdi-key"
                title="ACCESO A SBYE DIETAPP PARA FORMALIZAR TU COMPRA"
                closable
            />
            <q-card-section>
                <div class="row bg-teal-11">
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-xl self-center text-center"
                    >
                        <form-register-component />
                    </div>
                    <div
                        class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 q-pa-xl bg-white"
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
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import FormLoginComponent from "./FormLoginComponent.vue";
import FormRegisterComponent from "./FormRegisterComponent.vue";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "DialogAuthComponent",
});
const showDialog = ref(false);

const onHide = () => {
    usePage().props.errors = {};
};
</script>
