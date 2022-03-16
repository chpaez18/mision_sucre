//archivo con funciones para validar los formularios

function validation(){
    
    var user = document.getElementById("user").value;
     var pass = document.getElementById("pass").value;
    
   
    if(user=="" && pass==""){
        
        document.getElementById('d').innerHTML = 'Debe suministrar un usuario y una Contraseña para iniciar sesion';
        document.getElementById('d').style.color="#d32e12";
        return false;
    }else if (user==""){
        
        document.getElementById('d').innerHTML = 'El campo de usuario esta vacio';
        document.getElementById('d').style.color="#d32e12";
        return false;
    }else if (pass==""){
        document.getElementById('d').innerHTML = 'El campo de la Contraseña esta vacio';
        document.getElementById('d').style.color="#d32e12";
       
        return false;
    }
        
    
    
   
}

function validationZonas(){
    
    var descripcion = document.getElementById("descripcion").value;
    
    if(nombre == ""){
        document.getElementById('d').innerHTML = 'Debe ingresar una descripción';
        return false;
    }    
   
}



