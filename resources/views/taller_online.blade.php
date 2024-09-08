@extends('layouts.main')

@section('content')
<section class="banner page-banner position-relative pb-0">
  <div class="overlay">
  </div>
  <div class="container">
    <div class="page-title text-center position-relative py-5">
        <p class="text-white text-uppercase header-title">taller online</p>
      </div>
  </div>
</section>
  <section class="overview pt-0 pb-8 bg-company">
      <div class="container">
        <div class="inner-overview position-relative">
          <div class="row">
            <div class="col-lg-6">
              <div class="overview-img">
                <div class="container-img-right">
                  <img src="{{ asset('images/team/maria-delante-ordenador.png') }}" alt="group-image" class="w-60 rounded">
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="overview-left text-center text-lg-start">
                <div class="overview-title pb-4">
                  <p class="text-white text-center text-lowercase header-subtitle">quieres que te ayude <br> desprogramarte y liberar, a sanar<br>y conseguir como yo vivir en plenitud?<br><br>o, eres terapeuta y<br>deseas convertirte en facilitador de procesos personales?
                  </p>
                </div> 
              </div>  
            </div>
            </div>
          </div>
        </div>
      </div> 
  </section>
  <section class="overview py-8">
      <div class="container">
        <div class="inner-overview position-relative">
          <div class="row">
            <div class="col-lg-6 m-auto">
              <div class="overview-left text-center text-lg-start">
                <div class="overview-title" style="display: table-cell; vertical-align: middle;">
                  <h2 class="mb-2">taller online</h2>
                  <P>se trata de un programa online de 3 meses en donde semanalmente tendremos dos reuniones para practicar en grupo los recursos que he propuesto en el libro. iras haciendo los ejercicios a tu ritmo personal en casa, pero en grupo los revisaremos y solucionaremos dudas, practicaremos y compartiremos con los demas nuestro propio camino</p>
                  <p>adicionalmente, a lo largo del mes, tendre una consulta individual contigo, en donde te conocere profundamente para poder apoyarte y guiarte en tu camino hacia tu plenitud, para ello utilizare recursos de liberacion emocional, desprogramacion de creencias y reflexion y al finalizarla te escribire un informe personal sobre lo que hemos trabajado y mis recomendaciones y reflexiones sobre tu personalidad y circunstancias</P>
                </div> 
              </div>  
            </div>
            <div class="col-lg-6">
              <div class="overview-img">
                <div class="row align-items-center">
                  <div class="col-lg-6 col-md-6 ">
                    <div class="container-img-left mb-2">
                      <div class="img-left-1 float-end">
                        <img class="mb-2 w-100 rounded" src="{{ asset('images/others/encontrar-luz.png') }}" alt="group-image">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 ">
                    <div class="container-img-left mb-2">
                      <div class="img-left-1 float-end">
                        <img class="mb-2 w-100 rounded" src="{{ asset('images/others/encajar-pieza-falta.png') }}" alt="group-image">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12">
                    <div class="container-img-right">
                     <img src="{{ asset('images/others/taller-online.png') }}" alt="group-image" class="w-100 rounded">
                    </div> 
                  </div>
                </div>
              </div>  
            </div>
          </div>
        </div>
      </div> 
  </section>
