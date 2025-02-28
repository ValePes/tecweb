var form = document.getElementById('formularioProductos');
var mensaje1 = '';
var mensaje2 = '';
var mensaje3 = '';
var mensaje4 = '';
var mensaje5 = '';
var mensaje6 = '';
var mensaje7 = '';

function validar_nombre(){
    let entrada = document.getElementById("form-nombre").value;
    let sinErrores = true; 
    if(entrada.trim() === "" || entrada.length > 100){
        mensaje1 = "El campo de nombre no puede estar vacío y debe tener menos de 100 caracteres."; 
        sinErrores = false; 
    }
    return sinErrores; 
}

function validar_marca(){
    let entrada = document.getElementById("form-marca"); 
    let sinErrores = true; 
    if(entrada.value.trim() === "") { 
        mensaje2 = "Es obligatorio seleccionar una marca"; 
        sinErrores = false; 
    }
    return sinErrores; 
}

function validar_modelo(){
    let entrada = document.getElementById("form-modelo").value; 
    let sinErrores = true; 
    if(entrada.trim() === "" || entrada.length > 25){
        mensaje3 = "El campo de marca no puede estar vacío y debe tener máximo 25 caracteres."; 
        sinErrores = false; 
    }
    return sinErrores; 
}

function validar_precio() {
    let precio = document.getElementById("form-precio").value.trim(); // Captura el valor del precio
    let sinErrores = true;
    if (precio === "" || isNaN(precio) || Number(precio) <= 99.99) {
        mensaje4 = "El precio es requerido y debe ser mayor a 99.99.\n";
        sinErrores = false;
    }
    return sinErrores; 
}

function validar_detalles(){
    let entrada = document.getElementById("form-detalles").value; 
    let sinErrores = true; 
    if(entrada.length > 250){
        mensaje5 ="Los detalles deben tener 250 caracteres o menos"; 
        sinErrores =  false; 
    }
    return sinErrores; 
}

function validar_unidades() {
    let unidades = document.getElementById("form-unidades").value.trim();
    let sinErrores = true;
    if (unidades === "" || isNaN(unidades) || Number(unidades) < 0) {
        mensaje6 = "El número de unidades debe ser un valor numérico mayor o igual a 0.\n";
        sinErrores = false;
    }
    return sinErrores; 
}

function validar_imagen() {
    let imagenInput = document.getElementById("form-imagen");
    let imagenHidden = document.getElementById("imagen-hidden");

    if (imagenInput.files.length === 0) { // Si no se seleccionó imagen
        imagenHidden.value = "img/imagen.png"; // Asigna la imagen por defecto al input hidden
    }
    return true;
}





document.getElementById("form-nombre").onfocus = function() {
    document.getElementById("res1").innerHTML = "Ingresa el nombre del producto";
};
document.getElementById("form-nombre").onblur = function() {
    if (!validar_nombre()) {
        document.getElementById("res1").innerHTML = '<span>' + mensaje1 + '</span>';
    } else {
        document.getElementById("res1").innerHTML = '';
    }
};
document.getElementById("form-marca").onfocus = function() {
    document.getElementById("res2").innerHTML = "Selecciona la marca del producto";
};
document.getElementById("form-marca").onblur = function() {
    if (!validar_marca()) {
        document.getElementById("res2").innerHTML = '<span>' + mensaje2 + '</span>';
    } else {
        document.getElementById("res2").innerHTML = '';
    }
};
document.getElementById("form-modelo").onfocus = function() {
    document.getElementById("res3").innerHTML = "Ingresa el modelo del producto";
};
document.getElementById("form-modelo").onblur = function() {
    if (!validar_modelo()) {
        document.getElementById("res3").innerHTML = '<span>' + mensaje3 + '</span>';
    } else {
        document.getElementById("res3").innerHTML = '';
    }
};
document.getElementById("form-precio").onfocus = function() {
    document.getElementById("res4").innerHTML = "Ingresa el precio del producto";
};
document.getElementById("form-precio").onblur = function() {
    if (!validar_precio()) {
        document.getElementById("res4").innerHTML = '<span>' + mensaje4 + '</span>';
    } else {
        document.getElementById("res4").innerHTML = '';
    }
};
document.getElementById("form-detalles").onfocus = function() {
    document.getElementById("res5").innerHTML = "Ingresa los detalles del producto";
};
document.getElementById("form-detalles").onblur = function() {
    if (!validar_detalles()) {
        document.getElementById("res5").innerHTML = '<span>' + mensaje5 + '</span>';
    } else {
        document.getElementById("res5").innerHTML = '';
    }
};
document.getElementById("form-unidades").onfocus = function() {
    document.getElementById("res6").innerHTML = "Ingresa el número de unidades del producto";
};
document.getElementById("form-unidades").onblur = function() {
    if (!validar_unidades()) {
        document.getElementById("res6").innerHTML = '<span>' + mensaje6 + '</span>';
    } else {
        document.getElementById("res6").innerHTML = '';
    }
};
document.getElementById("form-imagen").onfocus = function() {
    document.getElementById("res7").innerHTML = "Ingresa una imagen del producto";
};
document.getElementById("form-imagen").onblur = function() {
    if (!validar_imagen()) {
        document.getElementById("res7").innerHTML = '<span>' + mensaje7 + '</span>';
    } else {
        document.getElementById("res7").innerHTML = '';
    }
};



form.addEventListener('submit', function(event) {
    // Prevenir el envío por defecto para hacer las validaciones primero
    event.preventDefault();
    let hayErrores = false;

    if( !validar_nombre() ) {
        let div1 = document.getElementById("res1");
        div1.innerHTML = '<span>'+mensaje1+'</span>';
        hayErrores = true;
    }
    if( !validar_marca() ) {
        let div2 = document.getElementById("res2");
        div2.innerHTML = '<span>'+mensaje2+'</span>';
        hayErrores = true;
    }
    if( !validar_modelo() ) {
        let div3 = document.getElementById("res3");
        div3.innerHTML = '<span>'+mensaje3+'</span>';
        hayErrores = true;
    }
    if( !validar_precio() ) {
        let div4 = document.getElementById("res4");
        div4.innerHTML = '<span>'+mensaje4+'</span>';
        hayErrores = true;
    }
    if(!validar_detalles()){
        let div5 = document.getElementById("res5"); 
        div5.innerHTML = '<span>'+mensaje5+'</span>';
        hayErrores = true; 
    }
    if (!validar_unidades()) {
        let div6 = document.getElementById("res6");
        div6.innerHTML = '<span>' + mensaje6 + '</span>';
        hayErrores = true;
    }
    validar_imagen();
    if( !hayErrores ) {
        this.submit();
    }
});