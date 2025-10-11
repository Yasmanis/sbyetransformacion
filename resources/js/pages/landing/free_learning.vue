<template>
    <Layout :header="false">
        <div class="banner bg-primary q-pt-lg">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <img
                        :src="`${$page.props.public_path}images/logo/1.png`"
                        width="180px"
                    />
                </div>
            </div>
            <div class="row">
                <div
                    class="col-md-5 col-sm-12 col-xs-12 text-center"
                    style="z-index: 1"
                >
                    <img
                        :src="`${$page.props.public_path}images/others/free_learning_header.webp`"
                        style="width: 50%; z-index: 9999 !important"
                    />
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12 text-center">
                    <p class="text-h4 no-margin text-white">
                        LIBERACION EMOCIONAL
                    </p>
                    <p class="text-h6 text-white">
                        el primer paso hacia tu transformacion interior
                    </p>
                    <p class="text-white text-h6 q-mt-xl">
                        y si pudieras dejar atras <br />
                        el dolor, las heridas y los bloqueos…<br />
                        y empezar a vivir desde tu verdad mas profunda?
                    </p>
                </div>
            </div>
            <div
                class="wave overflow-hidden"
                :style="{
                    'margin-top': !screen.xs && !screen.sm ? '-130px' : '',
                }"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 1000 100"
                    preserveAspectRatio="none"
                    class="d-block position-relative"
                >
                    <path
                        class="elementor-shape-fill"
                        d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
            c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
            c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"
                    ></path>
                </svg>
            </div>
        </div>
        <div
            class="row items-center container q-py-xl bg-white"
            style="margin-top: -5px"
        >
            <div class="col-md-6 col-sm-12 col-xs-12">
                <p>
                    este minicurso te guia en un proceso practico y profundo
                    para liberar las emociones que aun te atan al pasado,
                    trascender tus heridas y reconectar con lo que tu alma
                    anhela:
                    <b>vivir con autenticidad, alegria, plenitud y libertad</b>
                </p>
                <p>
                    a traves de cinco etapas progresivas, aprenderas a escuchar
                    lo que sientes, soltar lo que duele y abrirte a una nueva
                    forma de vivir. todo desde una guia clara, sencilla, amorosa
                    y profundamente conectada con dios y con tu alma
                </p>
                <div class="text-center q-my-xl">
                    <q-btn
                        color="black"
                        label="quiero empezar ahora"
                        no-caps
                        rounded
                        :href="`/store#product-store-${product?.id}`"
                    >
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                        />
                    </q-btn>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 text-center">
                <img
                    :src="`${$page.props.public_path}images/others/free_learning_book.png`"
                    alt="group-image"
                    style="width: 50%"
                />
            </div>
        </div>
        <div class="row bg-primary container text-white items-center">
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 q-py-md"
                :class="!screen.xs ? 'q-pr-md' : null"
            >
                <p class="text-h5">MI HISTORIA: POR QUE NACIO ESTE CURSO</p>
                <p>
                    durante años acompañe a personas a sanar… pero no fue hasta
                    que pase por mi propia transformacion emocional, que
                    comprendi lo esencial:
                    <b>no hay cambio real sin liberar lo que llevamos dentro</b>
                </p>
                <p>
                    este curso nacio de mi camino, de lo que me sirvio a mi y a
                    quienes ya lo han recorrido conmigo
                </p>
                <p>
                    aqui no solo aprenderas herramientas, sino una forma
                    completamente nueva de vivirte
                </p>
            </div>
            <div
                class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 q-py-md text-center"
            >
                <video-player
                    :src="`${$page.props.public_path}media/mi-historia-liberacion-emocional.mp4`"
                    :poster="`${$page.props.public_path}images/others/free-learning-poster-maria.webp`"
                    controls
                    :volume="0.6"
                    aspectRatio="16:9"
                />
            </div>
        </div>
        <div class="row container q-py-lg">
            <div class="col">
                <p class="text-h6">QUE ENCONTRARAS EN ESTE MINICURSO?</p>
                <p>
                    un recorrido practico y profundo en 5 etapas, para que
                    liberes tu carga emocional y transformes tu forma de sentir,
                    pensar y vivir puedes hacerlo a tu ritmo. cada etapa te
                    invita a soltar una capa mas de lo que ya no te sirve.
                    <i
                        >cada paso es un escalon hacia una mayor libertad
                        interna</i
                    >
                </p>
            </div>
        </div>
        <div
            class="row container q-mb-sm"
            v-for="(img, indexImg) in images"
            :key="`image-${indexImg}`"
            ref="imageContainers"
        >
            <div class="col self-center">
                <div class="image-with-text-container">
                    <q-img
                        :src="`${$page.props.public_path}images/others/${img.image}`"
                        class="responsive-image"
                        :class="
                            img.visible
                                ? indexImg % 2 === 0
                                    ? 'animate__animated animate__slower animate__slideInLeft opacity-animation'
                                    : 'animate__animated animate__slower animate__slideInRight opacity-animation'
                                : null
                        "
                        fit="fill"
                        :height="getHeight(indexImg + 1)"
                        :id="`image-${indexImg + 1}`"
                    >
                        <div
                            class="text-overlay"
                            :id="`background-${indexImg + 1}`"
                        >
                            <h2 class="text-h5 text-bold" :class="img.color">
                                {{ img.title }}
                            </h2>
                            <span
                                class="text-body1"
                                :class="img.color"
                                v-html="img.description"
                            >
                            </span>
                        </div>
                    </q-img>
                </div>
            </div>
        </div>

        <div class="row container q-py-lg">
            <div class="col">
                <p>
                    <img
                        :src="`${$page.props.public_path}images/icon/double-time.png`"
                        style="position: absolute"
                    />
                    <span style="margin-left: 40px"
                        >cada modulo incluye ejemplos reales, ejercicios
                        practicos y reflexiones que te acompañaran de forma
                        sencilla y cercana</span
                    >
                </p>
            </div>
        </div>
        <div class="row container bg-primary text-white q-py-lg">
            <div class="col">
                <p class="text-h6">ESTO ES LO QUE PUEDES TRANSFORMAR</p>
                <p>no estas aqui por casualidad. este curso te va a ayudar a</p>
                <p>
                    🦋 dejar de reaccionar desde el dolor y empezar a responder
                    desde el amor <br />
                    🦋 reconocer tus heridas y soltar lo que te limita, con
                    compasion y verdad<br />
                    🦋 dejar atras la culpa, la rabia, la tristeza o la
                    sensacion de vacio<br />
                    🦋 convertirte en quien tu alma anhela ser: una persona
                    autentica, libre y plena
                </p>
                <div class="text-center">
                    <q-btn
                        color="black"
                        label="quiero vivir esta transformacion"
                        no-caps
                        rounded
                        :href="`/store#product-store-${product?.id}`"
                    >
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                        />
                    </q-btn>
                </div>
            </div>
        </div>
        <div class="row container q-py-lg">
            <div class="col">
                <p class="text-h6">OFERTA ESPECIAL DE LANZAMIENTO: SOLO 19 €</p>
                <p>
                    este curso esta pensado para personas como tu: sensibles,
                    comprometidas, listas para liberarse del dolor y vivir desde
                    su verdad
                </p>
                <p>
                    por eso, durante este lanzamiento, puedes acceder al curso
                    completo + acompañamiento por chat por solo <b>19 €</b> y si
                    en los proximos <b>30 dias</b> compartes tu experiencia
                    <br />
                    <b
                        >te regalo el acceso al plan premium (valorado en 150
                        €)</b
                    >
                    🎁<br />
                    incluye <br />
                    • 3 respuestas personalizadas en video <br />• 1 sesion
                    individual de 1 hora conmigo<br />
                    <b>es mi forma de agradecerte y acompañarte mas de cerca</b>
                    en tu camino hacia la libertad emocional
                </p>
                <hr />
                <p>⏳️ disponible solo por tiempo limitado</p>
                <p>
                    esta propuesta estara activa
                    <b
                        >solo durante los proximos dias o hasta completar el
                        cupo inicial de plazas disponibles</b
                    >
                </p>
                <p>
                    despues, el curso volvera a su precio real y sin esta opcion
                    de regalo
                </p>
                <p>
                    haz clic aqui para unirte ahora y comenzar tu transformacion
                    👇️
                </p>
                <q-card style="border: 1px solid #000; width: 300px">
                    <q-card-section class="no-padding">
                        <q-list dense>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center q-pt-md">
                                        🌱
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center q-pb-sm">
                                        plan basico
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        🎓️ curso completo
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        💬 acompañamiento por chat
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item style="padding: 0">
                                <q-item-section
                                    class="text-center bg-black text-white q-py-xs q-my-md"
                                >
                                    <q-item-label> 19 € </q-item-label>
                                    <q-item-label>
                                        precio de lanzamiento
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                        </q-list>
                    </q-card-section>
                </q-card>

                <p class="q-pt-md">
                    <img
                        :src="`${$page.props.public_path}images/others/right-arrow.png`"
                        class="animate__animated animate__slower opacity-animation"
                        :class="arrowsVisible ? ' animate__fadeIn' : null"
                        style="width: 70px; margin-bottom: -20px"
                    />
                    <span
                        class="q-mx-lg animate__animated animate__slower opacity-animation animate__delay-1s"
                        :class="arrowsVisible ? ' animate__fadeIn' : null"
                        >con tu testimonio en 30 dias</span
                    >
                    <img
                        :src="`${$page.props.public_path}images/others/down-arrow.png`"
                        class="q-mt-lg animate__animated animate__slower opacity-animation animate__delay-2s"
                        :class="arrowsVisible ? ' animate__fadeIn' : null"
                        style="width: 50px; margin-bottom: -30px"
                    />
                </p>
                <img
                    ref="arrowsContainer"
                    :src="`${$page.props.public_path}images/others/level-up.png`"
                    class="q-ml-xl q-mt-sm animate__animated animate__slower opacity-animation animate__delay-3s"
                    :class="arrowsVisible ? ' animate__fadeIn' : null"
                    style="width: 35%"
                />

                <p>🎁 accedes al...</p>
                <q-card style="border: 1px solid #000; width: 300px">
                    <q-card-section class="no-padding">
                        <q-list dense>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center q-pt-md">
                                        🌺
                                    </q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center q-pb-sm">
                                        plan premium
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        🎓️ curso completo
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        💬 acompañamiento por chat
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        + 3 respuestas personalizadas en video
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item>
                                <q-item-section>
                                    <q-item-label class="text-center">
                                        👥 1 sesion individual de 1h
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                            <q-item style="padding: 0">
                                <q-item-section>
                                    <q-item-label
                                        class="text-white bg-black text-center q-py-sm q-my-lg"
                                    >
                                        ✨️ sin coste adicional
                                    </q-item-label></q-item-section
                                >
                            </q-item>
                        </q-list>
                    </q-card-section>
                </q-card>
                <div class="col-12 text-center q-mt-md">
                    <q-btn
                        color="black"
                        label="empezar ahora"
                        no-caps
                        rounded
                        :href="`/store#product-store-${product?.id}`"
                    >
                        <q-icon
                            name="fa fa-long-arrow-right"
                            size="xs"
                            class="q-ml-md"
                        />
                    </q-btn>
                </div>
            </div>
        </div>
        <div class="container bg-primary q-py-lg">
            <div class="row">
                <div class="col">
                    <p class="text-h6 text-white">PRECIOS Y PLANES</p>
                </div>
            </div>
            <div class="row">
                <div
                    class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12"
                    :class="screen.xs ? 'q-py-sm' : 'q-pr-md'"
                >
                    <q-card style="border: 1px solid #000">
                        <q-card-section class="no-padding">
                            <q-list dense>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pt-md"
                                        >
                                            🌱
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pb-sm"
                                        >
                                            plan basico
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            🎓️ curso completo
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            💬 acompañamiento por chat
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item />
                                <q-item />
                                <q-item style="padding: 0">
                                    <q-item-section>
                                        <q-item-label
                                            class="text-white bg-black text-center q-py-sm q-my-lg"
                                        >
                                            45 €
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div
                    class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12"
                    :class="screen.xs ? 'q-py-sm' : null"
                >
                    <q-card style="border: 1px solid #000">
                        <q-card-section class="no-padding">
                            <q-list dense>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pt-md"
                                        >
                                            🌿
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pb-sm"
                                        >
                                            plan esencial
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            🎓️ curso completo
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            💬 acompañamiento por chat
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            + 3 respuestas personalizadas en
                                            video
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item />
                                <q-item style="padding: 0">
                                    <q-item-section>
                                        <q-item-label
                                            class="text-white bg-black text-center q-py-sm q-my-lg"
                                        >
                                            75 €
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
                <div
                    class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12"
                    :class="
                        screen.xs
                            ? 'q-py-sm'
                            : screen.sm
                            ? 'q-py-md q-pr-md'
                            : 'q-pl-md'
                    "
                >
                    <q-card style="border: 1px solid #000">
                        <q-card-section class="no-padding">
                            <q-list dense>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pt-md"
                                        >
                                            🌺
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label
                                            class="text-center q-pb-sm"
                                        >
                                            plan premium
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            🎓️ curso completo
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            💬 acompañamiento por chat
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            + 3 respuestas personalizadas en
                                            video
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-section>
                                        <q-item-label class="text-center">
                                            👥 1 sesion individual de 1h
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                                <q-item style="padding: 0">
                                    <q-item-section>
                                        <q-item-label
                                            class="text-white bg-black text-center q-py-sm q-my-lg"
                                        >
                                            150 €
                                        </q-item-label></q-item-section
                                    >
                                </q-item>
                            </q-list>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-white q-pt-md">
                        🎁 todos los planes incluyen prioridad de acceso al
                        taller grupal online de 3 meses
                    </p>
                </div>
            </div>
        </div>
        <div class="row bg-white container q-py-lg">
            <div class="col">
                <p class="text-h6">
                    EL SIGUIENTE PASO: TALLER ONLINE DE 3 MESES
                </p>
                <p>
                    si tras realizar el minicurso deseas profundizar, podras
                    sumarte al programa grupal intensivo
                </p>
                <ul class="q-pl-lg">
                    <p style="margin-left: -20px; margin-bottom: 5px">
                        <b>incluye</b>
                    </p>
                    <li>
                        2 sesiones semanales en grupo para revisar ejercicios y
                        resolver dudas
                    </li>
                    <li>seguimiento personal y practica guiada con el grupo</li>
                    <li>
                        1 consulta individual conmigo, con informe final
                        personalizado
                    </li>
                    <li>acompañamiento para tu transformacion integral</li>
                </ul>
                <p class="q-mt-lg">
                    <i>
                        tiene prioridad quienes hayan realizado un minicurso o
                        leido el libro
                    </i>
                </p>
            </div>
        </div>
        <div class="row bg-primary text-white container q-py-lg">
            <div class="col-12">
                <p class="text-h6">LO QUE DICEN DE MI TRABAJO</p>
                <p class="text-justify">
                    cada persona que he acompañado me ha mostrado que, cuando
                    alguien se atreve a mirar dentro, el cambio es inevitable
                </p>
                <p class="text-justify">
                    estas son algunas voces reales que han vivido esta
                    transformacion a traves de sesiones, de mi libro o de mis
                    conferencias
                </p>
                <hr style="width: 100%; height: 1px; background: #fff" />
                <p class="text-h6 q-pt-md">video testimonio destacado</p>
                <div class="row q-col-gutter-sm items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <video-player
                            :src="`${$page.props.public_path}media/testimonio-destacado.mp4`"
                            controls
                            :volume="0.6"
                            aspectRatio="16:9"
                        />
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <p
                            class="text-justify"
                            :class="!Screen.xs ? 'q-px-xl' : null"
                        >
                            ella vivio un proceso de liberacion emocional
                            durante varios dias de trabajo intensivo. lo que
                            cuenta es parte de lo que tambien puedes empezar a
                            vivir en este minicurso
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr style="width: 100%; height: 1px; background: #fff" />
                <p class="text-h6 q-pt-md q-mb-none">testimonios destacados</p>
                <br />
            </div>

            <div class="col-12 text-black self-center">
                <q-carousel
                    v-model="slide"
                    transition-prev="slide-right"
                    transition-next="slide-left"
                    swipeable
                    animated
                    control-color="black"
                    arrows
                    class="bg-primary q-pa-none"
                    style="height: 280px"
                >
                    <q-carousel-slide
                        v-for="(slideGroup, index) in groupedSlides"
                        :key="index"
                        :name="index"
                        class="row no-wrap q-pa-none"
                    >
                        <q-card
                            v-for="(t, imgIndex) in slideGroup"
                            :key="imgIndex"
                            bordered
                            class="my-card q-ma-sm rounded"
                            style="
                                border: 1px solid rgb(64, 116, 146);
                                width: 300px;
                                height: 250px;
                            "
                        >
                            <q-card-section
                                class="q-pa-sm q-pa-none text-center"
                            >
                                <q-img
                                    :src="`${$page.props.public_path}images/icon/heart.png`"
                                    fit="fill"
                                    width="50px"
                                />
                            </q-card-section>
                            <q-card-section
                                class="q-pa-sm q-pa-none text-center text-black"
                            >
                                <span v-html="t.description"></span>
                            </q-card-section>
                            <q-card-section class="text-center">
                                <q-item-label>
                                    {{ t.user }}
                                </q-item-label>
                            </q-card-section>
                        </q-card>
                    </q-carousel-slide>
                </q-carousel>
            </div>
            <template v-if="rowsTestimonies > 0">
                <div class="col-12">
                    <div class="row text-black">
                        <div
                            v-for="(
                                t, indexWebTestimony
                            ) in webTestimonies.slice(
                                0,
                                rowsTestimonies * slidesPerView
                            )"
                            :key="indexWebTestimony"
                            class="col-xs-12 col-sm-6 col-md-4 col-lg-3"
                        >
                            <q-card
                                bordered
                                class="my-card q-ma-sm rounded"
                                style="
                                    border: 1px solid rgb(64, 116, 146);
                                    width: 300px;
                                "
                            >
                                <q-card-section
                                    class="q-pa-sm q-pa-none text-center"
                                >
                                    <q-img
                                        :src="`${$page.props.public_path}images/icon/heart.png`"
                                        fit="fill"
                                        width="50px"
                                    />
                                </q-card-section>
                                <q-card-section
                                    class="q-pa-sm q-pa-none text-center text-black"
                                >
                                    <span v-html="t.message"></span>
                                </q-card-section>
                                <q-card-section class="text-center">
                                    <q-card-section class="text-center">
                                        <q-item-label v-if="t.anonimous">
                                            <i>publicado como anonimo</i>
                                        </q-item-label>
                                        <q-item-label
                                            v-else-if="t.name_to_show"
                                        >
                                            {{ t.name_to_show }}
                                        </q-item-label>
                                        <q-item-label v-else>
                                            {{ t.user.full_name }}
                                        </q-item-label>
                                    </q-card-section>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </div>
            </template>
            <div class="col-12 text-center q-mt-xl">
                <q-btn
                    color="black"
                    no-caps
                    rounded
                    :disable="
                        rowsTestimonies * slidesPerView >=
                            webTestimonies.length || webTestimonies.length === 0
                    "
                    @click="rowsTestimonies++"
                >
                    ver mas testimonios <br />
                    de personas que han <br />
                    vivido este proceso
                    <q-icon
                        name="fa fa-long-arrow-down"
                        size="md"
                        class="q-ml-md"
                    />
                </q-btn>
            </div>
        </div>

        <div class="row bg-white container q-py-lg">
            <div class="col-12">
                <p class="text-h6">EMPIEZA HOY</p>
                <p class="q-py-md">tu alma ya sabe que estas listo</p>
                <p>
                    si lo sientes, haz clic abajo y empieza este camino de
                    regreso a ti mismo
                </p>
            </div>
            <div class="col-12 text-center q-mt-md">
                <q-btn
                    color="black"
                    label="quiero empezar ahora"
                    no-caps
                    rounded
                    :href="`/store#product-store-${product?.id}`"
                >
                    <q-icon
                        name="fa fa-long-arrow-right"
                        size="xs"
                        class="q-ml-md"
                    />
                </q-btn>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";
