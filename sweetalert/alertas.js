function error(msj){
    return (
    Swal.fire({
        title: '¡Error!',
        text: msj,
        icon: 'error',
        showConfirmButton: true
    }))
}
function succes(msj){
    return (
    Swal.fire({
        title: 'Exito!',
        text: msj,
        icon: 'success',
        showConfirmButton: true
    }))
}