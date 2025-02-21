<template>
    <q-dialog v-model="showDialog" persistent>
        <q-card class="bg-custom-blue">
            <dialog-header-component closable :separator="false" />
            <q-card-section class="q-pt-none" style="margin-top: -15px">
                <div v-if="showResults">
                    <p class="text-bold">resultados: que te impide aprender?</p>
                    <template
                        v-for="(r, result) in results"
                        :key="`result-${result}`"
                    >
                        <span v-html="answers[r]"></span>
                    </template>
                    <p class="text-bold text-justify">
                        📩 hemos analizado tus respuestas. descubre como superar
                        tus bloqueos descargando la guia exclusiva que recibiras
                        por email
                    </p>
                </div>
                <q-form ref="formRef" v-else>
                    <p class="text-bold">
                        TEST: DESCUBRE QUE TE IMPIDE APRENDER Y CRECER
                    </p>
                    <p class="text-justify">
                        responde estas preguntas con sinceridad y descubre que
                        bloqueos pueden estar frenando tu evolucion personal.
                        marca la respuesta que mejor refleje tu situacion
                    </p>
                    <ol class="q-pb-none q-mb-none">
                        <li
                            v-for="(q, question) in questions"
                            :key="`question-${question}`"
                        >
                            <b>{{ q.title }}</b>
                            <q-option-group
                                v-model="model[`question_${question + 1}`]"
                                :options="q.answers"
                                dense
                                class="q-pb-md"
                                :rules="[
                                    (val) =>
                                        !!val ||
                                        'Por favor, selecciona una opción',
                                ]"
                            />
                        </li>
                    </ol>
                </q-form>
            </q-card-section>
            <q-card-actions align="center" class="q-mb-sm">
                <q-btn
                    no-caps
                    color="black"
                    label="ver resultados!"
                    padding="8px 25px"
                    @click="showResultsIfCorrect"
                    v-if="!showResults"
                >
                </q-btn>
                <q-btn
                    no-caps
                    color="black"
                    label="cerrar!"
                    padding="8px 25px"
                    @click="showDialog = false"
                    v-if="showResults"
                >
                </q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, watch } from "vue";
import DialogHeaderComponent from "../base/DialogHeaderComponent.vue";
import { error } from "../../helpers/notifications";
defineOptions({
    name: "SubscriptionTest",
});

const showDialog = ref(true);
const formRef = ref(null);
const model = ref({
    question_1: null,
    question_2: null,
    question_3: null,
    question_4: null,
    question_5: null,
});
const showResults = ref(false);
const results = ref([]);
const answers = ref({
    a: "<b>mentalidad de crecimiento</b><br> <p class='text-justify'>felicidades! tienes una actitud positiva hacia el aprendizaje y estas abierto a mejorar. sigue cultivando esta mentalidad</p>",
    b: "<b>autoexigencia bloqueante</b><br> <p class='text-justify'>felicidades! te esfuerzas, pero a veces te presionas demasiado. recuerda que aprender es un proceso y esta bien no hacerlo perfecto desde el inicio</p>",
    c: "<b>miedo al fracaso</b><br> <p class='text-justify'>el temor a equivocarte te frena. trabaja en aceptar que el error es parte natural del aprendizaje</p>",
    d: "<b>creencias limitantes</b><br> <p class='text-justify'>sientes que no eres capaz de aprender y eso te detiene. es importante desafiar estas creencias y abrirte a nuevas experiencias</p>",
});

const questions = [
    {
        title: "cuando te enfrentas a un nuevo aprendizaje...",
        key: "question_1",
        answers: [
            {
                label: "a) me emociono y lo afronto con curiosidad",
                value: "a",
            },
            {
                label: "b) me cuesta, pero lo intento con esfuerzo",
                value: "b",
            },
            {
                label: "c) me frustro rapidamente si no entiendo algo de inmediato",
                value: "c",
            },
            {
                label: "d) siento que no vale la pena intentarlo, seguramente no sere bueno en ello",
                value: "d",
            },
        ],
    },
    {
        title: "cuando alguien me corrige o señala un error...",
        key: "question_2",
        answers: [
            {
                label: "a) aprecio la critica y trato de mejorar",
                value: "a",
            },
            {
                label: "b) me siento incomodo, pero lo considero",
                value: "b",
            },
            {
                label: "c) me molesta y tiendo a justificarme",
                value: "c",
            },
            {
                label: "d) me lo tomo como un ataque y me desmotivo",
                value: "d",
            },
        ],
    },
    {
        title: "que papel juega el miedo en tu proceso de aprendizaje?",
        key: "question_3",
        answers: [
            {
                label: "a) no me afecta, lo veo como parte del proceso",
                value: "a",
            },
            {
                label: "b) a veces me limita, pero trato de enfrentarlo",
                value: "b",
            },
            {
                label: "c) me paraliza y evito situaciones donde pueda fracasar",
                value: "c",
            },
            {
                label: "d) evito aprender cosas nuevas por temor al ridiculo o al fracaso",
                value: "d",
            },
        ],
    },
    {
        title: "como te hablas a ti mismo cuando te equivocas?",
        key: "question_4",
        answers: [
            {
                label: "a) esta bien, así aprendo",
                value: "a",
            },
            {
                label: "b) deberia haberlo hecho mejor, pero puedo intentarlo otra vez",
                value: "b",
            },
            {
                label: "c) soy un desastre, nunca lo lograre",
                value: "c",
            },
            {
                label: "d) siempre fallo, no soy capaz de cambiar",
                value: "d",
            },
        ],
    },
    {
        title: "cuando te comparas con otros que saben mas que tu...",
        key: "question_5",
        answers: [
            {
                label: "a) me inspiro y aprendo de ellos",
                value: "a",
            },
            {
                label: "b) me siento inseguro, pero trato de mejorar",
                value: "b",
            },
            {
                label: "c) me desanimo y pienso que nunca sere como ellos",
                value: "c",
            },
            {
                label: "d) siento envidia y evito el tema",
                value: "d",
            },
        ],
    },
];

watch(
    model,
    (n) => {
        updateResults();
    },
    { deep: true }
);

const updateResults = () => {
    let letters = ["a", "b", "c", "d"];
    let temp = [];
    for (let i = 0; i < letters.length; i++) {
        temp.push({
            name: letters[i],
            value: 0,
        });
    }
    for (let i = 1; i <= 5; i++) {
        let q = model.value[`question_${i}`];
        if (q !== null) temp.find((a) => a.name === q).value++;
    }

    let max = Math.max(...temp.map((t) => t.value));
    results.value = temp.filter((t) => t.value === max).map((r) => r.name);
};

const showResultsIfCorrect = () => {
    let correct = true;
    for (let i = 1; i <= 5; i++) {
        let q = model.value[`question_${i}`];
        if (q === null) {
            correct = false;
            break;
        }
    }
    if (correct) {
        showResults.value = true;
    } else {
        error("por favor responda todas las preguntas para continuar");
    }
};
</script>
