
  function view(posicion) {

    let valor = 'ur[' + posicion + ']';

    let url = document.getElementById(valor).value;

    document.querySelector('#vistaprevia').setAttribute('src', url);

  }