<template>
    <q-btn
        :icon="onlyBtn ? 'mdi-basket' : 'mdi-chevron-double-left'"
        flat
        rounded
        padding="2px"
    >
        <q-tooltip
            class="bg-black text-body3"
            self="top middle"
            anchor="bottom middle"
            :offset="[5, 5]"
        >
            mostrar cesta
        </q-tooltip>
        <q-menu
            v-model="menu"
            :transition-show="onlyBtn ? '' : 'slide-left'"
            :transition-hide="onlyBtn ? '' : 'slide-right'"
            style="min-width: 520px"
            :offset="[2, -30]"
        >
            <q-card bordered>
                <q-card-section
                    class="q-pa-none"
                    style="height: 300px; width: 500px"
                >
                    <q-item dense>
                        <q-item-section avatar>
                            <btn-left-right-component
                                title="ocultar"
                                :leftDirection="false"
                                @click="menu = !menu"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label> mi cesta </q-item-label>
                            <q-item-label
                                lines="1"
                                caption
                                class="text-primary"
                            >
                                seguir comprando
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-list class="q-mt-sm">
                        <q-item class="bg-teal-2">
                            <q-item-section avatar top>
                                <q-img
                                    :src="`${$page.props.public_path}images/logo/2.png`"
                                    fit
                                    width="70px"
                                />
                            </q-item-section>
                            <q-item-section>
                                <q-item-label class="text-bold">
                                    JUNT@S!
                                </q-item-label>
                                <q-item-label>contado</q-item-label>
                                <q-item-label
                                    ><ul class="q-ma-none q-pl-md text-body2">
                                        <li>pago inicial 270 €</li>
                                        <li>4 pagos mensuales de 130 €</li>
                                    </ul></q-item-label
                                >
                                <q-item-label class="text-bold">
                                    790 €
                                </q-item-label>
                                <q-item-label class="text-primary">
                                    ver toda la informacion
                                </q-item-label>
                            </q-item-section>
                            <q-item-section avatar top>
                                <q-input dense outlined style="width: 50px" />
                            </q-item-section>
                            <q-item-section
                                avatar
                                top
                                style="padding: 0px; min-width: 20px"
                            >
                                <btn-delete-component class="q-ml-xs q-mt-xs"
                            /></q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
                <q-card-actions>
                    <q-btn-component
                        label="formalizar"
                        class="full-width"
                        color="black"
                        :flat="false"
                        :round="false"
                        padding="5px"
                    />
                </q-card-actions>
            </q-card>
        </q-menu>
    </q-btn>
</template>

<script setup>
import { ref } from "vue";
import QBtnComponent from "../../base/QBtnComponent.vue";
import BtnLeftRightComponent from "../../btn/BtnLeftRightComponent.vue";
import BtnDeleteComponent from "../../btn/BtnDeleteComponent.vue";
defineOptions({
    name: "CarComponent",
});

const props = defineProps({
    onlyBtn: {
        type: Boolean,
        default: false,
    },
});
const menu = ref(false);
const menuRef = ref(null);
const showDialog = ref(false);

const onClick = () => {
    menu.value.show = true;
};
</script>
