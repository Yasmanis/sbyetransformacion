<template>
    <q-btn-component
        label="alguna duda? preguntanos"
        class="full-width"
        :round="false"
        no-caps
        @click="showDialog = true"
    />

    <q-dialog v-model="showDialog">
        <q-card>
            <dialog-header-component
                icon="mdi-help"
                :title="`duda sobre ${product?.name ?? 'el producto'}`"
                closable
                @close="showDialog = false"
            />
            <q-card-section>
                <q-form ref="formRef">
                    <editor-field
                        name="description"
                        :others-props="{
                            required: true,
                        }"
                    />
                </q-form>
            </q-card-section>
            <q-card-actions align="right">
                <btn-save-component @click="save" />
                <btn-cancel-component
                    :cancel="true"
                    @click="showDialog = false"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import DialogHeaderComponent from "../../base/DialogHeaderComponent.vue";
import EditorField from "../../form/input/EditorField.vue";
import BtnSaveComponent from "../../btn/BtnSaveComponent.vue";
import BtnCancelComponent from "../../btn/BtnCancelComponent.vue";
import { errorValidation } from "../../../helpers/notifications";

defineOptions({
    name: "HelpQuestion",
});

const props = defineProps({
    product: Object,
});

const showDialog = ref(false);
const formRef = ref(null);

const save = () => {
    formRef.value.validate().then((success) => {
        if (success) {
        } else {
            errorValidation();
        }
    });
};
</script>