<section class="py-2">
  <div class="container">
    <div class="inner-overview position-relative">
      <div class="row">
        <div class="overview-event-info">
          <div class="row justify-content-around ">
            <div class="col-lg-3 col-md-4">
              <a href="javascript:;" class="font-black">
                <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                  <div class="event-info-icon text-center ">
                    <img src="{{ asset('images/others/euro.png') }}" class="me-3" style="width: 50px; height: 50px;">
                  </div>
                  <div class="location-info">
                    <h5 class="mb-1"><b>PRECIO</b></h5>
                    <h5 class="mb-1">300 €</h5>
                    <small>mes</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-4">
              <a href="javascript:;" class="font-black">
                <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                  <div class="event-info-icon text-center">
                    <img src="{{ asset('images/others/euro.png') }}" class="me-3" style="width: 50px; height: 50px;">
                  </div>
                  <div class="time-info">
                    <h5 class="mb-1"><b>AFORO</b></h5>
                    <h5 class="mb-1">10</h5>
                    <small>personas</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-4">
              <a href="{{ url('contactos') }}" class="font-black">
                <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                  <div class="event-info-icon text-center">
                    <img src="{{ asset('images/others/contactos.png') }}" class="me-3" style="width: 50px; height: 50px;">
                  </div>
                  <div class="time-info">
                    <h5 class="mb-1"><b>CONTACTO</b></h5>
                    <small>cuentame que <br> necesitas</small>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="conference py-6 my-6 bg-company" style="background-image: none !important;">
  <div class="container">
    <div class="conference-inner text-center">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 order-2 order-lg-1">
          <div class="conference-left" style="background-image: url('images/others/fondo-mariposas.png') !important">
            <div class="row align-items-center">
              <div class="col-lg-6 col-md-6 px-2 pt-2">
                <div class="event-benifit-list-left mb-4">
                  <div class="py-2 px-4 rounded mb-4 box-shadow bg-white" style="max-width: 160px;">
                    <div class="list-box-icon">
                      <img src="{{ asset('images/avatars/monica.png') }}">
                    </div> 
                    <div class="list-box-body">
                      <h5 class="text-lowercase">monica</h5>
                      <p class="mb-2 w-75 m-auto">67 años</p>
                      <div class="box-btn">
                        <a class="p-0 font-company" href="javascript:;">leer<i class="fa fa-long-arrow-right ms-2"></i></a>
                      </div>  
                    </div>  
                  </div>
                  <div class="py-2 px-4 rounded mb-4 box-shadow bg-white" style="max-width: 160px;">
                    <div class="list-box-icon">
                      <img src="{{ asset('images/avatars/rosa.png') }}">
                    </div> 
                    <div class="list-box-body">
                      <h5 class="text-lowercase">rosa</h5>
                      <p class="mb-2 w-75 m-auto">37 años</p>
                      <div class="box-btn">
                        <a class="font-company p-0" href="javascript:;">leer<i class="fa fa-long-arrow-right ms-2"></i></a>
                      </div>  
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 px-2">
                <div class="py-2 px-4 rounded mb-4 box-shadow bg-white" style="max-width: 160px;">
                  <div class="list-box-icon">
                    <img src="{{ asset('images/avatars/sebas.png') }}">
                  </div> 
                  <div class="list-box-body">
                    <h5 class="text-lowercase">sebas</h5>
                    <p class="mb-2 w-75 m-auto">61 años</p>
                    <div class="box-btn">
                      <a class="font-company p-0" href="javascript:;">leer<i class="fa fa-long-arrow-right ms-2"></i></a>
                    </div>  
                  </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <div class="event-benifit-list-right text-lg-start">
            <div class="overview-info">  
              <p class="text-white">te dejo varios informes reales, en donde he cambiado el nombre de la persona para mayor privacidad, con el fin de que sepas que puedes esperar de una consulta individual conmigo dentro del taller online
              </p>
            </div> 
          </div>  
        </div>
      </div>
    </div>
  </div>
</section>
  <section class="overview py-2">
      <div class="container">
        <div class="inner-overview position-relative">
          <div class="row">
            <div class="col-lg-6">
              <div class="overview-left text-center text-lg-start">
                <div class="overview-title px-4">
                  <h4 class="mb-2">QUIERES CONVERTIRTE EN FACILITADOR DE PROCESOS PERSONALES?</h4>
                  <P>haz el taller online de 3 meses y practica de forma directa conmigo primero a traves del taller y posteriormente tendremos una consulta individual mensual hasta que sintamos que estas totalmente empoderado para poder ayudar a otras personas desde tu propia experiencia personal y con total dominio de los recursos que he propuesto en el libro y otros que te ire proponiendo en caso de que sean necesarios en tu interaccion personal con otras personas</p>
                  <p>al finalizar contaras con mi apoyo incondicional para ayudarte a resolver tus dudas cuando estes trabajando hacia los demas, ademas de mi apoyo en tu propio proceso personal, como cualquier otro cliente-amigo</p>
                  <p>por supuesto, aunque ya sabes que no se trata de una formacion oficial, contaras con tu titulo de facilitador de prosesos personales firmado por mi <img src="{{ asset('images/icon/smile.png') }}" style="width: 25px;"> </P>
                </div> 
              </div>
            </div>
            <div class="col-lg-6">
              <div class="overview-img">
                <div class="row align-items-center">
                  <div class="col-lg-6 col-md-6 ">
                    <div class="container-img-left mb-2">
                      <div class="img-left-1 float-end">
                        <img class="mb-2 w-100 rounded" src="{{ asset('images/others/guiar-facilitador-procesos.png') }}" alt="group-image">
                      </div>
                      <div class="img-left-2">
                        <img src="{{ asset('images/others/mujer-liberanso-emocionalmente.png') }}" alt="group-image" class="w-100 rounded">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="container-img-right">
                      <img src="{{ asset('images/others/facilitador-procesos-personales.png') }}" alt="group-image" class="w-100 rounded">
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div> 
  </section>
@endsection