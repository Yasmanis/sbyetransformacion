<template>
    <Layout>
        <q-page padding>
            <div class="row items-center q-mb-md" v-if="user">
                <div class="col">
                    <q-item class="no-padding">
                        <q-item-section avatar>
                            <btn-msg-component color="white" tooltips="chat" />
                        </q-item-section>
                        <q-item-section avatar>
                            <documents-component />
                        </q-item-section>
                        <q-item-section avatar>
                            <book-info-component
                                color="white"
                                :object="user"
                                :has_edit="has_edit"
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <progress-component
                                color="white"
                                :object="user"
                            /> </q-item-section
                        ><q-item-section
                            avatar
                            v-if="has_edit && user.name !== 'sa'"
                        >
                            <lock-unlock-component
                                color="white"
                                :object="user"
                            />
                        </q-item-section>
                        <q-item-section avatar v-if="has_edit">
                            <change-password-component
                                color="white"
                                :object="user"
                            />
                        </q-item-section>
                        <q-item-section avatar>
                            <btn-reply-component
                                color="white"
                                tooltips="volver a usuarios"
                                @click="back"
                            />
                        </q-item-section>
                    </q-item>
                </div>
                <div class="col col-auto text-right">
                    <q-item style="padding: 0">
                        <q-item-section avatar>
                            <q-item-label class="text-white">
                                {{ user.full_name }}
                            </q-item-label>
                        </q-item-section>
                        <q-item-section avatar side style="padding: 0">
                            <form-avatar :user="user" size="60px" />
                        </q-item-section>
                    </q-item>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <user-card-component
                        :has-edit="has_edit"
                        :has-delete="has_delete"
                        :user="user"
                        :buyer="buyer"
                    />
                </div>
            </div>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import BookInfoComponent from "../../components/modules/user/BookInfoComponent.vue";
import ProgressComponent from "../../components/modules/user/ProgressComponent.vue";
import LockUnlockComponent from "../../components/modules/user/LockUnlockComponent.vue";
import ChangePasswordComponent from "../../components/modules/user/ChangePasswordComponent.vue";
import UserCardComponent from "../../components/modules/user/UserCardComponent.vue";
import BtnReplyComponent from "../../components/btn/BtnReplyComponent.vue";
import BtnMsgComponent from "../../components/btn/BtnMsgComponent.vue";
import FormAvatar from "../../components/auth/FormAvatar.vue";
import DocumentsComponent from "../../components/modules/user/DocumentsComponent.vue";
import { computed, onMounted, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { modules } from "../../services/current_module";

defineOptions({
    name: "UserCard",
});

const user = computed(() => {
    return usePage().props.user ?? null;
});

const buyer = computed(() => {
    return usePage().props.buyer ?? null;
});

const current_module = ref(null);

const has_edit = ref(false);
const has_delete = ref(false);

onMounted(() => {
    const data = modules();
    current_module.value = data.find((m) => m.model === "User");
    const permissions = current_module.value.permissions.map((p) => p.name);
    const modelName = current_module.value.model.toLowerCase();
    has_edit.value = permissions.includes(`edit_${modelName}`);
    has_delete.value = permissions.includes(`delete_${modelName}`);
});

const back = () => {
    router.visit("/admin/users", {
        method: "get",
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