import { ref, computed, watch, onMounted, onUnmounted } from "vue";
import { useQuasar, dom, Screen } from "quasar";

import { VideoPlayer } from "@videojs-player/vue";
import "video.js/dist/video-js.css";
import { usePage } from "@inertiajs/vue3";

defineOptions({
    name: "VivirEnPlenitud",
});

const $q = useQuasar();
const { height, css, ready } = dom;

const images = ref([
    {
        title: "🌪️ ETAPA 1: LIBERAR EMOCIONES INTENSAS",
        description:
            "aprende a soltar emociones como la rabia, la tristeza o la frustracion <br>ejercicios fisicos y expresivos para liberar lo que el cuerpo guarda",
        image: "background_1.png",
        color: "text-white",
        visible: false,
    },
    {
        title: "🌫️ ETAPA 2: LIBERAR EMOCIONES SUTILES",
        description:
            "conecta con lo que te molesta sin saber por que<br>introspeccion guiada para reconocer señales internas que suelen pasar desapercibidas",
        image: "background_2.png",
        color: "text-black",
        visible: false,
    },
    {
        title: "🧬 ETAPA 3: LIBERAR EMOCIONES INCONSCIENTES",
        description:
            "descubre lo que te duele y aun no sabias<br>herramientas de autoexploracion emocional y regresiva para liberar patrones antiguos",
        image: "background_3.png",
        color: "text-white",
        visible: false,
    },
    {
        title: "🧠 ETAPA 4: DESPROGRAMAR EL EGO",
        description:
            "identifica las creencias que sostienen tu dolor y empieza a soltarlas<br>transforma tu forma de pensar, sentir y actuar desde una mayor conciencia",
        image: "background_4.png",
        color: "text-black",
        visible: false,
    },
    {
        title: "💫 ETAPA 5: VIVIR DESDE TU ESENCIA",
        description:
            "aprende a confiar, a fluir y a vivir sin miedo ni mascaras<br>accede a tu guia interior (llamala intuicion, claridad o dios) y actua en coherencia contigo",
        image: "background_5.png",
        color: "text-black",
        visible: false,
    },
]);

