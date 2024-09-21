@extends('layouts.main')

@section('content')
<section class="banner page-banner position-relative pb-0">
    <div class="overlay">
    </div>
    <div class="container">
      <div class="page-title text-center position-relative py-5">
        <p class="text-white text-uppercase header-title">consulta individual</p>
      </div>
    </div>
  </section>
  <section class="overview p-0 bg-company">
    <div class="container">
      <div class="inner-overview position-relative">
        <div class="row">
          <div class="col-lg-6 col-md-6 text-center pb-6">
            <div class="container-img-right">
              <img src="{{ asset('images/team/maria2.png') }}" alt="group-image" class="w-50">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 pt-9">
            <div class="overview-left text-center text-lg-start">
              <div class="overview-title pb-4">
                <p class="text-center text-lowercase text-white header-subtitle">has leido mi libro <br> y quieres que te ayude <br> a
                  desprogramarte y liberar, a sanar <br> y conseguir como yo vivir en plenitud?
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
        <div class="overview-left text-center">
          <div class="overview-title pb-4">
            <p class="mb-1 pink"></p>
            <h4 class="text-lowercase">solo ayudo a quien se ayuda</h4>
            <p>por tanto, solo atendere a personas que realmente quieran cambiar y se involucren en su cambio <br>
              si estas preparado en profundizar en tu dolor, sanarlo y transmutarlo, este es tu sitio <br>
              puedes hacer consulta de forma directa conmigo o, mejor aun, apuntate al taller online</p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <section class="overview p-0">
    <div class="container">
      <div class="inner-overview position-relative">
        <div class="row">
          <div class="col-lg-6">
            <div class="overview-left text-center text-lg-start">
              <div class="overview-title pb-4">
                <h4 class="mb-2">consulta individual</h4>
                <p>las consultas podran ser online, telefonicas o presenciales, por lo que no es necesario que vivas
                  cerca de mi o te desplaces. por supuesto la magia de estar juntos se rompe un poco en la distancia,
                  pero he trabajado muchas veces asi y te aseguro que sera muy eficaz <br> <br>
                  siempre estoy flexibilizandome y adaptandome a las circunstancias mias y de la otra persona, por lo
                  que no descarto nada, asi que ponte en contacto conmigo y buscaremos juntos cual es la mejor formula
                  para ambos. por ponerte un ejemplo, en ocasiones he trabajado cinco dias seguidos con personas que
                  necesitaban un empujon grande, y han estado o en mi casa o en un apartamento por la zona donde vivo.
                  quien quiere, siempre encuentra como!  <img src="{{ asset('images/icon/smile.png') }}" style="width: 25px;"> <br> <br>
                  la duracion de la consulta es indefinida, es decir, puedo estar contigo de una hora a cinco horas
                  seguidas, dependiendo de lo que necesites <br><br>
                  en la consulta trabajare con los recursos que te he presentado en el libro y, por tanto, utilizare la
                  desprogramacion de creencias, la reflexion y la liberacion emocional, para conseguir facilitarte el
                  camino hacia tu plenitud <br><br>
                  normalmente trabajo en un marco temporal de 3 meses con consultas quincenales en donde me mantengo en
                  permanente contacto con la persona que esta liberando y cambiando, para que en ningun momento se
                  sienta sola y desamparada, sino querida y apoyada, pero siempre buscando su empoderamiento, de modo
                  que al cabo de este marco temporal, que podra variar ligeramente segun cada uno, la persona sepa
                  utilizar por si misma todas las herramientas y ya solo necesite apoyarse en mi en momentos puntuales
                  de crisis <br><br>
                  como sabes, mis clientes se convierten en mis amigos, sencillamente porque me desnudo con ellos, les
                  comprendo y me comprenden, tenemos un fin comun y conectamos desde lo mas profundo de nuestro ser, es
                  por esto que, tanto en el periodo de consultas como posteriormente a lo largo de toda la vida, no
                  cobrare mi acompañamiento, y si me siento desbordada, buscare la formula, junto con dios, para que
                  nunca, jamas, te sientas sola o solo en tu proceso de sanancion y cambio, en tu camino a la plenitud
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="overview-img">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 ">
                  <div class="container-img-left mb-2">
                    <div class="img-left-1 float-end">
                      <img class="mb-2 w-100 rounded" src="{{ asset('images/others/mujer-llorando.png') }}" alt="group-image">
                    </div>
                    <div class="img-left-2">
                      <img src="{{ asset('images/others/piezas-faltan.png') }}" alt="group-image" class="w-100 rounded">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="container-img-right">
                    <img src="{{ asset('images/others/mujer-timon-barco.png') }}" alt="group-image" class="w-100 rounded">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-around ">
            <div class="col-lg-3">
              
            </div>
            
            <div class="col-lg-3 col-md-6">
              <a href="javascript:;" class="font-black">
                <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                  <div class="event-info-icon text-center">
                    <img src="{{ asset('images/others/euro.png') }}" class="me-3" style="width: 50px; height: 50px;">
                  </div>
                  <div class="location-info">
                    <h6 class="mb-1"><b>PRECIO</b></h6>
                    <h5 class="mb-1">150 €</h5>
                    <small>sesion</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href="{{ url('contactos')}}" class="font-black">
                <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                  <div class="event-info-icon text-center">
                    <img src="{{ asset('images/others/contactos.png') }}" class="me-3" style="width: 50px; height: 50px;">
                  </div>
                  <div class="time-info">
                    <h5 class="mb-1"><b>CONTACTO</b></h5>
                    <small>cuentame que necesitas</small>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3">
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="conference bg-company mt-6" style="background-image: none !important;">
    <div class="container">
      <div class="conference-inner text-center">
        <div class="row gx-lg-5 align-items-center">
          <div class="col-lg-6 order-2 order-lg-1">
            <div class="conference-left"
              style="background-image: url('images/others/cambio-transformacion.png') !important">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 px-8 pt-2">
                  <div class="event-benifit-list-left mb-4">
                    <div class="py-2 px-4 rounded mb-4 box-shadow bg-white" style="max-width: 160px;">
                      <div class="list-box-icon">
                        <img src="{{ asset('images/avatars/elena.png') }}">
                      </div>
                      <div class="list-box-body">
                        <h5 class="text-lowercase">Elena</h5>
                        <p class="mb-2 w-75 m-auto">25 años</p>
                        <div class="box-btn">
                          <a class="p-0 font-company" href="javascript:;">leer<i
                              class="fa fa-long-arrow-right ms-2"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="py-2 px-4 rounded mb-4 box-shadow bg-white" style="max-width: 160px;">
                      <div class="list-box-icon">
                        <img src="{{ asset('images/avatars/marta.png') }}">
                      </div>
                      <div class="list-box-body">
                        <h5 class="text-lowercase">marta</h5>
                        <p class="mb-2 w-75 m-auto">60 años</p>
                        <div class="box-btn">
                          <a class="font-company p-0" href="javascript:;">leer<i
                              class="fa fa-long-arrow-right ms-2"></i></a>
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
                        <a class="font-company p-0" href="javascript:;">leer<i
                            class="fa fa-long-arrow-right ms-2"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2">
            <div class="event-benifit-list-right text-lg-start">
              <div class="overview-title pb-6">
                <p class="mb-1 pink"></p>
                <h2 class="mb-2"><span class="pink"></span></h2>
              </div>
              <div class="overview-info">
                <P class="text-white">te dejo varios informes reales, en donde he cambiado el nombre de la persona para mayor privacidad,
                  con el fin de que sepas que puedes esperar de una consulta individual conmigo</P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection