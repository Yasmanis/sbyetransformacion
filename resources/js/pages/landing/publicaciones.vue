<template>
    <Layout>
        <section class="banner page-banner position-relative pb-0">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-title text-center position-relative pb-5">
                    <p class="text-white text-uppercase header-title">
                        publicaciones
                    </p>
                </div>
            </div>
        </section>
        <section class="news-archive">
            <div class="container">
                <div class="news-archive-inner">
                    <div class="row gy-5">
                        <div class="col-lg-8">
                            <div class="news-left me-4 m-md-0">
                                <div class="row g-md-5 gy-5">
                                    <div v-for="(f, indexFile) in files" :key="`file-${indexFile}`"
                                        class="col-lg-6 col-md-6">
                                        <div class="blog-box border border-1 rounded pb-2 text-center">
                                            <div class="blog-img">
                                                <video :src="`${$page.props.public_path}storage/${f.path}`" controls
                                                    class="blog-img rounded-top w-100 h-auto"
                                                    v-if="f.type.startsWith('video/') || f.type.startsWith('audio/')"></video>
                                                <a :href="`${$page.props.public_path}storage/${f.path}`" target="_blank"
                                                    v-else>
                                                    <img class="blog-img rounded-top w-100 h-auto"
                                                        :src="`${$page.props.public_path}images/group/6.jpg`" style="
                                                            height: 160px !important;
                                                        " />
                                                </a>
                                            </div>
                                            <div class="blog-info p-4">
                                                <h5 class="mb-2 text-lowercase">
                                                    <a :href="`${$page.props.public_path}storage/${f.path}`"
                                                        target="_blank" class="font-black">{{ f.name.substring(0,
                                                            f.name.lastIndexOf('.')) }}</a>
                                                </h5>
                                                <a class="text-uppercase font-company"
                                                    :href="`${$page.props.public_path}storage/${f.path}`"
                                                    target="_blank"><small>ver</small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="news-right ms-4 m-md-0"></div>
                            <div class="catagories p-6 rounded box-shadow mb-6">
                                <h6 class="mb-3">categorias</h6>
                                <div class="sperator mb-4 m-0 w-20 border-bottom border-2 border-company"></div>
                                <ul class="m-0 p-0 list-unstyled">
                                    <li v-for="(c, index) in categories" :key="`category-${index}`"
                                        class="py-3 border-dashed-bottom-1">
                                        <Link :href="`/publicaciones/${c.id}`" class="font-company"><i
                                            class="fa fa-check font-company pe-3" aria-hidden="true"></i>{{
                                                c.name
                                            }}</Link>
                                    </li>
                                </ul>
                            </div>
                            <div class="recent-post-box p-6 box-shadow rounded mb-6">
                                <h6 class="mb-2">mas recientes</h6>
                                <div class="sperator w-20 border-bottom border-2 border-company mb-5"></div>
                                <div class="recent-post-list">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6">
                                            <div class="recent-post d-flex align-items-center mb-4">
                                                <div class="post-img">
                                                    <a href="news-single.html"><img
                                                            src="{{ asset('images/group/6.jpg') }}" alt="Blog Image"
                                                            class="me-3" /></a>
                                                </div>
                                                <div class="post-detail">
                                                    <a href="news-single.html"
                                                        class="font-black fw-bold text-uppercase">The Top Music
                                                        Festivals
                                                        in NYC</a>
                                                    <p class="mb-0">
                                                        <small>April 3,
                                                            2023</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-6">
                                            <div class="recent-post d-flex align-items-center mb-4">
                                                <div class="post-img">
                                                    <a href="news-single.html"><img
                                                            src="{{ asset('images/group/7.jpg') }}" alt="Blog Image"
                                                            class="me-3" /></a>
                                                </div>
                                                <div class="post-detail">
                                                    <a href="news-single.html"
                                                        class="font-black fw-bold text-uppercase">Live Interview from
                                                        conference</a>
                                                    <p class="mb-0">
                                                        <small>April 3,
                                                            2023</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-6">
                                            <div class="recent-post d-flex align-items-center mb-4">
                                                <div class="post-img">
                                                    <a href="news-single.html"><img
                                                            src="{{ asset('images/group/4.jpg') }}" alt="Blog Image"
                                                            class="me-3" /></a>
                                                </div>
                                                <div class="post-detail">
                                                    <a href="news-single.html"
                                                        class="font-black fw-bold text-uppercase">Registration for
                                                        opening workshop</a>
                                                    <p class="mb-0">
                                                        <small>April 3,
                                                            2023</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="social-media-links">
                                <h6 class="mb-2">redes sociales</h6>
                                <div class="sperator m-0 mb-5 w-20 border-bottom border-2 border-company"></div>
                                <div class="social-media-inner">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a href="https://www.facebook.com/profile.php?id=61563937152210"
                                                target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                                                    class="fa fa-facebook-official rounded mx-2 me-3"
                                                    aria-hidden="true"></i>facebook</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="https://www.youtube.com/@sbyetransformacion" target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                                                    class="fa fa-youtube-play rounded mx-2 me-3"
                                                    aria-hidden="true"></i>youtube</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="https://www.instagram.com/sbyetransformacion/" target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                                                    class="fa fa-instagram rounded mx-2 me-3"
                                                    aria-hidden="true"></i>instagram</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="https://www.tiktok.com/@sbyetransformacion" target="_blank"
                                                class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company">
                                                <img :src="`${$page.props.public_path}images/icon/tiktok.png`"
                                                    class="rounded mx-2 me-3" style="width: 20px" />tiktok</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script setup>
import { computed } from "vue";
import Layout from "../../layouts/MainLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";

defineOptions({
    name: "Publicaciones",
});

const page = usePage();

const files = computed(() => {
    return page.props.files;
});

const categories = computed(() => {
    return page.props.categories;
});

</script>
