// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/imagen.png"
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

 
// FUNCIÓN PARA VALIDAR Y AGREGAR PRODUCTO
function agregarProducto(e) {
    e.preventDefault();

    // OBTENER DATOS DEL FORMULARIO
    var nombre = document.getElementById('name').value.trim();
    var productoJsonString = document.getElementById('description').value.trim();

    if (!nombre || nombre.length > 100) {
        alert("El nombre no puede estar vacío y debe tener menos de 100 caracteres.");
        return;
    }

    try {
        var finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        alert("El formato del JSON es incorrecto.");
        return;
    }

    // VALIDAR MARCA
    const marcasPermitidas = ["Samsung", "Apple", "Alba", "Espasa", "Lenovo", "Dell", "Omega", "Fossil", "Oster"];
    if (!marcasPermitidas.includes(finalJSON.marca)) {
        alert("Marca inválida. Debe ser una de las siguientes: " + marcasPermitidas.join(", "));
        return;
    }

    // VALIDAR MODELO
    if (!finalJSON.modelo || finalJSON.modelo.length > 25 || !/^[a-zA-Z0-9\-]+$/.test(finalJSON.modelo)) {
        alert("El modelo es requerido, alfanumérico y debe tener 25 caracteres o menos.");
        return;
    }

    // VALIDAR PRECIO
    if (!finalJSON.precio || finalJSON.precio < 99.99) {
        alert("El precio es requerido y debe ser mayor a 99.99.");
        return;
    }

    // VALIDAR DETALLES (Opcional)
    if (finalJSON.detalles && finalJSON.detalles.length > 250) {
        alert("Los detalles deben tener 250 caracteres o menos.");
        return;
    }

    // VALIDAR UNIDADES
    if (isNaN(finalJSON.unidades) || finalJSON.unidades < 0) {
        alert("Las unidades deben ser un número mayor o igual a 0.");
        return;
    }

    // VALIDAR IMAGEN (Opcional)
    if (!finalJSON.imagen) {
        finalJSON.imagen = "img/default.png";
    }

    // AGREGAR EL NOMBRE AL JSON FINAL
    finalJSON['nombre'] = nombre;
    productoJsonString = JSON.stringify(finalJSON);

    // ENVIAR AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let response = JSON.parse(client.responseText);
            alert(response.message); // MOSTRAR EL MENSAJE DE ÉXITO O ERROR
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    // Convierte el JSON a string para mostrarlo en el formulario
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
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
