!function(){if(document.querySelector(".btn-eliminar")){document.querySelectorAll(".btn-eliminar").forEach(t=>{t.addEventListener("click",(function(e){e.preventDefault();const n=t.parentNode;Swal.fire({title:"¿Estas seguro?",text:"¡No podrás revertir esto!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"¡Sí, eliminar!"}).then(t=>{t.value&&n.submit()})}))})}}();