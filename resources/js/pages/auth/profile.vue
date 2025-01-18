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
                    @click="newBook = true"
                    v-if="tab === 'books'"
                />
            </q-toolbar>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="info">
                    <info-component />
                </q-tab-panel>

                <q-tab-panel name="books">
                    <books-component
                        :new-book="newBook"
                        @show="newBook = false"
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
import { ref } from "vue";
import Layout from "../../layouts/AdminLayout.vue";
import PasswordField from "../../components/form/input/PasswordField.vue";
import BtnAddComponent from "../../components/btn/BtnAddComponent.vue";
import BtnSaveComponent from "../../components/btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../components/btn/BtnCancelComponent.vue";
import InfoComponent from "../../components/auth/InfoComponent.vue";
import BooksComponent from "../../components/auth/BooksComponent.vue";
import { useForm } from "@inertiajs/vue3";
import { Dark } from "quasar";
import { errorValidation } from "../../helpers/notifications";
defineOptions({
    name: "Profile",
});
const tab = ref("info");
const formPassword = ref(null);
const formDataPassword = useForm({
    password: null,
    old_password: null,
});
const passwordRef = ref(null);
const newBook = ref(false);

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
