<template>
    <header class="main_header_area position-absolute w-100">
        <div class="header_menu" id="header_menu">
            <div class="container">
                <nav class="navbar navbar-expand-lg py-6">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="navbar-brand m-0">
                                <img
                                    :src="`${$page.props.public_path}images/logo/1.png`"
                                    alt="Logo"
                                    class="w-100"
                                />
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-6">
                            <div
                                class="collapse navbar-collapse justify-content-between ms-8"
                                id="bs-example-navbar-collapse-1"
                            >
                                <ul
                                    class="navbar-nav align-items-center"
                                    id="responsive-menu"
                                >
                                    <li class="nav-item">
                                        <Link
                                            href="/"
                                            class="nav-link px-2 my-4 py-0 text-white"
                                            >vivir en plenitud</Link
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <Link
                                            href="/consulta_individual"
                                            class="nav-link px-2 my-4 py-0 text-white"
                                            >consulta individual</Link
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <Link
                                            href="/taller_online"
                                            class="nav-link px-2 my-4 py-0 text-white"
                                            >taller online</Link
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <Link
                                            href="/publicaciones"
                                            class="nav-link px-2 my-4 py-0 text-white"
                                            >publicaciones</Link
                                        >
                                    </li>
                                    <li class="nav-item">
                                        <Link
                                            href="/contactame"
                                            class="nav-link px-2 my-4 py-0 text-white"
                                            >contactame</Link
                                        >
                                    </li>
                                </ul>
                                <div class="menu-search">
                                    <a href="/login" class="btn"
                                        >area privada<i
                                            class="fa fa-long-arrow-right ms-4"
                                        ></i
                                    ></a>
                                </div>
                            </div>
                        </div>
                        <div id="slicknav-mobile"></div>
                    </div>
                </nav>
            </div>
            <div id="search1">
                <button type="button" class="close">×</button>
                <form>
                    <input
                        class="form-control form-control-lg rounded text-white"
                        placeholder="Search..."
                    />
                </form>
                <button type="button" class="btn">
                    <i class="fa fa-search text-white" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    <slot />

    <footer
        class="pt-6 text-center text-white position-relative z-1"
        style="background: #000000"
    >
        <div class="container">
            <div class="footer-disciption mt-2 mb-4">
                <div class="footer-socials">
                    <ul class="m-0 p-0">
                        <li class="d-inline me-2">
                            <a
                                href="https://www.facebook.com/profile.php?id=61563937152210"
                                target="_blank"
                                class="d-inline-block rounded-circle bg-white bg-opacity-25"
                            >
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a
                                href="https://www.youtube.com"
                                target="_blank"
                                class="d-inline-block rounded-circle bg-white bg-opacity-25"
                            >
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a
                                href="https://www.instagram.com"
                                target="_blank"
                                class="d-inline-block rounded-circle bg-white bg-opacity-25"
                            >
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <li class="d-inline me-2">
                            <a
                                href="https://www.tiktok.com/@sbyetransformacion"
                                target="_blank"
                                class="d-inline-block rounded-circle bg-white bg-opacity-25"
                            >
                                <img
                                    :src="`${$page.props.public_path}images/icon/tiktok.png`"
                                    style="width: 20px"
                                />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-menu pb-2">
                <ul class="p-0 m-0">
                    <li class="d-inline mx-2">
                        <a href="javascript:;"><small>avisos legales</small></a>
                    </li>
                    <li class="d-inline mx-2">
                        <a href="javascript:;"><small>privacidad</small></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright pb-6 pt-1">
            <small>&#169;2024 sbye salud s.l.</small>
        </div>
    </footer>
    <div id="back-to-top" style="display: block">
        <a
            href="#"
            class="bg-company position-relative align-items-center rounded-circle d-block"
        ></a>
    </div>
</template>

<script setup>
import "../assets/css/bootstrap.min.css";
import "../assets/css/plugin.css";
import "../assets/css/default.css";
import "../assets/css/styles.css";
import "../assets/css/app.css";
import "../assets/css/font-awesome.min.css";

import "../assets/js/jquery-3.7.1.min.js";
import "../assets/js/bootstrap.bundle.min.js";
import "../assets/js/custom-nav.js";
import "../assets/js/plugin.js";
import "../assets/js/main.js";

import { Link } from "@inertiajs/vue3";
defineOptions({
    name: "MainLayout",
});
</script>
