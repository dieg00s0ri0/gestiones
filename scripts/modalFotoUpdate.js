//Escuchamos el evento desde el bton y mandamos los datos de la tabla al modal en el input indicado
$(document).on("click", "#btnmodalfotoupdate", function () {
  var id = $(this).data("id");
  var tipo = $(this).data("tipo");
  var fecha = $(this).data("fecha");
  var nombre = $(this).data("nombre");
  $("#idm").val(id);
  $("#labeltipo").val(tipo);
  $("#fecha").val(fecha);
  $("#nombreu").val(nombre);

  
//creamos una variable y la instanciamos al id del combobox
  var combobox = document.getElementById("comboTipos");
//instanciamos una variable al primer option del combo
  var opcion = combobox.options[0]; // Accede a la primera opción (índice 0)
  opcion.text = tipo;//a la primera opcion le damos el tipo que ya se tiene en el registro
  var opciones = ["Evidencia", "Predio", "Acta circunstanciada"];//creamos un array con las diferentes opciones
  if (combobox.options.length > 1) {//validamos si el cbx ya tiene mas de una opcion es por que ya se cargo y no se carga nada mas para no repetir
  
} else {//en caso contrario
    for (var i = 0; i < opciones.length; i++) {//declaracion de un ciclo para recorrer las opciones e insertarlo
        var opcion = document.createElement("option");//creamos un elemento de tipo opcion
        opcion.text = opciones[i]; //en ese elemento añadimos la primara opcion
        
        if (opciones[i] == tipo) {//validamos que si la opcion es igual a la que ya se tiene no haga nada
        } else {
          
          combobox.appendChild(opcion);//en caso contrario carga la opcion al elemento
        }
        }
    }
  
  
});
