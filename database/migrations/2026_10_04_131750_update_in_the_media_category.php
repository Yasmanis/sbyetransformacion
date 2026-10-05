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
                'name' => 'en los medios',
                'description' => '<p>en esta seccion encontraras mis colaboraciones en medios de comunicacion, donde comparto y desarrollo distintas ideas relacionadas con el autoconocimiento, la liberacion emocional y la posibilidad de vivir cada vez con mayor libertad y plenitud</p><p>a traves de estos espacios exploramos que puede mostrarnos aquello que sentimos, pensamos, vivimos y repetimos sobre nosotros mismos, y como nuestras heridas, creencias, necesidades, miedos y aprendizajes pueden seguir influyendo en nuestra manera de reaccionar, relacionarnos y elegir</p><p>tambien iremos abriendo la mirada hacia otros aspectos que forman parte de este mismo recorrido: el cuerpo, el inconsciente, nuestras elecciones, las relaciones, aquello que nos remueve, la manera en que afrontamos el dolor y la posibilidad de experimentar y vivir de otra manera</p><p>cuando aparezca un nuevo articulo, entrevista o colaboracion, lo encontraras aqui</p><hr><p><span style="color:hsl(0,0%,0%);"><strong>articulos en psicoactiva</strong></span></p><p>colaboro con el portal de psicologia psicoactiva con una serie de articulos en los que exploramos nuestra manera de sentir, pensar, reaccionar y vivir desde una mirada centrada en el autoconocimiento</p><p>la serie comenzo profundizando en el inconsciente, las heridas emocionales y los patrones aprendidos, y continua ampliando la mirada hacia aquello que nuestras emociones, necesidades, elecciones, relaciones y experiencias pueden mostrarnos sobre nosotros mismos</p><p>el objetivo no es solamente comprender por que somos como somos, sino aprender a observarnos en nuestra propia vida para ir descubriendo que nos condiciona y recuperar cada vez mayor libertad para elegir como queremos vivir</p>'
            ],
            [
                'name' => 'para prensa y medios',
                'description' => '<p><span style="color:black;">aqui encontraras una seleccion de materiales sobre mi trabajo, la obra liberacion emocional y sbye transformacion, preparados para periodistas, comunicadores y medios que quieran conocer mi enfoque o utilizar estos recursos como punto de partida para una entrevista o colaboracion</span></p><p><span style="color:black;">encontraras biografia, dossier de prensa, entrevistas de muestra, fotografias y diferentes materiales que permiten acercarse a mi trabajo desde una perspectiva mas racional y divulgativa o desde su dimension vivencial y espiritual</span></p><p><span style="color:black;">si quieres proponerme una entrevista, colaboracion o participacion en un medio, puedes contactar conmigo</span></p>'
            ]
        ];

        foreach ($categories as $c) {
            $cat = Category::firstWhere('name', $c['name']);
            if ($cat) {
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
