<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => 'archivos asociados al libro',
                'subtitle' => 'recursos y materiales que acompañan la obra',
                'description' => '<p><span style="color:black;">a lo largo de los tres tomos encontraras ejercicios, audios, videos, plantillas y otros materiales vinculados mediante qr o enlaces</span></p><p><span style="color:black;">esta seccion reune esos recursos para que puedas encontrarlos facilmente y utilizarlos mientras avanzas en la lectura y llevas lo que vas descubriendo a tu propia vida</span></p><p><span style="color:black;">si estas leyendo la obra, puedes volver aqui siempre que necesites recuperar alguno de los materiales, profundizar en una propuesta o realizar uno de los ejercicios</span></p><p><span style="color:black;"><strong>ademas, si tienes alguno de los tomos, puedes darte de alta gratuitamente en el area privada de sbye transformacion y acceder al videolibro, participar con tus preguntas y reflexiones y encontrar otros contenidos vinculados a la obra</strong></span></p>'
            ],
            [
                'name' => 'testimonios',
                'subtitle' => 'lo que otras personas han encontrado en este camino',
                'description' => '<p><span style="color:black;">aqui encontraras experiencias compartidas por personas que han trabajado conmigo, han participado en alguna de mis actividades o han leido la obra <i>liberacion emocional, la puerta para vivir en plenitud</i></span></p><p><span style="color:black;">algunas hablan de su propio proceso, otras de lo que la lectura les hizo comprender, cuestionar o mirar de otra manera</span></p><p><span style="color:black;">las recojo aqui porque cada experiencia muestra una forma diferente de encontrarse con este trabajo</span></p>'
            ],
            [
                'name' => 'en los medios',
                'subtitle' => 'entrevistas, articulos y colaboraciones',
                'description' => '<p>en esta seccion encontraras mis colaboraciones en medios de comunicacion, donde comparto y desarrollo distintas ideas relacionadas con el autoconocimiento, la liberacion emocional y la posibilidad de vivir cada vez con mayor libertad y plenitud</p><p>a traves de estos espacios exploramos que puede mostrarnos aquello que sentimos, pensamos, vivimos y repetimos sobre nosotros mismos, y como nuestras heridas, creencias, necesidades, miedos y aprendizajes pueden seguir influyendo en nuestra manera de reaccionar, relacionarnos y elegir</p><p>tambien iremos abriendo la mirada hacia otros aspectos que forman parte de este mismo recorrido: el cuerpo, el inconsciente, nuestras elecciones, las relaciones, aquello que nos remueve, la manera en que afrontamos el dolor y la posibilidad de experimentar y vivir de otra manera</p><p>cuando aparezca un nuevo articulo, entrevista o colaboracion, lo encontraras aqui</p><hr><p><span style="color:hsl(0,0%,0%);"><strong>articulos en psicoactiva</strong></span></p><p>lcolaboro con el portal de psicologia psicoactiva con una serie de articulos en los que exploramos nuestra manera de sentir, pensar, reaccionar y vivir desde una mirada centrada en el autoconocimiento</p><p>la serie comenzo profundizando en el inconsciente, las heridas emocionales y los patrones aprendidos, y continua ampliando la mirada hacia aquello que nuestras emociones, necesidades, elecciones, relaciones y experiencias pueden mostrarnos sobre nosotros mismos</p><p>el objetivo no es solamente comprender por que somos como somos, sino aprender a observarnos en nuestra propia vida para ir descubriendo que nos condiciona y recuperar cada vez mayor libertad para elegir como queremos vivir</p>'
            ],
            [
                'name' => 'post',
                'subtitle' => 'reflexiones, preguntas y experiencias para llevar la mirada a nosotros mismos',
                'description' => '<p><span style="color:black;">los posts forman parte de las campañas que voy desarrollando en redes sociales</span></p><p><span style="color:black;">a traves de videos, imagenes, reflexiones, preguntas y ejemplos cotidianos vamos explorando un mismo tema desde diferentes perspectivas, observando como puede aparecer en nuestra propia manera de sentir, pensar, reaccionar y vivir</span></p><p><span style="color:black;">no buscan solamente transmitir una idea</span></p><p><span style="color:black;">muchas de estas publicaciones contienen preguntas o pequeñas propuestas para observarnos, cuestionarnos, experimentar de otra manera o descubrir algo de nosotros que hasta entonces podia estar pasando desapercibido</span></p><p><span style="color:black;"><strong>puedes recorrerlas de manera independiente o seguir las distintas campañas para ver como una idea va desarrollandose y profundizando hasta llegar a la conferencia que cierra cada recorrido</strong></span></p>'
            ],
            [
                'name' => 'newsletters',
                'subtitle' => 'reflexiones intimas en las que mi propia vida se convierte en parte de lo que quiero compartir',
                'description' => '<p><span style="color:black;">en mis newsletters parto muchas veces de algo que estoy viviendo, de una relacion, una conversacion, una experiencia, una contradiccion, algo que me sorprende o una pregunta que aparece en mi propia vida</span></p><p><span style="color:black;">desde ahi profundizo en los temas que voy desarrollando en cada momento y comparto como los observo y los vivo desde mi propia manera de comprender al ser humano, el inconsciente, las relaciones, la libertad, la plenitud o dios</span></p><p><span style="color:black;"><strong>no escribo mi vida para hablar de mi</strong></span></p><p><span style="color:black;">la comparto porque muchas veces aquello que vivimos puede ayudarnos a ver, en una experiencia real, lo que resulta mucho mas dificil comprender solamente desde la teoria</span></p><p><span style="color:black;">por eso estas newsletters son personales, largas y a veces transgresoras</span></p><p><span style="color:black;">en ellas no intento mostrar una vida perfecta ni una forma correcta de vivir, sino abrir mi propia experiencia para que tambien pueda convertirse en un lugar desde el que observar, cuestionar y comprender</span></p>'
            ],
            [
                'name' => 'conferencias',
                'subtitle' => 'un espacio para integrar y profundizar en cada recorrido',
                'description' => '<p><span style="color:black;">las conferencias nacen como cierre de las distintas campañas que voy desarrollando en redes sociales</span></p><p><span style="color:black;">durante varias semanas exploramos un mismo tema desde diferentes perspectivas a traves de videos, reflexiones, ejemplos y ejercicios, y la conferencia recoge ese recorrido para profundizar, relacionar las distintas ideas y llevarlas a nuestra propia experiencia</span></p><p><span style="color:black;"><strong>no son solamente espacios para escuchar</strong></span></p><p><span style="color:black;">a lo largo de cada conferencia vamos haciendo preguntas, ejercicios de introspeccion y reflexiones que nos permiten observar que ocurre en nosotros y llevar lo que estamos comprendiendo a nuestra propia vida</span></p><p><span style="color:black;">las preguntas y experiencias que van surgiendo nos permiten ademas explorar situaciones diferentes, reconocer patrones que pueden aparecer de muchas formas y profundizar en aspectos que quiza no nos habiamos planteado</span></p><p><span style="color:black;"><strong>cada conferencia cierra una campaña y, al mismo tiempo, puede abrir una nueva manera de observarnos</strong></span></p>'
            ],
            [
                'name' => 'para prensa y medios',
                'subtitle' => 'material para entrevistas, articulos y colaboraciones',
                'description' => '<p><span style="color:black;">aqui encontraras una seleccion de materiales sobre mi trabajo, la obra liberacion emocional y sbye transformacion, preparados para periodistas, comunicadores y medios que quieran conocer mi enfoque o utilizar estos recursos como punto de partida para una entrevista o colaboracion</span></p><p><span style="color:black;">encontraras biografia, dossier de prensa, entrevistas de muestra, fotografias y diferentes materiales que permiten acercarse a mi trabajo desde una perspectiva mas racional y divulgativa o desde su dimension vivencial y espiritual</span></p><p><span style="color:black;">si quieres proponerme una entrevista, colaboracion o participacion en un medio, puedes contactar conmigo</span></p><p><span style="color:black;">Boton: contactar → (lleva a formulario contáctame)</span></p>'
            ],
            [
                'name' => 'informes de consulta',
                'subtitle' => 'una forma de continuar trabajando despues de cada encuentro',
                'description' => '<p><span style="color:black;">estos informes estan anonimizados y permiten ver de cerca como trabajo con cada persona a partir de lo que ha aparecido durante una consulta</span></p><p><span style="color:black;">en ellos recojo aquello que hemos ido descubriendo, las relaciones que hemos encontrado entre diferentes experiencias, emociones, creencias, reacciones o formas de vivir y las propuestas que pueden ayudar a seguir observando, profundizando, liberando o experimentando de otra manera</span></p><p><span style="color:black;"><strong>el informe no pretende decirte quien eres, sino ayudarte a comprender quien estas siendo y desde donde estas viviendo en este momento&nbsp;</strong></span></p><p><span style="color:black;">por eso no es solamente un resumen de la consulta, sino una herramienta para continuar trabajando con lo que hemos descubierto y llevarlo a la propia vida</span></p><p><span style="color:black;">los informes que puedes consultar aqui son ejemplos reales y anonimizados de esta forma de acompañar</span></p>'
            ]
        ];

        foreach ($categories as $c) {
            $cat = Category::firstWhere('name', $c['name']);
            if ($cat) {
                $cat->subtitle = $c['subtitle'];
                $cat->description = $c['description'];
                $cat->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
