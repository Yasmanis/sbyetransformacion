<template>
    <q-btn :label="label">
        <q-menu>
            <q-card style="max-width: 120px">
                <q-card-section>
                    <checkbox-field
                        :model-value="bookVolume_1"
                        label="tomo I"
                        name="tomo_1"
                        @update="
                            (name, val) => {
                                bookVolume_1 = val;
                            }
                        "
                    />
                    <checkbox-field
                        :model-value="bookVolume_2"
                        label="tomo II"
                        name="tomo_2"
                        @update="
                            (name, val) => {
                                bookVolume_2 = val;
                            }
                        "
                    />
                    <checkbox-field
                        :model-value="bookVolume_3"
                        label="tomo III"
                        name="tomo_3"
                        @update="
                            (name, val) => {
                                bookVolume_3 = val;
                            }
                        "
                    />
                </q-card-section>
                <q-card-actions align="right">
                    <btn-save-component @click="saveBookVolumes" />
                    <btn-cancel-component v-close-popup />
                </q-card-actions>
            </q-card>
        </q-menu>
    </q-btn>
</template>

<script setup>
import { ref, onMounted } from "vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import CheckboxField from "../../form/input/CheckboxField.vue";
import { useForm } from "@inertiajs/vue3";
defineOptions({
    name: "BookVolumesComponent",
});

const props = defineProps({
    object: {
        type: Object,
        default: [],
    },
    label: String,
});

const bookVolume_1 = ref(false);
const bookVolume_2 = ref(false);
const bookVolume_3 = ref(false);

onMounted(() => {
    bookVolume_1.value = props.object.book_volumes?.includes("tomo_1")
        ? true
        : false;
    bookVolume_2.value = props.object.book_volumes?.includes("tomo_2")
        ? true
        : false;
    bookVolume_3.value = props.object.book_volumes?.includes("tomo_3")
        ? true
        : false;
});

const saveBookVolumes = () => {
    let book_volumes = [];
    if (bookVolume_1.value) {
        book_volumes.push("tomo_1");
    }
    if (bookVolume_2.value) {
        book_volumes.push("tomo_2");
    }
    if (bookVolume_3.value) {
        book_volumes.push("tomo_3");
    }
    book_volumes = book_volumes.length > 0 ? book_volumes : null;
    useForm({
        book_volumes,
    }).post(`/contacts/change-book-volume/${props.object.id}`);
};
</script>
