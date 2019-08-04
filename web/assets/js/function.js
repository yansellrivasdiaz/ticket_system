$(document).ready(function () {
    /* Esta funsion es para cuando el scroll baja aparezca el boton de subir */

});
function alertshow(message, type) {
    var alert_icon = `<i class="fas text-${type} fa-exclamation-triangle"></i>`;
    var alert = `<div id="alert-message" style="display:none; position: fixed; bottom:0px; right:0; z-index:2000; width:29em;" class="alert alert-${type} alert-dismissible fade show" role="alert">
    ${alert_icon} ${message}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>`;
    if ($("body #alert-message").length > 0) {
        $("#alert-message").remove();
        $("body").append(alert);
        $("body #alert-message").show('slow').delay(5000).hide('slow');
    } else {
        $("body").append(alert);
        $("body #alert-message").show('slow').delay(5000).hide('slow');
    }
}