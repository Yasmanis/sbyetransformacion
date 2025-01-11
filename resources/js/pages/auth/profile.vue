<template>
    <Layout>
        <q-page padding>
            <q-toolbar
                class="no-padding"
                :class="Dark.isActive ? '' : 'bg-white text-primary'"
            >
                <q-tabs
                    v-model="tab"
                    dense
                    align="left"
                    no-caps
                    :class="Dark.isActive ? '' : 'bg-white text-primary'"
                >
                    <q-tab
                        name="info"
                        icon="mdi-account-outline"
                        label="informacion general"
                    />
                    <q-tab
                        name="books"
                        icon="mdi-book-open-page-variant-outline"
                        label="tomos adquiridos"
                    />
                    <q-tab
                        name="password"
                        icon="mdi-key-outline"
                        label="cambiar contraseña"
                    />
                </q-tabs>
                <q-space />
                <btn-add-component
                    class="q-mr-md"
                    tooltips="adicionar nueva compra"
                    @click="showDialogBook = true"
                    v-if="tab === 'books'"
                />
            </q-toolbar>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="info">
                    <div class="text-h6">Mails</div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                </q-tab-panel>

                <q-tab-panel name="books">
                    <div class="row">
                        <template
                            v-for="(b, indexB) in $page.props.books"
                            :key="`book-volume-${indexB}`"
                        >
                            <div
                                class="col-lg-4 col-md-4 col-sm-6 col-xs-12"
                                :class="screen.xs ? '' : 'q-pa-sm'"
                            >
                                <q-card>
                                    <q-card-section>
                                        <q-img
                                            :src="`${$page.props.public_path}${b.book_volume_img}`"
                                            fit="fill"
                                        />
                                    </q-card-section>
                                    <q-card-section>
                                        <q-list>
                                            <q-item
                                                v-for="(c, indexC) in columns"
                                                :key="`column-${indexC}`"
                                            >
                                                <q-item-section>
                                                    <q-item-label>
                                                        {{
                                                            c.label
                                                        }}</q-item-label
                                                    >
                                                    <q-item-label caption>
                                                        {{
                                                            b[c.name]
                                                                ? b[c.name]
                                                                : "..."
                                                        }}</q-item-label
                                                    >
                                                </q-item-section>
                                            </q-item>
                                            <q-item>
                                                <q-item-section>
                                                    <q-item-label>
                                                        ticket</q-item-label
                                                    >
                                                </q-item-section>
                                                <q-item-section
                                                    avatar
                                                    style="width: 160px"
                                                >
                                                    <q-img
                                                        :src="`${
                                                            $page.props
                                                                .public_path
                                                        }${
                                                            b.ticket
                                                                ? `storage/${b.ticket}`
                                                                : 'images/icon/emoji-duda.jpg'
                                                        }`"
                                                        fit="fill"
                                                    />
                                                </q-item-section>
                                            </q-item>
                                        </q-list>
                                    </q-card-section>
                                </q-card>
                            </div>
                        </template>
                    </div>
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

    <q-dialog v-model="showDialogBook" persistent position="right" full-hight>
        <q-card class="scroll">
            <dialog-header-component
                icon="mdi-plus"
                title="nueva compra"
                closable
            />
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import PasswordField from "../../components/form/input/PasswordField.vue";
import BtnSaveComponent from "../../components/btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../components/btn/BtnCancelComponent.vue";
import BtnAddComponent from "../../components/btn/BtnAddComponent.vue";
import DialogHeaderComponent from "../../components/base/DialogHeaderComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { Dark } from "quasar";
import { errorValidation } from "../../helpers/notifications";
import { date, useQuasar } from "quasar";
defineOptions({
    name: "Profile",
});
const tab = ref("info");
const formPassword = ref(null);
const formDataPassword = useForm({
    password: null,
    old_password: null,
});
const formDataBook = useForm({
    book_number: null,
    book_date: null,
    msg_title: null,
    message: null,
    other_people: null,
    attachments: null,
    ticket: null,
});
const showDialogBook = ref(false);
const passwordRef = ref(null);
const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});
const columns = ref([
    {
        name: "msg_title",
        label: "titulo",
    },
    {
        name: "message",
        label: "mensaje",
    },
    {
        name: "book_number",
        label: "# pedido",
    },
    {
        name: "book_date",
        label: "fecha de compra",
    },
    {
        name: "other_people",
        label: "persona en ticket",
    },
]);

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