const webTestimonies = ref([]);

const staticTestimonies = [
    {
        user: "Rosa",
        description:
            "me habló directo a mí, como si alguien al fin pusiera en palabras muchas cosas que había sentido pero no sabía cómo entender.",
    },
    {
        user: "Cristina",
        description:
            "desde el principio sentí que este libro hablaba de mí. ya me ha removido muchas cosas y quiero seguir con los otros tomos.",
    },
    {
        user: "Mariluz",
        description:
            "compré el libro tras una conferencia y me encantó. es diferente a todo lo que he leído. además, los vídeos ayudan muchísimo.",
    },
    {
        user: "Silvia",
        description:
            "este libro me abrió a reflexionar sobre aspectos de la vida que nunca había considerado. tengo muchas ganas de seguir con los siguientes",
    },
    {
        user: "Marcos López Garriga",
        description:
            "aunque no lo he leído entero, sé que dice la verdad. lo he vivido en carne propia, y este libro refleja esa voz que me ha transformado",
    },
    {
        user: "testimonio de sesión intensiva (video anterior)",
        description:
            "me ayudó a ver cómo mis emociones están ligadas a mi cuerpo. hoy sé reconocer lo que siento y liberarlo",
    },
];

const imageContainers = ref([]);
const arrowsContainer = ref(null);
const arrowsVisible = ref(false);
const slide = ref(0);
const slidesPerView = ref(4);
const rowsTestimonies = ref(0);
const page = usePage();
const product = ref(null);

