function validarExtF() {
  var archivoInput = document.getElementById("foto");
  var files = document.getElementById("foto").files;
  var zero = document.getElementsByName("foto");
  var archivoRuta = archivoInput.value;
  var extPermitidas = /(.png|.jpg|.img|.jpeg)$/i;
  // igualo una valiable al componente que tiene ese id
  let imgpreview = document.getElementById("imgpreview");

  if (!extPermitidas.exec(archivoRuta)) {
    // mando un vacio a ese componente
    //mensaje de error
    imgpreview.innerHTML="";
    Swal.fire({
      title: "¡Error!",
      text: "solo se admiten archivos de tipo imagen",
      icon: "error",
      showConfirmButton: true,
    });
    //mando un vacio al componente que tiene esta variable
    archivoInput.value = "";
    return false;
  } else {
    //en caso contrario que si es una imagen previsualizo la imagen
      let reader = new FileReader();
      reader.readAsDataURL(files[0]);
      reader.onload = function () {
        
        imagen = document.createElement("img");
        imagen.src = reader.result;
        imagen.style.width="250px";
        // si tiene una imagen cargarada mando un vacio para que se quite
        imgpreview.innerHTML="";
        imgpreview.append(imagen);
      };
    
  }
  if (zero.length == 0) {
    alert("selecciones un archivo");
    return false;
  }
}
