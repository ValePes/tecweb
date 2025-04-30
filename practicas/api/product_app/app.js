// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

$(document).ready(function () {
    let edit = false;

    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    $('#product-result').hide();
    listarProductos();

    function listarProductos() {
        $.get("http://localhost/tecweb/practicas/api/product_app/backend/products", function (data) {
            console.log("Tipo de dato recibido:", typeof data);
            console.log("Respuesta del servidor:", data);
            //let productos = JSON.parse(data);
                    let productos = data; 
                    let template = '';

                    productos.forEach(producto => {
                        // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                        let descripcion = '';
                        descripcion += '<li>precio: ' + producto.precio + '</li>';
                        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>marca: ' + producto.marca + '</li>';
                        descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                    $('#products').html(template);  
            });
        }

        $("#search").on("input", function () {
            let search = $(this).val();
            $.get(`http://localhost/tecweb/practicas/api/product_app/backend/products/${search}`, function (data) {
                let productos = data;
                            let template = '';
                            let template_bar = '';
                            productos.forEach(producto => {
                                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                                let descripcion = '';
                                descripcion += '<li>precio: ' + producto.precio + '</li>';
                                descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                                descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                                descripcion += '<li>marca: ' + producto.marca + '</li>';
                                descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                                template += `
                                    <tr productId="${producto.id}">
                                        <td>${producto.id}</td>
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            // SE HACE VISIBLE LA BARRA DE ESTADO
                            $('#product-result').show();
                            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                            $('#container').html(template_bar);
                            // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                            $('#products').html(template);  
                         });
        });

    $('#name').on('keyup', function() {
        const nombre = $(this).val();

        if (nombre) {
            $.ajax({
                url: 'http://localhost/tecweb/practicas/api/product_app/backend/products/${nombre}', 
                method: 'GET',
                data: { search: nombre },
                success: function(response) {
                    const data = JSON.parse(response);
                    
                    if (data.length > 0) {
                        $('#error-nombre').text('El nombre del producto ya existe en la base de datos').css('color', 'red');
                        $('#product-form button').prop('disabled', true);
                    } else {
                        $('#error-nombre').text('');
                        $('#product-form button').prop('disabled', false);
                    }
                },
                error: function() {
                    $('#error-nombre').text('Hubo un error en la validación').css('color', 'red');
                }
            });
        } else {
            $('#error-nombre').text('');
            $('#product-form button').prop('disabled', false);
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();
    
        let mensajeError = "";
        const nombre = $('#name').val(); 
        const precio = $('#form-precio').val();
        const unidades = $('#form-unidades').val();
        const modelo = $('#form-modelo').val();
        const marca = $('#form-marca').val();
        const descripcion = $('#form-description').val();

        if(!nombre || nombre.length > 100){
            mensajeError = "Debes colocar el nombre y no debe exceder los 100 caracteres"; 
        }else if(!precio || precio <= 99.99) {
            mensajeError = "El precio debe ser mayor a 99.99";
        } else if (unidades < 1) {
            mensajeError = "Debe haber al menos un producto.";
        } else if (!modelo || modelo.length > 25) {
            mensajeError = "El modelo no debe exceder los 25 caracteres.";
        } else if (!marca) {
            mensajeError = "Seleccionar una marca.";
        } else if (descriptcion.length > 250) {
            mensajeError = "La descripción no debe exceder los 250 caracteres.";
        }
    
        if (mensajeError) {
            $('#container').html(`<li style="list-style: none;">${mensajeError}</li>`);
            $('#product-result').show();
            return;
        }
    
        let postData = JSON.stringify({
            nombre: $('#name').val(),
            precio: precio,
            unidades: unidades,
            modelo: modelo,
            marca: marca,
            detalles: description,
            imagen: $('#imagen_defecto').val(),
            id: $('#productId').val() 
        });

        const url = "http://localhost/tecweb/practicas/api/product_app/backend/product";
        const method = edit ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            method: method,
            data: postData,
            contentType: 'application/json', 
            success: function(response) {
                console.log("Respuesta del servidor:", response); 
                let respuesta = response;
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#container").html(template_bar);
                $("#product-result").addClass("d-block");

                $('#product-form').trigger('reset');
                listarProductos();  
                edit = false;  
                $('button.btn-primary').text("Agregar Producto");
               
            }
        });
    });
    

   // Eliminar producto
   $(document).on("click", ".product-delete", function () {
    if (confirm("¿Desea eliminar el producto?")) {
        let id = $(this).closest("tr").attr("productId");

        fetch(`http://localhost/tecweb/practicas/api/product_app/backend/product/${id}`, {
            method: 'DELETE'
        })
        .then(res => res.json())
        .then(respuesta => {
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            $("#container").html(template_bar);
            $("#product-result").addClass("d-block");
            listarProductos();
        });
    }
});

    $(document).on('click', '.product-item', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId'); 
    
        $.get(`http://localhost/tecweb/practicas/api/product_app/backend/product/${id}`, function(response) {
            console.log('Respuesta del servidor:', response);  
            let product = response;  
        
            $('#name').val(product.nombre);
            $('#form-precio').val(product.precio);
            $('#form-unidades').val(product.unidades);
            $('#form-modelo').val(product.modelo);
            $('#form-marca').val(product.marca);
            $('#form-descritcion').val(product.detalles);
            $('#imagen_defecto').val(product.imagen); 
            $('#productId').val(product.id);
        
            // Cambiar el texto del botón
            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });        
    });
});
