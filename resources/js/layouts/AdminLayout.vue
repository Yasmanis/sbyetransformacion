<template>
    <q-layout view="lHh Lpr lFf">
        <q-header>
            <q-toolbar
                :style="{ background: Dark.isActive ? '#1d1d1d' : '#407492' }"
            >
                <q-btn
                    flat
                    dense
                    round
                    icon="menu"
                    aria-label="Menu"
                    @click="toggleLeftDrawer"
                />

                <img
                    :src="`${$page.props.public_path}images/logo/1.png`"
                    style="width: 90px"
                    v-if="mini && !leftDrawerOpen"
                />
                <q-toolbar-title />

                <q-btn-component
                    icon="reply_all"
                    tooltips="volver a"
                    color="white"
                    class="q-mr-sm"
                >
                    <q-menu
                        style="min-width: 300px"
                        transition-show="scale"
                        transition-hide="scale"
                    >
                        <q-list separator>
                            <q-item
                                clickable
                                v-for="(l, indexItem) in links"
                                :key="`index-item-${indexItem}`"
                                :href="l.url"
                            >
                                <q-item-section>{{ l.title }}</q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn-component>

                <notifications-list-component />

                <q-btn-component color="white" class="q-mr-sm">
                    <q-avatar size="md" class="shadow-4"
                        ><img
                            :src="`${$page.props.public_path}${
                                user.avatar
                                    ? `storage/${user.avatar}`
                                    : `images/icon/profile.svg`
                            }`"
                    /></q-avatar>
                    <q-menu
                        style="width: 240px"
                        transition-show="scale"
                        transition-hide="scale"
                    >
                        <q-card>
                            <q-card-section class="q-pa-none">
                                <q-list dense>
                                    <q-item>
                                        <q-item-section avatar>
                                            <q-avatar
                                                size="lg"
                                                class="shadow-10"
                                                ><img
                                                    :src="`${
                                                        $page.props.public_path
                                                    }${
                                                        user.avatar
                                                            ? `storage/${user.avatar}`
                                                            : `images/icon/profile.svg`
                                                    }`"
                                            /></q-avatar>
                                        </q-item-section>
                                        <q-item-section class="q-py-sm">
                                            <q-item-label lines="1">
                                                {{ user.full_name }}
                                            </q-item-label>
                                            <q-item-label caption lines="1">
                                                {{ user.email }}
                                            </q-item-label>
                                        </q-item-section>
                                        <q-item-section avatar side>
                                            <DarkSwitcher
                                                class="z-max"
                                                size="md"
                                                colorDark="black"
                                                colorLight="white"
                                            />
                                        </q-item-section>
                                    </q-item>
                                    <q-separator />
                                    <q-item
                                        clickable
                                        @click="router.get('/auth/profile')"
                                    >
                                        <q-item-section avatar>
                                            <q-icon
                                                name="mdi-account-outline"
                                            /> </q-item-section
                                        ><q-item-section>
                                            <q-item-label>
                                                perfil
                                            </q-item-label>
                                        </q-item-section>
                                    </q-item>
                                    <q-item
                                        clickable
                                        @click="showPasswordDialog = true"
                                    >
                                        <q-item-section avatar>
                                            <q-icon
                                                name="mdi-key-outline"
                                            /> </q-item-section
                                        ><q-item-section>
                                            <q-item-label>
                                                cambiar contraseña
                                            </q-item-label>
                                        </q-item-section>
                                    </q-item>
                                    <q-separator />
                                    <session-close-component />
                                </q-list>
                            </q-card-section>
                        </q-card>
                    </q-menu>
                </q-btn-component>
            </q-toolbar>
            <q-toolbar
                :style="{
                    background: Dark.isActive ? '#1d1d1d' : '#407492',
                    'min-height': '30px !important',
                    padding: '0px',
                }"
            >
                <q-toolbar-title></q-toolbar-title>
                <contact-component />
            </q-toolbar>
        </q-header>

        <q-drawer
            :class="Dark.isActive ? '' : 'bg-primary text-white'"
            v-model="leftDrawerOpen"
            show-if-above
            :mini="true"
            v-if="mini"
        >
            <menu-component
                @change-url="(nav) => (currentNav = nav)"
                :mini="true"
            />
        </q-drawer>

        <q-drawer
            :class="Dark.isActive ? '' : 'bg-primary text-white'"
            v-model="leftDrawerOpen"
            show-if-above
            v-else
        >
            <menu-component @change-url="(nav) => (currentNav = nav)" />
        </q-drawer>

        <q-page-container :class="Dark.isActive ? '' : 'bg-primary'">
            <slot />
        </q-page-container>

        <q-footer>
            <q-toolbar :class="Dark.isActive ? 'bg-dark' : ''">
                <q-toolbar-title>
                    <span class="text-body1 text-white"
                        >©2024 sbye salud s.l.
                    </span></q-toolbar-title
                >
                <q-btn-component
                    size="md"
                    href="https://www.facebook.com/profile.php?id=61563937152210"
                    target="blank"
                    color="white"
                    padding="8px"
                >
                    <q-icon name="fab fa-facebook-f" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    style="margin-left: 10px; margin-right: 10px"
                    href="https://www.youtube.com/@sbyetransformacion"
                    target="blank"
                    color="white"
                    padding="8px"
                >
                    <q-icon name="fab fa-youtube" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    style="margin-right: 10px"
                    href="https://www.instagram.com/sbyetransformacion/"
                    target="blank"
                    color="white"
                    padding="8px"
                >
                    <q-icon name="fab fa-instagram" size="xs" />
                </q-btn-component>
                <q-btn-component
                    size="md"
                    href="https://www.tiktok.com/@sbyetransformacion"
                    target="blank"
                    color="white"
                    padding="8px"
                >
                    <q-icon name="fab fa-tiktok" size="xs" />
                </q-btn-component>
            </q-toolbar>
        </q-footer>
    </q-layout>

    <q-dialog v-model="showPasswordDialog" persistent>
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-account-key-outline"
                title="cambiar mi contraseña"
                closable
            />
            <q-card-section class="col q-pt-none">
                <q-form class="q-gutter-sm q-mt-sm" ref="formPassword" greedy>
                    <password-field
                        label="nueva contraseña"
                        name="password"
                        :othersProps="{ required: true }"
                        oldPassword
                        @update="onUpdateField"
                        @confirm="onUpdateField"
                        @old-password="onUpdateField"
                    />
                </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-save-component @click="changePassword" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showPasswordDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <private-area-msg-component />
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import MenuComponent from "../components/navigation/MenuComponent.vue";
import DarkSwitcher from "../components/profile/DarkSwitcher.vue";
import QBtnComponent from "../components/base/QBtnComponent.vue";
import NotificationsListComponent from "../components/notification/NotificationsListComponent.vue";
import ContactComponent from "../components/others/ContactComponent.vue";
import SessionCloseComponent from "../components/base/SessionCloseComponent.vue";
import DialogHeaderComponent from "../components/base/DialogHeaderComponent.vue";
import PasswordField from "../components/form/input/PasswordField.vue";
import BtnSaveComponent from "../components/btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../components/btn/BtnCancelComponent.vue";
import PrivateAreaMsgComponent from "../components/modules/pushmessage/PrivateAreaMsgComponent.vue";
import { Dark } from "quasar";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { errorValidation } from "../helpers/notifications";

defineOptions({
    name: "AdminLayout",
});

const currentNav = ref(null);
const mini = ref(false);
const leftDrawerOpen = ref(false);
const showPasswordDialog = ref(false);
const formDataPassword = useForm({
    password: null,
    old_password: null,
});
const formPassword = ref(null);

function toggleLeftDrawer() {
    leftDrawerOpen.value = !leftDrawerOpen.value;
    mini.value = !leftDrawerOpen.value;
}

const links = ref([
    {
        title: "vivir en plenitud",
        url: "/",
    },
    {
        title: "consulta individual",
        url: "/consulta_individual",
    },
    {
        title: "taller online",
        url: "/taller_online",
    },
    {
        title: "publicaciones",
        url: "/publicaciones",
    },
    {
        title: "contactame",
        url: "/contactame",
    },
]);

onMounted(() => {
    const config = usePage().props.auth.user.configuration;
    Dark.set(
        config ? (config["dark"] !== undefined ? config["dark"] : false) : false
    );
});

const user = computed(() => {
    return usePage().props.auth.user;
});

const onUpdateField = (name, val) => {
    formDataPassword[name] = val;
};

const changePassword = () => {
    formPassword.value.validate().then((success) => {
        if (success) {
            formDataPassword.post(`/admin/users/change-my-password`, {
                onSuccess: (data) => {
                    if (data.props.flash_success) {
                        showPasswordDialog.value = false;
                    }
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
