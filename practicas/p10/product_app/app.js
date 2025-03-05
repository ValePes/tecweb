// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS Object.keys(productos).length
            if(productos.length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

// FUNCIÓN PARA VALIDAR DATOS DEL PRODUCTO ANTES DE ENVIAR AL SERVIDOR
function validarProducto(producto) {
    const marcasPermitidas = ["Samsung", "Apple", "Alba", "Espasa", "Lenovo", "Dell", "Omega", "Fossil", "Oster"];
    const modeloRegex = /^[a-zA-Z0-9\s]+$/; // Solo letras, números y espacios permitidos

    // 1) Validar nombre
    if (!producto.nombre || producto.nombre.trim() === "") {
        return "El nombre no puede estar vacío.";
    }
    if (producto.nombre.length > 100) {
        return "El nombre debe tener menos de 100 caracteres.";
    }

    // 2) Validar marca
    if (!marcasPermitidas.includes(producto.marca)) {
        return "La marca debe ser una de las siguientes: " + marcasPermitidas.join(", ");
    }

    // 3) Validar modelo
    if (!producto.modelo || producto.modelo.trim() === "") {
        return "El modelo es requerido.";
    }
    if (!modeloRegex.test(producto.modelo)) {
        return "El modelo debe ser alfanumérico.";
    }
    if (producto.modelo.length > 25) {
        return "El modelo debe tener 25 caracteres o menos.";
    }

    // 4) Validar precio
    if (producto.precio === undefined || isNaN(producto.precio) || producto.precio <= 99.99) {
        return "El precio es requerido y debe ser mayor a 99.99.";
    }

    // 5) Validar detalles (opcional)
    if (producto.detalles && producto.detalles.length > 250) {
        return "Los detalles deben tener 250 caracteres o menos.";
    }

    // 6) Validar unidades
    if (isNaN(producto.unidades) || producto.unidades < 0) {
        return "El número de unidades debe ser un valor numérico mayor o igual a 0.";
    }

    // 7) Ruta de imagen (opcional, asignar imagen por defecto si no existe)
    if (!producto.imagen || producto.imagen.trim() === "") {
        producto.imagen = "img/default.png";
    }

    return null; // Si pasa todas las validaciones, devuelve null (sin errores)
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();
    
    // Obtener JSON ingresado por el usuario
    var productoJsonString = document.getElementById('description').value;
    
    try {
        // Convertir el string JSON a objeto
        var finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = document.getElementById('name').value;

        // Validar el producto antes de enviarlo
        let error = validarProducto(finalJSON);
        if (error) {
            alert("Error: " + error);
            return;
        }

        // Convertir a JSON string final
        productoJsonString = JSON.stringify(finalJSON);

        // Crear conexión AJAX
        var client = getXMLHttpRequest();
        client.open('POST', './backend/create.php', true);
        client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");

        client.onreadystatechange = function () {
            if (client.readyState == 4) {
                let response = JSON.parse(client.responseText);
                alert(response.message); // Mostrar alerta con el mensaje del servidor
            }
        };

        client.send(productoJsonString);
    } catch (error) {
        alert("Error en el formato del JSON. Verifique la sintaxis.");
    }
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

// FUNCIÓN CALLBACK DE BOTÓN "Buscar Producto"
function buscarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL TEXTO INGRESADO POR EL USUARIO
    var query = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);

            // SI HAY PRODUCTOS, LOS AGREGAMOS A LA TABLA
            if (productos.length > 0) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;

                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = "<tr><td colspan='3'>No se encontraron productos</td></tr>";
            }
        }
    };
    client.send("query=" + encodeURIComponent(query));
}
