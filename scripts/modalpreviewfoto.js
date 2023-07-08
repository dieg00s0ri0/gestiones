document.getElementById('foto').onchange=function (e) {
    let reader =new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload=function(){
        let imgpreview=document.getElementById('imgpreviewm');
        imagen=document.createElement('img');
        imagen.src=reader.result;
        imgpreview.append(imagen);
      }
}