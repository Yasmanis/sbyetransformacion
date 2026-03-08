<template>
    <q-btn
        icon="mdi-shape-square-rounded-plus"
        flat
        padding="0px"
        round
        v-if="object"
    >
        <q-tooltip-component title="ver nota" />
        <q-menu
            v-model="model"
            transition-show="scale"
            transition-hide="scale"
            :style="{ background: object?.b_color, width: '250px' }"
        >
            <q-list dense>
                <q-item style="padding: 10px">
                    <q-item-section>
                        <q-item-label
                            :style="{ color: object?.t_color }"
                            class="text-justify"
                        >
                            {{ object.content }}
                        </q-item-label>
                    </q-item-section>
                    <q-item-section avatar top>
                        <q-icon
                            name="close"
                            class="cursor-pointer"
                            size="xs"
                            :color="luminance"
                            @click="model = false"
                        ></q-icon>
                    </q-item-section>
                </q-item>
                <q-item style="padding: 5px">
                    <q-item-section> </q-item-section>
                    <q-item-section avatar>
                        <form-note-component
                            :object="object"
                            :color="luminance"
                        />
                    </q-item-section>
                    <q-item-section
                        avatar
                        style="min-width: 20px !important; padding: 0"
                    >
                        <btn-delete-component
                            :color="luminance"
                            @click="router.delete(`/admin/notes/${object.id}`)"
                        />
                    </q-item-section>
                </q-item>
            </q-list>
        </q-menu>
    </q-btn>
</template>

<script setup>
import { computed, ref } from "vue";
import FormNoteComponent from "./FormNoteComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
import QTooltipComponent from "../../base/QTooltipComponent.vue";
import { router } from "@inertiajs/vue3";
import { colors } from "quasar";

defineOptions({
    name: "MenuNoteComponent",
});

const props = defineProps({
    object: Object,
});

const model = ref(false);

const luminance = computed(() => {
    const lum = colors.luminosity(props.object.b_color);
    return lum ? (lum > 0.5 ? "black" : "white") : null;
});
</script>
