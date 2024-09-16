@extends('layouts.main')

@section('content')
<section class="banner page-banner position-relative pb-0">
    <div class="overlay">
    </div>
    <div class="container">
      <div class="page-title text-center position-relative pb-5">
        <h2 class="text-white">publicaciones</h2>
      </div>
    </div>
  </section>
  <section class="news-archive">
    <div class="container">
      <div class="news-archive-inner">
        <div class="row gy-5">
          <div class="col-lg-8">
            <div class="news-left me-4 m-md-0">
              <div class="row g-md-5 gy-5">
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/1. video de un bebe escalando para comprender el significado de autoconfianza.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/1. video de un bebe escalando para comprender el significado de autoconfianza.mp4') }}"
                          target="_blank" class="font-black">video de un bebe escalando para comprender el significado
                          de autoconfianza</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/1. video de un bebe escalando para comprender el significado de autoconfianza.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center ">
                    <div class="blog-img">
                      <video src="{{ asset('media/2. regresion hipnotia para superar el miedo al rechazo.mp4') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/2. regresion hipnotia para superar el miedo al rechazo.mp4') }}" target="_blank"
                          class="font-black">regresion hipnotica para superar el miedo al rechazo</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/2. regresion hipnotia para superar el miedo al rechazo.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center ">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/3. Las misteriosas y extrañas habilidades de los monjes del Himalaya ¿Todopoderosos.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/3. Las misteriosas y extrañas habilidades de los monjes del Himalaya ¿Todopoderosos.mp4') }}"
                          target="_blank" class="font-black">Las misteriosas y extrañas habilidades de los monjes del
                          Himalaya ¿Todopoderosos?</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/3. Las misteriosas y extrañas habilidades de los monjes del Himalaya ¿Todopoderosos.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center ">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/4. Aleix Segura, récord guinness en apnea estática explica cómo aguanta 24 minutos bajo el.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/4. Aleix Segura, récord guinness en apnea estática explica cómo aguanta 24 minutos bajo el.mp4') }}"
                          target="_blank" class="font-black">Aleix Segura, récord guinness en apnea estática explica
                          cómo aguanta 24 minutos bajo el agua</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/4. Aleix Segura, récord guinness en apnea estática explica cómo aguanta 24 minutos bajo el.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center ">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/5. video como hacer el testeo para comenzar a dialogar directamente con dios.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/5. video como hacer el testeo para comenzar a dialogar directamente con dios.mp4') }}"
                          target="_blank" class="font-black">video como hacer el testeo para comenzar a dialogar
                          directamente con dios</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/5. video como hacer el testeo para comenzar a dialogar directamente con dios.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/6. entrevista que el fallecido eduard punset hace al premio nobel de fisica en 2004 f.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/6. entrevista que el fallecido eduard punset hace al premio nobel de fisica en 2004 f.mp4') }}"
                          target="_blank" class="font-black">entrevista que el fallecido eduard punset hace al premio
                          nobel de fisica en 2004</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/6. entrevista que el fallecido eduard punset hace al premio nobel de fisica en 2004 f.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/7. conferencia en argentina del biologo bruce lipton explicando como funciona la energia para ver.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/7. conferencia en argentina del biologo bruce lipton explicando como funciona la energia para ver.mp4') }}"
                          target="_blank" class="font-black">conferencia en argentina del biologo bruce lipton
                          explicando como funciona la energia para verse y sentirse como materia</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/7. conferencia en argentina del biologo bruce lipton explicando como funciona la energia para ver.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/8. video ilustrativo del experimento de la doble rendija, dentro de la fisica cuantica.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/8. video ilustrativo del experimento de la doble rendija, dentro de la fisica cuantica.mp4') }}"
                          target="_blank" class="font-black">video ilustrativo del experimento de la doble rendija,
                          dentro de la fisica cuantica</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/8. video ilustrativo del experimento de la doble rendija, dentro de la fisica cuantica.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video src="{{ asset('media/9. Biciclown Un viaje para descubrir la vida. Álvaro Neil, viajero.mp4') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/9. Biciclown Un viaje para descubrir la vida. Álvaro Neil, viajero.mp4') }}"
                          target="_blank" class="font-black">Biciclown Un viaje para descubrir la vida. Álvaro Neil,
                          viajero</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/9. Biciclown Un viaje para descubrir la vida. Álvaro Neil, viajero.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video
                        src="{{ asset('media/10. video donde explico a mis amigos como estoy hablando con dios y les animo a que lo.mp4') }}"
                        controls class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a
                          href="{{ asset('media/10. video donde explico a mis amigos como estoy hablando con dios y les animo a que lo.mp4') }}"
                          target="_blank" class="font-black">video donde explico a mis amigos como estoy hablando con
                          dios y les animo a que lo hagan</a></h5>
                      <a class="text-uppercase font-company"
                        href="{{ asset('media/10. video donde explico a mis amigos como estoy hablando con dios y les animo a que lo.mp4') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video src="{{ asset('media/11. insultos en femenino.mp3') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a href="{{ asset('media/11. insultos en femenino.mp3') }}" target="_blank"
                          class="font-black">insultos en femenino</a></h5>
                      <a class="text-uppercase font-company" href="{{ asset('media/11. insultos en femenino.mp3') }}"
                        target="_blank"><small>escuchar</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video src="{{ asset('media/12. insultos en masculino.mp3') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a href="{{ asset('media/12. insultos en masculino.mp3') }}" target="_blank"
                          class="font-black">insultos en masculino</a></h5>
                      <a class="text-uppercase font-company" href="{{ asset('media/12. insultos en masculino.mp3') }}"
                        target="_blank"><small>escuchar</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video src="{{ asset('media/13. calificativos agradables en femenino.mp3') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a href="{{ asset('media/13. calificativos agradables en femenino.mp3') }}"
                          target="_blank" class="font-black">calificativos agradables en femenino</a></h5>
                      <a class="text-uppercase font-company" href="{{ asset('media/13. calificativos agradables en femenino.mp3') }}"
                        target="_blank"><small>escuchar</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <video src="{{ asset('media/14. calificativos agradables en masculino.mp3') }}" controls
                        class="blog-img rounded-top w-100 h-auto"></video>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a href="{{ asset('media/14. calificativos agradables en masculino.mp3') }}"
                          target="_blank" class="font-black">calificativos agradables en masculino</a></h5>
                      <a class="text-uppercase font-company" href="{{ asset('media/14. calificativos agradables en masculino.mp3') }}"
                        target="_blank"><small>escuchar</small></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="blog-box border border-1 rounded pb-2 text-center">
                    <div class="blog-img">
                      <a href="{{ asset('media/15. instrumentos musicales.pdf') }}" target="_blank">
                        <img class="blog-img rounded-top w-100 h-auto" src="{{ asset('images/group/6.jpg') }}" style="height: 160px !important;">
                      </a>
                    </div>
                    <div class="blog-info p-4">
                      <h5 class="mb-2 text-lowercase"><a href="{{ asset('media/15. instrumentos musicales.pdf') }}" class="font-black"
                          target="_blank">instrumentos musicales</a></h5>
                      <a class="text-uppercase font-company" href="{{ asset('media/15. instrumentos musicales.pdf') }}"
                        target="_blank"><small>ver</small></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="news-right ms-4 m-md-0">

            </div>
            <div class="catagories p-6 rounded box-shadow mb-6">
              <h6 class="mb-3">categorias</h6>
              <div class="sperator mb-4 m-0 w-20  border-bottom border-2 border-company"></div>
              <ul class="m-0 p-0 list-unstyled">
                <li class="py-3  border-dashed-bottom-1">
                  <a href="{{ route('publicaciones.libros') }}" class="font-company"><i class="fa fa-check font-company pe-3"
                      aria-hidden="true"></i>libros</a>
                </li>
                <li class="py-3 border-dashed-bottom-1">
                  <a href="javascript:;" class="font-company"><i class="fa fa-check font-company pe-3"
                      aria-hidden="true"></i>testimonios</a>
                </li>
                <li class="py-3 border-dashed-bottom-1">
                  <a href="javascript:;" class="font-company"><i class="fa fa-check font-company pe-3"
                      aria-hidden="true"></i>medios</a>
                </li>
                <li class="py-3 border-dashed-bottom-1">
                  <a href="javascript:;" class="font-company"><i class="fa fa-check font-company pe-3"
                      aria-hidden="true"></i>posts</a>
                </li>
                <li class="py-3 border-dashed-bottom-1">
                  <a href="javascript:;" class="font-company"><i class="fa fa-check font-company pe-3"
                      aria-hidden="true"></i>novedades</a>
                </li>
              </ul>
            </div>
            <div class="recent-post-box p-6 box-shadow rounded mb-6">
              <h6 class="mb-2">mas recientes</h6>
              <div class="sperator w-20 border-bottom border-2 border-company mb-5"></div>
              <div class="recent-post-list">
                <div class="row">
                  <div class="col-lg-12 col-md-6">
                    <div class="recent-post d-flex align-items-center  mb-4">
                      <div class="post-img">
                        <a href="news-single.html"><img src="{{ asset('images/group/6.jpg') }}" alt="Blog Image" class="me-3"></a>
                      </div>
                      <div class="post-detail">
                        <a href="news-single.html" class="font-black fw-bold text-uppercase">The Top Music Festivals in
                          NYC</a>
                        <p class="mb-0"><small>April 3, 2023</small></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-6">
                    <div class="recent-post d-flex align-items-center mb-4">
                      <div class="post-img">
                        <a href="news-single.html"><img src="{{ asset('images/group/7.jpg') }}" alt="Blog Image" class="me-3"></a>
                      </div>
                      <div class="post-detail">
                        <a href="news-single.html" class="font-black fw-bold text-uppercase">Live Interview from
                          conference</a>
                        <p class="mb-0"><small>April 3, 2023</small></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-6">
                    <div class="recent-post d-flex align-items-center mb-4">
                      <div class="post-img">
                        <a href="news-single.html"><img src="{{ asset('images/group/4.jpg') }}" alt="Blog Image" class="me-3"></a>
                      </div>
                      <div class="post-detail">
                        <a href="news-single.html" class="font-black fw-bold text-uppercase">Registration for opening
                          workshop</a>
                        <p class="mb-0"><small>April 3, 2023</small></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="social-media-links">
              <h6 class="mb-2">redes sociales</h6>
              <div class="sperator m-0 mb-5 w-20 border-bottom border-2 border-company"></div>
              <div class="social-media-inner">
                <div class="row g-3">
                  <div class="col-6">
                    <a href="https://www.facebook.com/profile.php?id=61563937152210" target="_blank"
                      class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                        class="fa fa-facebook-official rounded mx-2 me-3" aria-hidden="true"></i>facebook</a>
                  </div>
                  <div class="col-6">
                    <a href="https://www.youtube.com" target="_blank"
                      class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                        class="fa fa-youtube-play rounded mx-2 me-3" aria-hidden="true"></i>youtube</a>
                  </div>
                  <div class="col-6">
                    <a href="https://www.instagram.com" target="_blank"
                      class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company"><i
                        class="fa fa-instagram rounded mx-2 me-3" aria-hidden="true"></i>instagram</a>
                  </div>
                  <div class="col-6">
                    <a href="https://www.tiktok.com/@sbyetransformacion" target="_blank"
                      class="btn rounded-3 p-2 text-capitalize w-100 text-start bg-company">
                      <img src="{{ asset('images/icon/tiktok.png') }}" class="rounded mx-2 me-3" style="width: 20px;">tiktok</a>
                  </div>
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
