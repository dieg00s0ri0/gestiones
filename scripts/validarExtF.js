function validarExtF() {
    var archivoInput = document.getElementById('foto');
    var files = document.getElementById('foto').files;
    var zero = document.getElementsByName('foto');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.png|.jpg|.img|.jpeg)$/i;


    if (!extPermitidas.exec(archivoRuta)) {
      Swal.fire({
        title: '¡Error!',
        text: 'solo se admiten archivos de tipo imagen',
        icon: 'error',
        showConfirmButton: true
      })
      archivoInput.value = '';
      return false;
    }else{
        
        

    }
    if (zero.length == "") {
      alert("selecciones un archivo");
      return false;
    }

  }