onMounted(() => {
    const observer = setupObservers();
    const arrows = arrowsObservers();
    setTestimonyWidth();
    webTestimonies.value = page.props.testimonies;
    product.value = page.props.product;
    onUnmounted(() => {
        observer.disconnect();
        arrows.disconnect();
    });
});

watch(
    () => $q.screen.width,
    (w) => {
        setImagesSize();
        setTestimonyWidth();
    }
);

const setTestimonyWidth = () => {
    slidesPerView.value =
        $q.screen.width < 350 ? 1 : parseInt($q.screen.width / 350);
};

const groupedSlides = computed(() => {
    const groups = [];
    for (let i = 0; i < staticTestimonies.length; i += slidesPerView.value) {
        groups.push(staticTestimonies.slice(i, i + slidesPerView.value));
    }
    return groups;
});

ready(function () {
    let div, image;
    for (let i = 1; i <= 5; i++) {
        div = document.getElementById(`background-${i}`);
        image = document.getElementById(`image-${i}`);
        if (div) {
            css(image, {
                height: `${height(div) + 50}px !important`,
            });
        }
    }
});

const setupObservers = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const index =
                    [...entry.target.parentElement.children].indexOf(
                        entry.target
                    ) - 4;
                if (index !== -1) {
                    if (entry.isIntersecting) {
                        images.value[index].visible = true;
                    }
                }
            });
        },
        { threshold: 0.1 }
    );

    imageContainers.value.forEach((el) => {
        if (el) observer.observe(el);
    });

    return observer;
};

