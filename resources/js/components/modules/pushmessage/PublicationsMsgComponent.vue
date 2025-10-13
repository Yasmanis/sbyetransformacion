<template>
    <q-dialog v-model="showDialog" persistent @show="emits('showing')">
        <q-card
            :style="{
                'min-width': !screen.xs ? '640px' : null,
            }"
            class="bg-custom-blue"
        >
            <dialog-header-component
                closable
                :separator="false"
                @close="showDialog = false"
            />
            <q-card-section class="q-pt-none" style="margin-top: -20px">
                <p class="text-center">
                    <b
                        >tienes mi libro? <br />
                        accede a mas contenido exclusivo!</b
                    >
                </p>
                <p class="text-center">
                    🎥 disfruta de todo el libro en video, leido por mi, dentro
                    del area privada <br />
                    📝 descarga plantillas y recursos para practicar
                    <br />📲 conectate con otras personas y accede a contenido
                    nuevo con el tiempo
                </p>
                <p class="text-center">
                    <span class="text-bold">🔑 para ingresar necesitas</span>
                    <br />
                    ✔️ nombre completo <br />✔️ email <br />✔️ datos de compra
                    (nombre del comprador, fecha, numero de pedido,
                    ticket/factura)
                </p>
                <p class="text-center">
                    📢 mas adelante, te pedire una reseña para ayudar a expandir
                    este mensaje
                </p>
                <p class="text-center">
                    <b>📌 solo una persona por compra puede registrarse</b>
                </p>
            </q-card-section>
            <q-card-actions align="center" class="q-mb-sm">
                <q-btn
                    no-caps
                    color="black"
                    label="me registro! "
                    padding="14px 25px"
                    @click="router.get('/contactame')"
                >
                </q-btn>
                <q-btn
                    no-caps
                    color="black"
                    padding="2px 25px"
                    @click="hideMsg"
                >
                    no volver a mostrar <br />
                    este mensaje
                </q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import { LocalStorage, useQuasar } from "quasar";
import { router } from "@inertiajs/vue3";

defineOptions({
    name: "PublicationsMsgComponent",
});

const emits = defineEmits(["showing"]);

const screen = computed(() => {
    return useQuasar().screen;
});

const showDialog = ref(false);

onMounted(() => {
    if (!LocalStorage.hasItem("hide_publications_push")) {
        LocalStorage.setItem("hide_publications_push", false);
    }
    if (!LocalStorage.getItem("hide_publications_push")) {
        showDialog.value = true;
    }
});

const hideMsg = () => {
    LocalStorage.setItem("hide_publications_push", true);
    showDialog.value = false;
};
</script>
