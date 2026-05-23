<template>
    <q-btn-component
        :icon="`img:${$page.props.public_path}images/icon/white-comunication.png`"
        tooltips="tickets"
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog" persistent @hide="tab = 'progress'">
        <q-card style="width: 800px; max-width: 90vw">
            <dialog-header-component
                :icon="`img:${$page.props.public_path}images/icon/${Dark.isActive ? 'white' : 'black'}-comunication.png`"
                title="tickets"
                closable
                @close="showDialog = false"
            />
            <q-card-section style="max-height: 50vh" class="scroll q-pa-none">
                <tikets-component />
            </q-card-section>
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import { Dark } from "quasar";
import BtnFilesFolderComponent from "../../btn/BtnFilesFolderComponent.vue";
import CommentsComponent from "./CommentsComponent.vue";
import TiketsComponent from "../../auth/TiketsComponent.vue";
import axios from "axios";

defineOptions({
    name: "DialogTiketsComponent",
});

const showDialog = ref(false);
</script>
