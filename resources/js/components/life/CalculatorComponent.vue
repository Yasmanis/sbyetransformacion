<template>
    <q-card>
        <q-card-section>
            <p class="text-bold">mi plenitud</p>
            <p>descubre como estas viviendo tu vida</p>
            <div class="text-center">
                <q-btn
                    color="black"
                    label="calcular"
                    no-caps
                    @click="showDialog = true"
                />
            </div>
        </q-card-section>
    </q-card>

    <q-dialog v-model="showDialog" persistent full-width>
        <q-card>
            <dialog-header-component
                icon="mdi-calculator"
                title="observa como estas viviendo tu vida"
                closable
                @close="showDialog = false"
            />
            <q-card-section
                style="max-height: 70vh"
                class="scroll q-gutter-y-md"
            >
                <p class="text-center">
                    añade las actividades que forman parte de un dia habitual
                    <br />
                    y responde a cada pregunta con sinceridad
                </p>
                <p class="text-center">
                    primero piensa, despues siente y, por ultimo, comprueba con
                    el testeo
                </p>
                <p class="text-center">
                    no busques un resultado. solo observate<br />
                    cuando termines, la calculadora hara el resto
                </p>
                <p class="text-center">
                    esta herramienta esta asociada al ejercicio<br />
                    “trabajo para reflexionar sobre lo que estoy viviendo y como
                    me siento<br />
                    a donde quiero dirigirme, que puedo mejorar y como quiero
                    acabar sintiendome”<br />
                    del tomo III del libro
                </p>
                <q-separator />

                <p class="text-bold">
                    vamos a reconstruir una semana habitual de tu vida
                </p>
                <q-expansion-item
                    v-for="(act, index) in activities"
                    :key="`activity-${act.temp_id}`"
                    class="bg-grey-2 rounded-borders"
                >
                    <template v-slot:header>
                        <q-item-section avatar v-if="activities.length > 1">
                            <btn-delete-component
                                @click="removeActivity(index)"
                            />
                        </q-item-section>
                        <q-item-section class="text-bold">
                            rutina {{ index + 1 }}
                        </q-item-section>
                    </template>
                    <q-card class="bg-grey-2">
                        <q-card-section>
                            <p>
                                que dias de tu semana siguen aproximadamente
                                esta rutina?
                            </p>

                            <checkbox-group-field
                                name="days"
                                :model-value="act.days"
                                :options="dayOptions"
                                inline
                            />

                            <text-field
                                name="always"
                                label="cada dia hago"
                                :model-value="act.always"
                                :othersProps="{
                                    required: true,
                                    disable: true,
                                }"
                            />
                            <time-field
                                name="time"
                                label="tiempo que le dedico"
                                :model-value="act.time"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                            <text-field
                                name="like"
                                label="de esto que hago me gusta que"
                                :model-value="act.like"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                            <text-field
                                name="not_like"
                                label="de esto que hago no me gusta que"
                                :model-value="act.not_like"
                                :othersProps="{
                                    required: true,
                                }"
                            />
                            <p class="text-caption">
                                puntuo de 0 a 10 el nivel de importancia
                            </p>
                            <div class="row q-col-gutter-md">
                                <div
                                    class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                                >
                                    <text-field
                                        name="head"
                                        label="desde la mente"
                                        :model-value="act.points.head"
                                        :othersProps="{
                                            required: true,
                                        }"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                                >
                                    <text-field
                                        name="ayes"
                                        label="sintiendo con los ojos cerrados"
                                        :model-value="act.points.ayes"
                                        :othersProps="{
                                            required: true,
                                        }"
                                    />
                                </div>
                                <div
                                    class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"
                                >
                                    <text-field
                                        name="gold"
                                        label="lo que dice el testeo-dios"
                                        :model-value="act.points.god"
                                        :othersProps="{
                                            required: true,
                                        }"
                                    />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                </q-expansion-item>
                <btn-add-component
                    tooltips="añadir actividad"
                    @click="addActivity"
                />
            </q-card-section>
            <q-separator />
            <q-card-actions align="right">
                <btn-cancel-component @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>
<script setup>
import { ref } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import BtnCancelComponent from "../btn/BtnCancelComponent.vue";
import SelectField from "../form/input/SelectField.vue";
import CheckboxGroupField from "../form/input/CheckboxGroupField.vue";
import TextField from "../form/input/TextField.vue";
import TimeField from "../form/input/TimeField.vue";
import BtnAddComponent from "../btn/BtnAddComponent.vue";
import BtnDeleteComponent from "../btn/BtnDeleteComponent.vue";

const showDialog = ref(false);

const days = [
    "lunes",
    "martes",
    "miercoles",
    "jueves",
    "viernes",
    "sabado",
    "domingo",
];

const dayOptions = days.map((d) => {
    return {
        label: d,
        value: d,
    };
});

let nextId = 1;

const defaultActivity = {
    days: [],
    always: "dormir",
    time: null,
    like: null,
    not_like: null,
    points: {
        head: null,
        ayes: null,
        god: null,
    },
};

const activities = ref([{ temp_id: nextId++, ...defaultActivity }]);

const addActivity = () => {
    activities.value.push({
        temp_id: nextId++,
        ...defaultActivity,
    });
};

const removeActivity = (index) => {
    activities.value.splice(index, 1);
};
</script>
