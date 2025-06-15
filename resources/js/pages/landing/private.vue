<template>
    <Layout title="privacidad">
        <div class="container q-pt-md">
            <div v-html="$page.props.config?.value"></div>

            <div>
                <h2>Consentimiento para el uso de cookies.</h2>
                <p>
                    Para que nuestro sitio web funcione correctamente utilizamos
                    cookies. Para obtener tu consentimiento válido para el uso y
                    el almacenamiento de cookies en el navegador que utilizas
                    para acceder a nuestro sitio web y para documentarlo
                    adecuadamente utilizamos una plataforma de gestión del
                    consentimiento: CookieFirst. Esta tecnología es
                    proporcionada por Digital Data Solutions BV, Plantage
                    Middenlaan 42a, 1018 DH, Amsterdam, Países Bajos. Sitio web:
                    <a href="https://cookiefirst.com" title="Cookiefirst page"
                        >https://cookiefirst.com</a
                    >
                    denominado CookieFirst.
                </p>

                <p>
                    Cuando accedes a nuestro sitio web, se establece una
                    conexión con el servidor de CookieFirstpara darnos la
                    posibilidad de obtener tu consentimiento válido para el uso
                    de cookies determinadas. A continuación, CookieFirst
                    almacena una cookie en tu navegador para poder activar sólo
                    aquellas cookies a las que has dado tu consentimiento y para
                    documentarlo adecuadamente. Los datos procesados se
                    almacenan hasta que expira el periodo de almacenamiento
                    predefinido o hasta que solicites la eliminación de los
                    datos. A pesar de lo anterior, pueden aplicarse determinados
                    periodos de almacenamiento legales obligatorios.
                </p>
                <p>
                    CookieFirst se utiliza para obtener el consentimiento
                    legalmente requerido para el uso de cookies. La base legal
                    para ello es el artículo 6(1)(c) del Reglamento General de
                    Protección de Datos (GDPR).
                </p>
                <h2>Acuerdo de procesamiento de datos</h2>
                <p>
                    Hemos celebrado un acuerdo de procesamiento de datos con
                    CookieFirst. Se trata de un contrato exigido por la ley de
                    protección de datos, que garantiza que los datos de los
                    visitantes de nuestro sitio web solo se procesen de acuerdo
                    con nuestras instrucciones y en cumplimiento del GDPR.
                </p>
                <h2>Archivos de registro del servidor</h2>
                <p>
                    Nuestro sitio web y CookieFirst recogen y almacenan
                    automáticamente información en los denominados archivos de
                    registro del servidor, que tu navegador nos transmite
                    automáticamente. Se recogen los siguientes datos:
                </p>
                <ul>
                    <li>Tu consentimiento o la retirada del mismo</li>
                    <li>Tu dirección IP anónima</li>
                    <li>Información sobre tu navegador</li>
                    <li>Información sobre tu dispositivo</li>
                    <li>
                        La fecha y la hora en que has visitado nuestro sitio web
                    </li>
                    <li>
                        La url de la página web donde has guardado o actualizado
                        tus preferencias de consentimiento
                    </li>
                    <li>
                        La ubicación aproximada del usuario que guardó sus
                        preferencias de consentimiento
                    </li>
                    <li>
                        Un identificador único universal (UUID) del visitante
                        del sitio web que hizo clic en el banner cookie
                    </li>
                </ul>
            </div>

            <div id="cookiefirst-policy-page" class="text-justify"></div>
            <div class="q-pb-md">
                Esta política de cookies ha sido creada y actualizada por
                <a href="https://cookiefirst.com/es/politica-de-cookies/"
                    >CookieFirst - Politica de Cookies</a
                >.
            </div>

            <!-- <p style="margin-top: 2em">
                esta documentacion se encuentra actualizada conforme a la
                normativa vigente en materia de comercio electronico y
                proteccion de datos en españa y la ue.
            </p>
            <p>
                maria garriga dominguez <br />
                ultima actualizacion: junio 2025
            </p> -->
        </div>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/MainLayout.vue";

defineOptions({
    name: "Private",
});
</script>
