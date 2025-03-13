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
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function (response) {
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                const productos = JSON.parse(response);

                // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                if (Object.keys(productos).length > 0) {
                    // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
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
                }
            }
        });
    }

    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search=' + $('#search').val(),
                data: { search },
                type: 'GET',
                success: function (response) {
                    if (!response.error) {
                        // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                        const productos = JSON.parse(response);

                        // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                        if (Object.keys(productos).length > 0) {
                            // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
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
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#name').on('keyup', function() {
        const nombre = $(this).val();

        if (nombre) {
            $.ajax({
                url: './backend/product-search.php', 
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
        const descripcion = $('#form-descripcion').val();

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
        } else if (descripcion.length > 250) {
            mensajeError = "La descripción no debe exceder los 250 caracteres.";
        }
    
        if (mensajeError) {
            $('#container').html(`<li style="list-style: none;">${mensajeError}</li>`);
            $('#product-result').show();
            return;
        }
    
        let postData = {
            nombre: $('#name').val(),
            precio: precio,
            unidades: unidades,
            modelo: modelo,
            marca: marca,
            detalles: descripcion,
            imagen: $('#imagen_defecto').val(),
            id: $('#productId').val()
        };
    
        
        const url = edit ? './backend/product-edit.php' : './backend/product-add.php';
    
        $.post(url, postData, function (response) {
            let respuesta = JSON.parse(response);
            $('#container').html(`
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `);
            $('#product-result').show();
            listarProductos();  
            edit = false;  
            $('button.btn-primary').text("Agregar Producto");
        });
    });
    

    $(document).on('click', '.product-delete', (e) => {
        if (confirm('¿Realmente deseas eliminar el producto?')) {
            const element = $(this)[0].activeElement.parentElement.parentElement;
            const id = $(element).attr('productId');
            $.post('./backend/product-delete.php', { id }, (response) => {
                $('#product-result').hide();
                listarProductos();
            });
        }
    });

    $(document).on('click', '.product-item', function (e) {
        e.preventDefault();

        const element = $(this).closest('tr');  
        const id = element.attr('productId'); 

        $.post('./backend/product-single.php', { id }, function (response) {
            let product = JSON.parse(response); 

            $('#name').val(product.nombre);
            $('#form-precio').val(product.precio);
            $('#form-unidades').val(product.unidades);
            $('#form-modelo').val(product.modelo);
            $('#form-marca').val(product.marca);
            $('#form-descripcion').val(product.detalles);
            $('#imagen_defecto').val(product.imagen);
            $('#productId').val(product.id);

            edit = true;
            $('button.btn-primary').text("Modificar Producto");
        });
    });
});