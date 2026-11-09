<template>
    <div class="row" v-if="files.length > 0">
        <!-- Botón newsletter -->
        <div class="col-xl-12 col-lg-12 col-sm-12 text-center">
            <q-btn
                label="quiero recibir mi newsletter!"
                rounded
                color="black"
                no-caps
                class="q-mb-xl"
                href="/#suscribe"
                v-if="
                    category?.name?.toLowerCase() == 'newsletter' ||
                    category?.name?.toLowerCase() == 'newsletters'
                "
            />
        </div>

        <template v-if="isCategoryOnly">
            <template
                v-for="group in visibleGroups"
                :key="`fam-${group.family.id ?? 'none'}`"
            >
                <div class="col-12 q-mt-lg q-mb-sm">
                    <div class="row items-center">
                        <div class="col">
                            <h5 class="q-my-none text-lowercase text-primary">
                                {{ group.family.name }}
                            </h5>
                        </div>
                        <div class="col-auto text-caption text-grey">
                            {{ group.total }} elemento(s)
                        </div>
                    </div>
                    <div class="bg-primary" style="height: 1px"></div>
                </div>

                <q-intersection
                    v-for="file in group.files"
                    :key="`file-${group.family.id ?? 'none'}-${file.id}`"
                    :class="cls"
                    once
                    transition="scale"
                >
                    <file-card :file="file" :category="category" />
                </q-intersection>
            </template>
        </template>

        <template v-else>
            <q-intersection
                v-for="(file, index) in visibleFiles"
                :key="`file-${index}`"
                :class="cls"
                once
                transition="scale"
            >
                <file-card :file="file" :category="category" />
            </q-intersection>
        </template>

        <div
            v-if="hasMore"
            ref="sentinel"
            class="col-12 flex flex-center q-pa-lg"
        >
            <q-spinner color="primary" size="2em" />
        </div>
    </div>

    <div class="row text-center q-mb-md" v-if="files.length === 0">
        <h3>
            lo sentimos, aun no se han hecho publicaciones en esta seleccion
        </h3>
    </div>
</template>

<script setup>
import {
    ref,
    onMounted,
    onBeforeUnmount,
    computed,
    nextTick,
    watch,
} from "vue";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import { usePage } from "@inertiajs/vue3";
import FileCard from "./FileCard.vue";

defineOptions({ name: "FilesCategoryComponent" });

const props = defineProps({
    category: Object,
});

const PAGE_SIZE = 12;
const visibleCount = ref(PAGE_SIZE);
const sentinel = ref(null);
let observer = null;
let lightbox = null;

const page = usePage();

const files = computed(() => page.props.files ?? []);

const isCategoryOnly = computed(() => page.props.active_filter === "category");

const visibleFiles = computed(() => files.value.slice(0, visibleCount.value));

const groupedFiles = computed(() => {
    if (!isCategoryOnly.value) return [];

    const groups = new Map();
    const withoutFamily = [];

    for (const file of files.value) {
        const families = file.subcategory?.families ?? [];

        if (families.length === 0) {
            withoutFamily.push(file);
            continue;
        }

        for (const fam of families) {
            if (!groups.has(fam.id)) {
                groups.set(fam.id, { family: fam, files: [] });
            }
            groups.get(fam.id).files.push(file);
        }
    }

    const result = [...groups.values()];
    if (withoutFamily.length > 0) {
        result.push({
            family: { id: null, name: "Sin familia" },
            files: withoutFamily,
        });
    }
    return result;
});

const visibleGroups = computed(() => {
    if (!isCategoryOnly.value) return [];
    let remaining = visibleCount.value;
    const out = [];
    for (const g of groupedFiles.value) {
        if (remaining <= 0) break;
        const take = g.files.slice(0, remaining);
        out.push({
            family: g.family,
            files: take,
            total: g.files.length,
        });
        remaining -= take.length;
    }
    return out;
});

const hasMore = computed(() => visibleCount.value < files.value.length);

const loadMore = () => {
    if (!hasMore.value) return;
    const remaining = files.value.length - visibleCount.value;
    visibleCount.value += Math.min(PAGE_SIZE, remaining);
};

const setupObserver = () => {
    if (observer) observer.disconnect();
    if (!sentinel.value) return;
    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) loadMore();
        },
        { rootMargin: "300px 0px", threshold: 0 },
    );
    observer.observe(sentinel.value);
};

const reloadLightbox = () => {
    nextTick(() => {
        // Destruir la instancia anterior para limpiar listeners viejos
        if (lightbox) {
            lightbox.destroy();
            lightbox = null;
        }
        // Crear una nueva instancia que escanee el DOM actualizado
        lightbox = GLightbox({
            selector: ".glightbox",
            touchNavigation: true,
            loop: false,
        });
    });
};

onMounted(() => {
    lightbox = GLightbox({
        selector: ".glightbox",
        touchNavigation: true,
        loop: false,
    });
    nextTick(() => setupObserver());
});

onBeforeUnmount(() => {
    if (observer) {
        observer.disconnect();
        observer = null;
    }
});

watch(visibleCount, () => {
    reloadLightbox();
    nextTick(() => setupObserver());
});

watch(sentinel, (el) => {
    if (el) nextTick(() => setupObserver());
});

watch(
    () => files.value,
    () => {
        visibleCount.value = PAGE_SIZE;
        reloadLightbox();
        nextTick(() => setupObserver());
    },
);

watch(
    () => props.category,
    () => {
        visibleCount.value = PAGE_SIZE;
    },
);

const cls = computed(() => {
    const name = props.category?.name?.toLowerCase();
    if (!name) return null;
    if (name === "post" || name === "posts")
        return "col-lg-4 col-md-4 col-sm-6 col-xs-12 q-pa-sm";
    if (name === "newsletter" || name === "newsletters")
        return "col-lg-3 col-md-3 col-sm-4 col-xs-12 q-pa-sm text-center";
    return "col-lg-6 col-md-6 col-sm-6 col-xs-12";
});
</script>
