@extends('layouts.main')

@section('content')
<section class="banner page-banner position-relative pb-0">
    <div class="overlay">
    </div>
    <div class="container">
      <div class="page-title text-center position-relative py-5">
        <p class="text-white text-uppercase header-title">contactame</p>
      </div>
    </div>
  </section>
  <section class="contact bg-company py-6">
    <div class="container">
      <div class="contact-inner text-center text-md-start">
        <div class="row">
          <div class="col-lg-5 col-md-5 text-center">
            <img src="{{ asset('images/team/maria-delante-ordenador.png') }}" class="w-100">
          </div>
          <div class="col-lg-7 col-md-7">
            <div class="contact-form">
              <div class="form-title mb-4">
                <p class="text-white">si quieres registrarte en el area privada no olvides cubrir todos los campos para
                  que podamos comprobar y darte
                  de alta</p>
              </div>
              <div class="form">
                <form>
                  <div class="row">
                    <div class="col-lg-6">
                      <input type="text" placeholder="nombre" required class="mb-3">
                      <img src="{{ asset('images/icon/aster.png') }}" style="width: 8px; margin-top: -40px; margin-left: 77px; contain: content; float: left; opacity: 0.6;">
                    </div>
                    <div class="col-lg-6 ">
                      <input type="text" placeholder="apellidos" required class="mb-3">
                      <img src="{{ asset('images/icon/aster.png') }}" style="width: 8px; margin-top: -40px; margin-left: 86px; contain: content; float: left; opacity: 0.6;">
                    </div>
                  </div>
                  <div class="subject">
                    <input type="text" placeholder="email" required class="mb-3">
                    <img src="{{ asset('images/icon/aster.png') }}" style="width: 8px; margin-top: -40px; margin-left: 60px; contain: content; float: left; opacity: 0.6;">
                  </div>
                  <div class="radio mt-0 mb-2 radio-not-found" style="text-align: left;">
                    <i class="fa fa-circle-o text-white" style="font-size: 18px; cursor: pointer;"></i>
                    <label class="text-white">&nbsp;contacto para que me deis de alta en el area privada</label>
                    <a class="popover" tabindex="0" role="button" data-bs-toggle="popover"
                      data-bs-content="vete al area de pedidos de amazon a visualizar el pedido de tu libro, ahi tendras la fecha de compra y el numero de pedido. si no lo has comprado tu y, por ejemplo, ha sido un regalo, pide el ticket regalo para ver estos datos. y si no consigues ver los datos que te pedimos adjuntanos una foto del ticket y lo miraremos por ti. en este caso cubre con “no lo se” los campos requeridos"
                      style="float: right; background-color: transparent; border: none;"><img
                        src="{{ asset('images/icon/info.png') }}"></a>
                  </div>
                  <div class="pedido" style="text-align: left; display: none;">
                    <input type="text" placeholder="numero de pedido de amazon por la compra del libro" class="mb-3" required>
                    <img src="{{ asset('images/icon/aster.png') }}" style="width: 8px; margin-top: -40px; margin-left: 420px; contain: content; float: left; opacity: 0.6;">
                    <input type="text" placeholder="fecha de compra del libro" required class="mb-3">
                    <img src="{{ asset('images/icon/aster.png') }}" style="width: 8px; margin-top: -40px; margin-left: 211px; contain: content; float: left; opacity: 0.6;">
                  </div>
                  <div class="radio mt-0 mb-2 radio-not-found" style="text-align: left;">
                    <i class="fa fa-circle-o text-white" style="font-size: 18px; cursor: pointer;"></i>
                    <label for="radio" class="text-white">&nbsp;la persona que aparece en el ticket no soy yo</label>
                  </div>
                  <div class="message" id="message" style="display: none;">
                    <input type="text" placeholder="registro y alta en area privada" class="mb-3">
                    <textarea placeholder="mensaje" rows="4" class="mb-3" rows="5" style="resize: none;"></textarea>
                    <img src="{{ asset('images/icon/aster.png') }}"
                      style="width: 8px; margin-top: -110px; margin-left: 82px; contain: content; float: left; opacity: 0.6;">
                    <a id="tooltip-attachments" href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="right" title="añadir adjuntos" style="float: right; margin-top: -60px; contain: content; margin-right: 10px;">
                      <img src="{{ asset('images/icon/clipper.png') }}" style="width: 30px;">
                    </a>
                    <input type="file" style="display: none;" id="attachments">
                  </div>
                  <a class="btn">enviar<i class="fa fa-long-arrow-right ms-3"></i></a>
                </form>
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
      $(".radio").on("click", "i", function (e) {
        var me = $(this);
        me.toggleClass("fa-circle-o").toggleClass("fa-circle");
        updateContent(me);
      });
      $(".radio").on("click", "label", function (e) {
        var me = $(this).prev("i");
        me.toggleClass("fa-circle-o").toggleClass("fa-circle");
        updateContent(me);
      });

      $("#message").on("click", "a", function (e) {
        e.preventDefault();
        $("#attachments").trigger("click");
      });

      $("input, textarea").on("keyup", function (e) {
        e.preventDefault();
        var me = $(this), img = me.next("img");
        if (img.length > 0) {
          console.log(me.val());
          if (me.val() === "") {
            img.removeClass("invisible");
          }
          else {
            img.addClass("invisible");
          }
        }
      });

      function updateContent(el) {
        var r = el.closest("div");
        if (r.hasClass("radio-not-found")) {
          var div = r.next("div");
          if (div.is(":visible")) {
            div.hide();
          }
          else {
            div.show();
          }
        }
      }

      var popover = new bootstrap.Popover(document.querySelector(".popover"), {
        container: "body",
        trigger: "focus"
      });

      var tooltip = new bootstrap.Tooltip(document.querySelector("#tooltip-attachments"));

      $("#tooltip-attachments").on("click", function (e) {
        e.preventDefault();
        $(this).blur();
      });

    })
  </script>
@endsection