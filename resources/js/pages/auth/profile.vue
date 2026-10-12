<template>
    <Layout>
        <q-page padding>
            <q-toolbar
                class="no-padding q-px-sm"
                :class="[
                    Dark.isActive ? '' : 'bg-white text-primary',
                    { 'q-py-sm column items-stretch': $q.screen.xs },
                ]"
            >
                <!-- 📱 VISTA MÓVIL (xs): Menú desplegable con q-btn-dropdown -->
                <div class="xs full-width">
                    <q-btn-dropdown
                        class="full-width q-mt-sm"
                        color="primary"
                        flat
                        align="left"
                        no-caps
                        :icon="currentTabIcon"
                        :label="currentTabLabel"
                    >
                        <q-list>
                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'info'"
                                :active="tab === 'info'"
                            >
                                <q-item-section avatar
                                    ><q-icon name="mdi-account-outline"
                                /></q-item-section>
                                <q-item-section
                                    >informacion general</q-item-section
                                >
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'buyer'"
                                v-if="$page.props.buyer"
                                :active="tab === 'buyer'"
                            >
                                <q-item-section avatar
                                    ><q-icon name="mdi-account-cash-outline"
                                /></q-item-section>
                                <q-item-section>datos de compra</q-item-section>
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'books'"
                                :active="tab === 'books'"
                            >
                                <q-item-section avatar
                                    ><q-icon
                                        name="mdi-book-open-page-variant-outline"
                                /></q-item-section>
                                <q-item-section
                                    >tomos adquiridos</q-item-section
                                >
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'tikets'"
                                :active="tab === 'tikets'"
                            >
                                <q-item-section avatar
                                    ><q-icon name="mdi-send"
                                /></q-item-section>
                                <q-item-section>tikets</q-item-section>
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'notifications'"
                                :active="tab === 'notifications'"
                            >
                                <q-item-section avatar
                                    ><q-icon name="mdi-bell-cog-outline"
                                /></q-item-section>
                                <q-item-section>notificaciones</q-item-section>
                            </q-item>

                            <q-item
                                clickable
                                v-close-popup
                                @click="tab = 'password'"
                                :active="tab === 'password'"
                            >
                                <q-item-section avatar
                                    ><q-icon name="mdi-key-outline"
                                /></q-item-section>
                                <q-item-section
                                    >cambiar contraseña</q-item-section
                                >
                            </q-item>
                        </q-list>
                    </q-btn-dropdown>
                </div>

                <!-- 💻 VISTA TABLET Y ESCRITORIO (gt-xs): Tus q-tabs originales -->
                <q-tabs
                    v-model="tab"
                    dense
                    align="left"
                    no-caps
                    shrink
                    mobile-arrows
                    class="col-grow gt-xs"
                    :class="Dark.isActive ? '' : 'bg-white text-primary'"
                >
                    <q-tab
                        name="info"
                        icon="mdi-account-outline"
                        label="informacion general"
                    />
                    <q-tab
                        name="buyer"
                        icon="mdi-account-cash-outline"
                        label="datos de compra"
                        v-if="$page.props.buyer"
                    />
                    <q-tab
                        name="books"
                        icon="mdi-book-open-page-variant-outline"
                        label="tomos adquiridos"
                    />
                    <q-tab name="tikets" icon="mdi-send" label="tikets" />
                    <q-tab
                        name="notifications"
                        icon="mdi-bell-cog-outline"
                        label="notificaciones"
                    />
                    <q-tab
                        name="password"
                        icon="mdi-key-outline"
                        label="cambiar contraseña"
                    />
                </q-tabs>

                <q-space v-if="!$q.screen.xs" />

                <div
                    :class="{ 'q-mt-sm flex justify-end': $q.screen.xs }"
                    v-if="tab === 'books'"
                >
                    <btn-add-component
                        class="q-mr-md"
                        tooltips="adicionar nueva compra"
                        @click="newBook = true"
                    />
                </div>
            </q-toolbar>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="info">
                    <info-component />
                </q-tab-panel>

                <q-tab-panel name="buyer" style="padding: 10px 0px">
                    <buyer-info-component />
                </q-tab-panel>

                <q-tab-panel name="books">
                    <books-component
                        :new-book="newBook"
                        @show="newBook = false"
                    />
                </q-tab-panel>

                <q-tab-panel name="tikets" class="no-padding">
                    <tikets-component />
                </q-tab-panel>

                <q-tab-panel name="notifications" class="no-padding">
                    <notifications-manager-component
                        :notification-from-email="notificationFromEmail"
                    />
                </q-tab-panel>

                <q-tab-panel name="password">
                    <q-card flat>
                        <q-card-section class="col q-pt-none">
                            <q-form
                                class="q-gutter-sm q-mt-sm"
                                ref="formPassword"
                                greedy
                            >
                                <password-field
                                    ref="passwordRef"
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
                                @click="onCancelPass"
                            />
                        </q-card-actions>
                    </q-card>
                </q-tab-panel>
            </q-tab-panels>
        </q-page>
    </Layout>
</template>

<script setup>
import { ref, computed, onBeforeMount } from "vue";
import { useQuasar, Dark } from "quasar";
import Layout from "../../layouts/AdminLayout.vue";
import PasswordField from "../../components/form/input/PasswordField.vue";
import BtnAddComponent from "../../components/btn/BtnAddComponent.vue";
import BtnSaveComponent from "../../components/btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../components/btn/BtnCancelComponent.vue";
import InfoComponent from "../../components/auth/InfoComponent.vue";
import BuyerInfoComponent from "../../components/auth/buyer/BuyerInfoComponent.vue";
import BooksComponent from "../../components/auth/BooksComponent.vue";
import NotificationsManagerComponent from "../../components/auth/NotificationsManagerComponent.vue";
import TiketsComponent from "../../components/auth/TiketsComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "Profile",
});

const $q = useQuasar();
const tab = ref("info");
const formPassword = ref(null);
const formDataPassword = useForm({
    password: null,
    old_password: null,
});
const passwordRef = ref(null);
const newBook = ref(false);
const notificationFromEmail = ref(null);

// Mapeos para mostrar la etiqueta e icono actual dinámicamente en el botón de móvil
const tabLabels = {
    info: "informacion general",
    buyer: "datos de compra",
    books: "tomos adquiridos",
    tikets: "tikets",
    notifications: "notificaciones",
    password: "cambiar contraseña",
};

const tabIcons = {
    info: "mdi-account-outline",
    buyer: "mdi-account-cash-outline",
    books: "mdi-book-open-page-variant-outline",
    tikets: "mdi-send",
    notifications: "mdi-bell-cog-outline",
    password: "mdi-key-outline",
};

const currentTabLabel = computed(() => tabLabels[tab.value] || "");
const currentTabIcon = computed(() => tabIcons[tab.value] || "");

onBeforeMount(() => {
    let hash = window.location.hash;
    if (hash && hash.trim() !== "") {
        hash = JSON.parse(atob(hash.substring(1)));
        tab.value = hash.tab;
    }
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
                        onCancelPass();
                    }
                },
            });
        } else {
            errorValidation();
        }
    });
};

const onCancelPass = () => {
    passwordRef.value.reset();
    formDataPassword.reset();
    formPassword.value.reset();
    formPassword.value.resetValidation();
};
</script>