const arrowsObservers = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const index =
                    [...entry.target.parentElement.children].indexOf(
                        entry.target
                    ) - 4;
                if (index !== -1) {
                    if (entry.isIntersecting) {
                        arrowsVisible.value = true;
                    }
                }
            });
        },
        { threshold: 0.1 }
    );

    observer.observe(arrowsContainer.value);

    return observer;
};

const screen = computed(() => {
    return $q.screen;
});

function setImagesSize() {
    let div, image;
    for (let i = 1; i <= 5; i++) {
        div = document.getElementById(`background-${i}`);
        image = document.getElementById(`image-${i}`);
        if (div) {
            css(image, {
                height: `${height(div) + 50}px !important`,
            });
        }
    }
}

const getHeight = (id) => {
    let div = document.getElementById(`background-${id}`);
    return div ? `${height(div) + 50}px` : "160px";
};
</script>
<style scoped>
.wave {
    left: 0;
    line-height: 0;
    bottom: -1px;
}

.wave svg {
    width: calc(100% + 1.3px);
    left: 50%;
    transform: translateX(-50%);
}

.position-relative {
    position: relative !important;
}

.d-block {
    display: block !important;
}

svg {
    vertical-align: middle;
}

.z-0 {
    z-index: 0 !important;
}

.w-100 {
    width: 100% !important;
}

.overflow-hidden {
    overflow: hidden !important;
}

.wave .elementor-shape-fill {
    fill: #fff;
    transform-origin: center;
    transform: rotateY(0deg);
}

.image-with-text-container {
    position: relative;
    width: 100%;
}

.responsive-image {
    width: 100%;
    display: block;
}

.text-overlay {
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    padding: 16px;
    background: transparent !important;
}

.text-overlay-centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    width: 80%;
}

.animate__slideInLeft.opacity-animation {
    animation-name: customSlideInLeft;
}

@keyframes customSlideInLeft {
    from {
        transform: translate3d(-100%, 0, 0);
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }
}

/* Para la animación slideInRight con opacidad */
.animate__slideInRight.opacity-animation {
    animation-name: customSlideInRight;
}

@keyframes customSlideInRight {
    from {
        transform: translate3d(100%, 0, 0);
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }
}
</style>
