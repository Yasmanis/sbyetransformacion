<template>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 self-center">
            <div class="column items-center">
                <q-avatar
                    size="120px"
                    class="shadow-10 cursor-pointer"
                    @click="openCropper"
                >
                    <img :src="image" />
                </q-avatar>
                <btn-delete-component
                    tooltips="quitar avatar"
                    @click="onFinishCropper('avatar', null)"
                    v-if="user.avatar"
                />
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
            <q-card flat>
                <q-card-section v-if="edit">
                    <q-form class="q-gutter-sm q-mt-sm" ref="form" greedy>
                        <div class="row q-col-gutter-xl">
                            <div
                                class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-gutter-md"
                            >
                                <text-field
                                    :modelValue="formData.username"
                                    name="username"
                                    label="usuario"
                                    :othersProps="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    :modelValue="formData.name"
                                    name="name"
                                    label="nombre"
                                    :othersProps="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    :modelValue="formData.surname"
                                    name="surname"
                                    label="apellidos"
                                    :othersProps="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    :modelValue="formData.email"
                                    name="email"
                                    label="correo"
                                    :othersProps="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    name="phone"
                                    :model-value="formData.phone"
                                    @update="onUpdateField"
                                >
                                    <template #before>
                                        <select-field
                                            name="phone_code"
                                            label="telefono"
                                            :model-value="formData.phone_code"
                                            :disable="!formData.country_id"
                                            :options="phoneCodes"
                                            :filterable="false"
                                            :clearable="false"
                                            style="width: 90px !important"
                                            @update="onUpdateField"
                                        />
                                    </template>
                                </text-field>

                                <date-field
                                    label="fecha de nacimiento"
                                    name="birthdate"
                                    :model-value="formData.birthdate"
                                    end-now
                                    :others-props="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />

                                <select-field
                                    label="genero"
                                    name="genre"
                                    :model-value="formData.genre"
                                    :filterable="false"
                                    :options="[
                                        {
                                            label: 'masculino',
                                            value: 'M',
                                        },
                                        {
                                            label: 'femenino',
                                            value: 'F',
                                        },
                                    ]"
                                    :others-props="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                            </div>
                            <div
                                class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 q-gutter-md"
                            >
                                <select-field
                                    label="pais"
                                    name="country_id"
                                    :model-value="formData.country_id"
                                    :others-props="{
                                        required: true,
                                        url_to_options: '/countries',
                                    }"
                                    @loaded-options="onLoadedOptions"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    label="provincia"
                                    name="province"
                                    :model-value="formData.province"
                                    :others-props="{
                                        required: true,
                                    }"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    label="localidad"
                                    name="city"
                                    :model-value="formData.city"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    label="tipo via"
                                    name="road"
                                    :model-value="formData.road"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    label="nombre via, numero, portal, piso, puerta"
                                    name="address"
                                    :model-value="formData.address"
                                    @update="onUpdateField"
                                />
                                <text-field
                                    label="codigo postal"
                                    name="postal_code"
                                    :model-value="formData.postal_code"
                                    @update="onUpdateField"
                                />
                            </div>
                        </div>
                    </q-form>
                </q-card-section>
                <q-card-section v-else>
                    <div class="row">
                        <div
                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                        >
                            <q-list>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label> usuario </q-item-label>
                                        <q-item-label caption>
                                            {{ user.username ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> nombre(s) </q-item-label>
                                        <q-item-label caption>
                                            {{ user.name ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> apellidos </q-item-label>
                                        <q-item-label caption>
                                            {{ user.surname ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> correo </q-item-label>
                                        <q-item-label caption>
                                            {{ user.email ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label> telefono </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.phone_code }}
                                            {{ buyer?.phone }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label>
                                            fecha de nacimiento
                                        </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.birthdate_str ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label> genero </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.genre ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </div>
                        <div
                            class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6"
                        >
                            <q-list>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label> pais </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.country_str ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> provincia </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.province ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> localidad </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.city ?? "-" }}
                                        </q-item-label>
                                    </q-item-section> </q-item
                                ><q-item>
                                    <q-item-section>
                                        <q-item-label> tipo via </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.road ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label> direccion </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.address ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label>
                                            codigo postal
                                        </q-item-label>
                                        <q-item-label caption>
                                            {{ buyer?.postal_code ?? "-" }}
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </div>
                    </div>
                </q-card-section>
                <q-card-actions align="right">
                    <btn-edit-component @click="setEditInfo" v-if="!edit" />
                    <btn-save-component v-if="edit" @click="save" />
                    <btn-cancel-component
                        cancel
                        @click="edit = false"
                        v-if="edit"
                    />
                </q-card-actions>
            </q-card>
        </div>
    </div>

    <q-dialog v-model="showDialog" @hide="file = null">
        <q-card style="width: 600px">
            <q-card-section>
                <cropper-field
                    name="avatar"
                    :image="copperImage"
                    avatar
                    @cancel="showDialog = false"
                    @finish="onFinishCropper"
                />
            </q-card-section>
        </q-card>
    </q-dialog>

    <q-file
        v-model="file"
        ref="fileRef"
        class="hidden"
        accept=".jpg, image/*"
        @update:model-value="handleFile"
    />
</template>

<script setup>
import { onMounted, computed, ref } from "vue";
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import CropperField from "../form/input/CropperField.vue";
import BtnEditComponent from "../btn/BtnEditComponent.vue";
import BtnSaveComponent from "../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import TextField from "../form/input/TextField.vue";
import SelectField from "../form/input/SelectField.vue";
import DateField from "../form/input/DateField.vue";
import { errorValidation } from "../../helpers/notifications";

defineOptions({
    name: "InfoComponent",
});
const page = usePage();
const file = ref(null);
const fileRef = ref(null);
const showDialog = ref(false);
const image = ref(null);
const copperImage = ref(null);
const edit = ref(false);

const phoneCodes = ref([]);
const formData = useForm({
    username: null,
    name: null,
    surname: null,
    email: null,
    country_id: null,
    city: null,
    province: null,
    postal_code: null,
    road: null,
    address: null,
    genre: null,
    phone: null,
    phone_code: null,
    birthdate: null,
});

onMounted(() => {
    image.value = page.props.auth.user.avatar
        ? `${page.props.public_path}storage/${page.props.auth.user.avatar}`
        : `${page.props.public_path}images/icon/profile.svg`;
    formData.username = user.username;
});

const user = computed(() => {
    return page.props.auth.user;
});

const buyer = computed(() => {
    return page.props.buyer;
});

const form = ref(null);

const openCropper = () => {
    if (user.value.avatar) {
        copperImage.value = `${page.props.public_path}storage/${page.props.auth.user.avatar}`;
        showDialog.value = true;
    } else {
        fileRef.value.pickFiles();
    }
};

const handleFile = (file) => {
    copperImage.value = URL.createObjectURL(file);
    showDialog.value = true;
};

const onFinishCropper = (name, img) => {
    const form = useForm({
        avatar: img,
    }).post("/auth/change-avatar", {
        onSuccess: () => {
            image.value = img
                ? img
                : `${page.props.public_path}images/icon/profile.svg`;
            showDialog.value = false;
        },
    });
};

const onUpdateField = (name, value, full) => {
    if (name === "country_id" && value !== null) {
        setPhoneCodes(full);
    }
    formData[name] = value;
};

const onLoadedOptions = (opts) => {
    let opt = opts.find((o) => o.value === formData.country_id) ?? null;
    if (opt) {
        setPhoneCodes(opt);
    }
};

const setPhoneCodes = (opt) => {
    let codes = opt.phonecode.split(" ");
    phoneCodes.value = [];
    codes.forEach((c) => {
        phoneCodes.value.push({
            label: c,
            value: c,
        });
    });
};

const setEditInfo = () => {
    const { username, name, surname, email } = user.value;
    formData.username = username;
    formData.name = name;
    formData.surname = surname;
    formData.email = email;
    formData.country_id = buyer.value?.country_id ?? null;
    formData.city = buyer.value?.city ?? null;
    formData.province = buyer.value?.province ?? null;
    formData.postal_code = buyer.value?.postal_code ?? null;
    formData.road = buyer.value?.road ?? null;
    formData.address = buyer.value?.address ?? null;
    formData.genre = buyer.value?.genre ?? null;
    formData.phone_code = buyer.value?.phone_code ?? null;
    formData.phone = buyer.value?.phone ?? null;
    formData.birthdate = buyer.value?.birthdate_str ?? null;
    edit.value = true;
};

const save = () => {
    form.value.validate().then((success) => {
        if (success) {
            formData.post("/auth/profile", {
                onSuccess: () => {
                    edit.value = false;
                },
            });
        } else {
            errorValidation();
        }
    });
};
</script>
