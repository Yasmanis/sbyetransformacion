<template>
    <q-dialog v-model="showDialog" persistent @show="emits('showing')">
        <q-card
            :style="{
                'min-width': screen.lg || screen.md ? '750px' : null,
            }"
            class="bg-custom-blue"
        >
            <dialog-header-component
                closable
                :separator="false"
                @close="showDialog = false"
            />
            <q-card-section class="q-pt-none" style="margin-top: -10px">
                <p class="text-center">
                    cada mes explorare un aspecto clave de mi libro de forma
                    simple y profunda, para que lo mas importante se quede
                    contigo
                </p>
                <p class="text-center">
                    📌 como lo hare?<br />
                    ✨️ publicaciones en la seccion <i>posts</i> <br />
                    📩 newsletter en email y <i>video-news</i>, disponible
                    despues en <i>newsletter</i> <br />
                    🎥 conferencia online, que luego podras ver en
                    <i>conferencias</i>
                </p>
                <p class="text-center">
                    cada recurso te dara una perspectiva unica para que integres
                    el mensaje con facilidad
                </p>
                <p class="text-center">
                    📲 activa las notificaciones push y no te pierdas nada
                </p>
            </q-card-section>
            <q-card-actions align="center" class="q-mb-sm">
                <q-btn
                    no-caps
                    color="black"
                    label="avisame!"
                    padding="8px 25px"
                    @click="subscribe"
                >
                </q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import { useQuasar } from "quasar";
import { router, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "PrivateAreaMsgComponent",
});

const emits = defineEmits(["showing"]);

const screen = computed(() => {
    return useQuasar().screen;
});

const showDialog = ref(false);

const page = usePage();

onMounted(() => {
    if (!page.props.auth.user.subscripted && page.props.show_msg_subscription) {
        showDialog.value = true;
    }
});

const subscribe = () => {
    router.post(
        "/auth/subscribe",
        {},
        {
            onSuccess: () => (showDialog.value = false),
        }
    );
};
</script>
