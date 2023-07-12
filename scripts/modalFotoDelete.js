//Escuchamos el evento desde el bton y mandamos los datos de la tabla al modal en el input indicado
$(document).on("click", "#btnmodalfotoDelete", function () {

    var id = $(this).data("iddelete");
    var nombre = $(this).data("nombre");
    var foto = $(this).data("urldelete");

    $("#iddelete").val(id);
    $("#nombre").val(nombre);
    document.getElementById("fotod").src=foto;

 
    
})