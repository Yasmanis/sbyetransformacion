<template>
    <Layout title="publicaciones">
        <div
            class="row container q-mt-xl"
            :style="{ 'padding-top': screen.xs || screen.sm ? '40px' : '' }"
        >
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <files-category-component :category="currentCategory" />
                <div
                    class="row q-pa-md"
                    v-if="currentCategory?.name === 'testimonios'"
                >
                    <form-testimony-component />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="column items-center q-px-sm">
                    <list-category-component
                        :categories="categories"
                        :current="currentCategory"
                        :sticky="screen.xs || screen.sm"
                    />
                    <q-card
                        class="my-card rounded shadow-4 full-width q-mt-lg"
                        v-if="recent_files.length > 0"
                    >
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">mas recientes</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <q-list>
                                <q-item
                                    v-for="(f, indexRecent) in recent_files"
                                    :key="`recent-file-${indexRecent}`"
                                    class="q-py-md q-px-none"
                                    :class="
                                        indexRecent === recent_files.length - 1
                                            ? 'q-pb-none'
                                            : 'border-dashed-bottom-1'
                                    "
                                    :href="`${$page.props.public_path}storage/${f.path}`"
                                    target="_blank"
                                    clickable
                                >
                                    <q-item-section
                                        avatar
                                        style="width: 70px"
                                        class="q-pr-none"
                                    >
                                        <q-img
                                            :src="`${$page.props.public_path}images/others/publicaciones-recientes.png`"
                                        />
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label
                                            lines="3"
                                            class="text-lowercase text-primary text-weight-bold"
                                            >{{
                                                f.name.substring(
                                                    0,
                                                    f.name.lastIndexOf(".")
                                                )
                                            }}</q-item-label
                                        >
                                        <q-item-label
                                            ><small>{{
                                                f.date_for_human
                                            }}</small></q-item-label
                                        >
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>

                    <q-card class="my-card rounded shadow-4 full-width q-my-lg">
                        <q-card-section class="q-pb-none">
                            <p class="q-my-sm text-uppercase">redes sociales</p>
                            <div style="border-bottom: 2px solid #407492"></div>
                            <div class="row">
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-facebook-f"
                                        label="facebook"
                                        class="full-width"
                                        no-caps
                                        href="https://www.facebook.com/profile.php?id=61563937152210"
                                        target="_blank"
                                        align="left"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-youtube"
                                        label=" youtube"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.youtube.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-instagram"
                                        label="instagram"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.instagram.com/sbyetransformacion/"
                                        target="_blank"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-6 col-lg-6 q-pa-sm"
                                >
                                    <q-btn
                                        color="primary"
                                        icon="fab fa-tiktok"
                                        label="tiktok"
                                        class="full-width"
                                        no-caps
                                        align="left"
                                        href="https://www.tiktok.com/@sbyetransformacion"
                                        target="_blank"
                                    />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed, ref } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { usePage } from "@inertiajs/vue3";
import ListCategoryComponent from "../../components/landing/ListCategoryComponent.vue";
import FilesCategoryComponent from "../../components/landing/FilesCategoryComponent.vue";
import FormTestimonyComponent from "../../components/landing/FormTestimonyComponent.vue";
import { useQuasar } from "quasar";

defineOptions({
    name: "Publicaciones",
});

const $q = useQuasar();

const screen = computed(() => {
    return $q.screen;
});

const page = usePage();

const currentCategory = computed(() => {
    return page.props.current_category;
});

const categories = computed(() => {
    return page.props.categories;
});

const recent_files = computed(() => {
    return page.props.recent_files;
});
</script>

<style scope>
.border-dashed-bottom-1 {
    border-bottom: 1px dashed #70707057;
}

.list-unstyled {
    padding-left: 0;
    list-style: none;
}

.mdi-asterisk {
    opacity: 0.8;
    position: absolute;
    font-size: 12px;
    z-index: 9;
    margin-top: 5px;
}

.img-aster-msg {
    margin-top: 5px !important;
    margin-left: 83px;
    z-index: 9;
}

.q-field__control::before,
.q-field__control::after {
    border: 0.5px solid !important;
}

.q-textarea .q-field__native {
    resize: none !important;
}

.q-field__messages {
    font-size: 14px;
}

.rounded-top {
    border-top-left-radius: 20px !important;
    border-top-right-radius: 20px;
}
</style>
