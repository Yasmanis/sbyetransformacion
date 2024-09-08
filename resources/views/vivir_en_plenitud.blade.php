@extends('layouts.main')

@section('content')
<section class="banner position-relative pb-0 bg-company" style="background-image: none">
        <div class="container">
            <div class="inner-banner position-relative text-white">
                <div class="row">
                    <div class="col-lg-6 order-2 order-lg-1" style="z-index: 9;">
                        <div class="banner-left text-center" style="padding-bottom: 34px;">
                            <img src="{{ asset('images/team/maria.png') }}" alt="banner-image" class="w-60"><br>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="banner-right  ms-2 text-center text-lg-start py-10">
                            <div class="banner-title pb-3 text-center">
                                <span class="text-white header-title" style="font-size: 33px; line-height: 1">LIBERACION EMOCIONAL</span> <br>
                                <span class="text-white text-lowercase" style="font-size: 22px">la puerta para</span> <br>
                                <span class="text-white header-title" style="font-size: 44px; line-height: 1">VIVIR EN PLENITUD</span> <br>
                                <span class="text-white text-lowercase" style="font-size: 22px">con la intervencion directa de dios</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave overflow-hidden position-absolute w-100 z-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"
                class="d-block position-relative">
                <path class="elementor-shape-fill" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
            c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
            c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"></path>
            </svg>
        </div>
    </section>

    <section class="overview pb-8">
        <div class="container">
            <div class="inner-overview position-relative">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="overview-left text-center text-lg-start">
                            <div class="overview-title pb-4">
                                <P>la complejidad de nuestras emociones junto con el desarrollo de nuestra mente es lo
                                    que nos hace
                                    seres singulares con respecto al resto de la existencia comprender estas emociones,
                                    aceptarlas y
                                    liberar el sufrimiento es fundamental para trascender nuestra personalidad y
                                    alcanzar la existencia en
                                    plenitud</p>
                                <p>vive en plenitud una persona que consigue equilibrar la trilogia cuerpo-mente-dios,
                                    por lo que,
                                    dialogar con dios es un requisito para vivir en plenitud y asi me lo ha dicho de
                                    forma directa dios
                                    que fue quien me insto a escribir este libro</p>
                                <p>todo lo que digo en este libro esta directamente inspirado por dios
                                    a traves de mi pensamiento que fue guiado en todo momento por el/ella/ello.
                                    despertar es hablar con
                                    dios, es tener la certeza de que tu eres dios en accion, dios materializado a traves
                                    de ti, que tu
                                    eres el instrumento de dios para experimentarse a si mismo a traves de ti</p>
                                <p>este libro desarrolla a traves de mi propia vivencia el libro de neale donald walsch
                                    <em>conversaciones con dios</em>
                                </P>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset('images/books/tree-books.png') }}" alt="group-image" class="w-80 rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog pt-0">
        <div class="container">
            <div class="blog-inner">
                <div class="blog-content">
                    <div class="row">
                        <div class=" col-lg-4 p-4 pb-0">
                            <div class="blog-box pb-2">
                                <div class="text-center">
                                    <img class="blog-img" src="{{ asset('images/books/book-1.png') }}" style="width: 270px; height: 340px;">
                                    <h6 class="pt-4 text-lowercase">en el tomo 1</h6>
                                </div>
                                <p class="p-4 pt-0 m-0" style="text-align: justify;"><small>abordo la parte mas
                                        teorica de como
                                        funcionan nuestra mente y nuestras emociones; como existe un dominio emocional
                                        sobre la parte
                                        recional y como el inconsciente, que comienza a forjarse en nuestra infancia y
                                        gestacion, nos
                                        condiciona sin darnos cuenta, produciendo nuestros patrones de proteccion y
                                        autoengaño para superar
                                        los traumas y sinsabores de la vida. en realidad, estoy poniendo las bases para
                                        comprender como se
                                        gesta nuestra personalidad, llena de programas inconscientes que nos impiden
                                        vivir en plenitud y
                                        como llegar a desprogramar estos, liberar nuestras emociones y convertir nuestro
                                        ego programado por
                                        otros, en un ego conectado con nuestra esencia divina</small></p>
                                <div class="p-4 pt-0 m-0">
                                    <p class="text-center text-lowercase m-0">SUMARIO</p>
                                    <span>PARTE I VIVIENDO PLENAMENTE</span>
                                    <ul class="summary" id="tomo1-minus">
                                        <li>cambiemos soy por estoy siendo</li>
                                        <li>el cambio</li>
                                        <li>mente y sus emociones vinculadas</li>
                                    </ul>
                                    <div style="display: none" id="tomo1-more">
                                        <ul class="summary">
                                        <li>cambiemos soy por estoy siendo</li>
                                        <li>el cambio</li>
                                        <li>mente y sus emociones vinculadas</li>
                                        <li> la adiccion de nuestras emociones </li>
                                        <li> la tirania de nuestra mente, el estado perpetuo de cavilacion </li>
                                        <li> el cerebro </li>
                                        <li> la union entre lo que pensamos, lo que nos emocionamos y nuestra salud
                                        </li>
                                        <li> el temor que nos impide vivir en plenitud </li>
                                        <li> la rabia </li>
                                        <li> la sutil diferencia entre ego y personalidad </li>
                                        <li> el apego </li>
                                        <li> lo que es amor y lo que no lo es </li>
                                        <li> el despertar </li>
                                        <li> vivir en plenitud, la verdadera felicidad </li>
                                        <li> Introspectar no es liberar </li>
                                        <li> los pasos que dar para desprogramarnos hasta vivir en plenitud </li>
                                        <ul class="summary">
                                            <li> focalizate </li>
                                            <li> manten una atencion plena constante </li>
                                            <li> manten el rumbo </li>
                                            <li> libera emocionalmente para desprogramar </li>
                                            <li> utiliza los espejos para descubrir tus programas inconscientes </li>
                                        </ul>
                                    </ul>
                                    <span>PARTE II ERES CREADOR DE TU REALIDAD</span>
                                    <ul class="summary">
                                        <li> creamos nuestra vida en un mundo de relatividad </li>
                                        <li> todo es energia, todo es dios </li>
                                        <li> principios de la energia, principios de creacion </li>
                                        <li> porque vivimos realidades que no nos gustan? </li>
                                    </ul>
                                    <span>PARTE III LOS ESPEJOS</span>
                                    <ul class="summary">
                                        <li> espejos emocionales </li>
                                        <ul class="summary">
                                            <li> espejo numero uno: las personas </li>
                                            <li> espejo numero dos, nuestras cosas personalísimas </li>
                                            <li> espejo numero tres: nuestros juicios y opiniones </li>
                                            <li> espejo numero cuatro, la enfermedad el cuerpo, la postura corporal
                                            </li>
                                            <li> espejo numero cinco: otros </li>
                                        </ul>
                                        <li> espejos por creacion de nuestra realidad </li>
                                    </ul>
                                    </div>
                                    <button class="btn btn-read" data-show="false" data-tomo="tomo1">leer mas <i class="fa fa-long-arrow-right ms-4"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-4  p-4 pb-0">
                            <div class="blog-box pb-2">
                                <div class="text-center">
                                    <img class="blog-img" src="{{ asset('images/books/book-2.png') }}" style="width: 320px; height: 340px;">
                                    <h6 class="pt-4 text-lowercase">en el tomo 2</h6>
                                </div>

                                <p class="p-4 pt-0 m-0" style="text-align: justify;"><small>reflexiono sobre distintos
                                        temas que todos
                                        compartimos y sobre los que podemos pensar muy distinto segun lo que hayamos
                                        vivido, nuestras
                                        circunstancias y programaciones. tambien son temas que estan en constante
                                        evolucion historica y, por
                                        tanto, son reflexiones enfocadas en provocar que pienses sobre estos asuntos y
                                        que aprendas de este
                                        modo a flexibilizar tu mente, sobre la base de que existen muy pocas verdades
                                        absolutas y que las
                                        creencias pertenecen al instante que vivamos, de ahi la expresion de necesitar
                                        aprender a vivir
                                        presentes. como ultima parte de este tomo tengo una conversacion directa con dios
                                        con la finalidad de
                                        que te atrevas a hablar de forma directa con el/ella/ello mostrandote el camino
                                        que yo emprendi para
                                        poder hacerlo</small></p>
                                <div class="p-4 pt-0 m-0">
                                    <p class="text-center text-lowercase m-0">SUMARIO</p>
                                    <span>PARTE IV REFLEXIONES</span>
                                    <ul class="summary" id="tomo2-minus">
                                        <li>de atea a estar segura de la existencia de dios</li>
                                        <li>salud y enfermedad </li>
                                    </ul>
                                    <div class="" style="display: none" id="tomo2-more">
                                        <ul class="summary">
                                            <li>de atea a estar segura de la existencia de dios</li>
                                            <li>salud y enfermedad </li>
                                            <li> ecologia y alimentacion </li>
                                            <li> sexualidad y amor de pareja </li>
                                            <li> familia, maternidad y paternidad </li>
                                            <li> dinero y riqueza </li>
                                            <li> el miedo a vivir, el miedo a morir y el miedo a sufrir</li>
                                            <li> soledad y desamor </li>
                                            <li> la necesidad de perfeccionismo </li>
                                            <li> la culpa y la vergüenza </li>
                                        </ul>
                                        <ul class="summary p-0">
                                            <li> PARTE V ALGUNAS PREGUNTAS QUE LE HE HECHO A DIOS Y HE AQUI SUS RESPUESTAS
                                            </li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-read" data-show="false" data-tomo="tomo2">leer mas <i class="fa fa-long-arrow-right ms-4"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-4 p-4 pb-0 ">
                            <div class="blog-box pb-2">
                                <div class="text-center">
                                    <img class="blog-img" src="{{ asset('images/books/book-3.png') }}" style="width: 270px; height: 340px;">
                                    <h6 class="pt-4 text-lowercase">en el tomo 3 </h6>
                                </div>
                                <p class="p-4 pt-0 m-0" style="text-align: justify;"><small>te propongo ejercicios y
                                        recursos para que
                                        puedas trabajar tu desarrollo personal, para que puedas reflexionar y aprender
                                        tecnicas que te
                                        ayudaran a desprogramarte y a liberar emocionalmente</small></p>
                                <div class="p-4 pt-0 m-0">
                                    <p class="text-center text-lowercase m-0">SUMARIO</p>
                                    <span>PARTE VI EJERCICIOS, RECURSOS Y ACTIVIDADES PARA PRACTICAR Y APRENDER A
                                            DESPROGRAMARTE POR
                                            COMPLETO</span>
                                    <ul class="summary" id="tomo3-minus">
                                        <li>significado de las principales dolencias y enfermedades</li>
                                        <li>desprogramacion creencias. ejemplo con el dinero </li>
                                        <ul class="summary">
                                            <li> tapping </li>
                                            <li> regresion </li>
                                        </ul>
                                        <li> asertividad para resolver conflictos. ejemplo con la relacion de pareja </li>
                                        <li> trabajo de profundizacion y liberacion de nuestro estado emocional. ejemplo con el sentimiento de soledad y analisis de la codependencia </li>
                                        <li> como llegar a nuestra verdad profunda. ejemplo con la necesidad de tener razon y otros apegos </li>
                                        <li> trabajo para reflexionar sobre lo que estoy viviendo y como me siento, a donde quiero dirigirme, que puedo mejorar y como quiero acabar sintiendome </li>
                                    </ul>
                                    <div style="display: none" id="tomo3-more">
                                        <ul class="summary">
                                            <li>significado de las principales dolencias y enfermedades</li>
                                            <li>desprogramacion creencias. ejemplo con el dinero </li>
                                            <ul class="summary">
                                                <li> tapping </li>
                                                <li> regresion </li>
                                            </ul>
                                            <li> asertividad para resolver conflictos. ejemplo con la relacion de pareja </li>
                                            <li> trabajo de profundizacion y liberacion de nuestro estado emocional. ejemplo con el sentimiento de soledad y analisis de la codependencia </li>
                                            <li> como llegar a nuestra verdad profunda. ejemplo con la necesidad de tener razon y otros apegos </li>
                                            <li> trabajo para reflexionar sobre lo que estoy viviendo y como me siento, a donde quiero dirigirme, que puedo mejorar y como quiero acabar sintiendome </li>
                                            <li> detecta como te sientes a traves de los espejos que pasan en tu dia a dia </li>
                                            <li> crear nuestra realidad. tecnicas y ayudas</li>
                                            <li> profundizacion a traves de lo que vamos creando</li>
                                            <li> valor personal, autoestima, autoconfianza</li>
                                            <li> trabajamos el ego, la personalidad, nuestros patrones</li>
                                            <li> trabajemos la rabia</li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-read" data-show="false" data-tomo="tomo3">leer mas <i class="fa fa-long-arrow-right ms-4"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position-relative pt-6 pb-6 bg-company">
        <div class="container">
            <div class="ticket-inner w-lg-75 mx-auto text-center position-relative text-white">
                <div class="ticket-title">
                    <h6 class="text-white mb-3" style="font-size: 18.2px;">ACCEDE A TODO EL CONTENIDO DEL LIBRO LEIDO POR MI EN VIDEOS A TRAVES DEL AREA PRIVADA </h6>
                </div>
                <div class="ticket-info">
                    <p style="text-align: justify;">con la compra de un libro o de toda la coleccion, tendras acceso a
                        muchos
                        recursos que te facilitaran no solo la comprension y aprendizaje del contenido del libro, sino
                        tambien el poder descargarte las plantillas y recursos para poder practicar, ademas de los videos grabados por mi
                        de todo el contenido del libro para que sea mucho mas facil la comprension de todo lo que digo. con el
                        tiempo, seguiremos incorporando contenido y podras, asi mismo, interactuar desde la app con la autora y
                        su equipo o con personas como tu que buscan vivir en plenitud en la mejor version de si mismos</p>
                    <p>para acceder a la zona privada neesitas los siguientes datos</p>
                    <p>
                        tu nombre completo<br>
                        el nombre completo de la persona que compro el libro (si no es el tuyo)<br>
                        fecha en que se compro<br>
                        el numero de pedido
                    </p>
                    <p>para acceder a todo el contenido <br> llegado un momento del libro, voy a pedirte, ademas, que escribas una reseña en amazon o testimonio <br> para que con ello me ayudes a difundir esta publicacion</p>
                    <p>solo podra registrarse para el area privada una persona por ticket <br> si has comprado el libro de forma compartida ponte en contacto con nosotros para conocer tu historia y valorar otro registro mas</p>
                    <div class="ticket-button">
                        <a class="btn" href="{{ url('/contactos') }}">me registro!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="partners pb-11 pt-11">
        <div class="container">
            <div class="partner-inner">
                <div class="partner-title text-center pb-6 w-lg-60 m-auto">
                    <p class="mb-1 pink"></p>
                    <h4 class="mb-1">TODAVIA NO HAS LEIDO MI LIBRO?</h4>
                    <p class="m-0 text-lowercase">podras comprarlo aqui</p>
                </div>

                <div class="partner-button text-center">
                    <a class="btn" href="javascript:;">ir a tienda</a>
                </div>
            </div>
        </div>
    </section>
    <section class="subscribe py-4">
        <div class="container">
            <div class="subscribe-content">
                <div class="row">
                    <div class="col-lg-6 align-self-center ">
                        <div class="sub-left text-center text-lg-start py-2">
                            <h4 class="text-white text-lowercase">no te vayas sin suscribirte a la newsletter de sbye
                                transformacion!
                            </h4>
                        </div>
                        <p class="text-white mb-4 text-lg-start" style="text-align: justify;"> por suscribirte te
                            regalare el ultimo capitulo que habia escrito y que no he publicado en el libro por exceso de paginas: “enemigos del aprendizaje. analiza con los siguientes test esta parte de tu personalidad”
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <div class="sub-right py-2">

                            <div class="row gy-3">
                                <div class="col-lg-8 col-md-8 ">
                                    <div class="sub-email">
                                        <input type="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="sub-button">
                                        <button class="btn w-100">me apunto!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function () {
      $(".btn-read").on("click", function (e) {
        var me = $(this), tomo = me.data("tomo"), show = me.data("show");
        if (show) {
            $("#" + tomo + "-minus").show();
            $("#" + tomo + "-more").hide();
            me.html("leer mas <i class='fa fa-long-arrow-right ms-4'></i>");
        }
        else {
            $("#" + tomo + "-minus").hide();
            $("#" + tomo + "-more").show();
            me.html("leer menos <i class='fa fa-long-arrow-left ms-4'></i>");
        }
        me.data("show", !show);
      });
    })
</script>
@endsection