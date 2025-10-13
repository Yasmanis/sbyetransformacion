<template>
    <q-item clickable class="custom-item" @click="showDialog = true">
        <q-item-section avatar>
            <q-icon name="mdi-logout" />
        </q-item-section>
        <q-item-section class="text-lowercase">Salir</q-item-section>
        <q-tooltip-component
            title="Salir"
            anchor="center right"
            self="center left"
            class="text-lowercase bg-primary"
            v-if="mini"
        ></q-tooltip-component>
    </q-item>
    <q-dialog v-model="showDialog" persistent>
        <q-card style="width: 400px">
            <dialog-header-component
                icon="mdi-logout"
                title="cerrar sesion"
                closable
                :separator="false"
                @close="showDialog = false"
            />
            <q-card-section class="column items-center">
                <q-icon
                    :name="`img:${$page.props.public_path}images/icon/blue-ligth-alert.png`"
                    class="text-custom-blue"
                    size="160px"
                    style=""
                />
                <p style="font-size: 20px">estas seguro?</p>
                <p>confirma para cerrar la sesion</p>
            </q-card-section>
            <q-card-actions align="center">
                <q-btn-component
                    @click="logout"
                    tooltips="confirmar"
                    icon="mdi-checkbox-marked-circle-outline"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "./DialogHeaderComponent.vue";
import QBtnComponent from "../base/QBtnComponent.vue";
import QTooltipComponent from "./QTooltipComponent.vue";
import { logout } from "../../services/auth";

defineOptions({
    name: "SessionCloseComponent",
});

const props = defineProps({
    mini: {
        type: Boolean,
        default: false,
    },
});

const showDialog = ref(false);
</script>
