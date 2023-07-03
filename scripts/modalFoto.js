//Escuchamos el evento desde el bton y mandamos los datos de la tabla al modal en el input indicado
$(document).on("click", "#btnmodalfoto", function () {

    var id = $(this).data("id");
    var tipo = $(this).data("tipo");
    $("#idm").val(id);
    var labeltipo = document.getElementById("tipom");
    labeltipo.textContent = tipo;
    
})