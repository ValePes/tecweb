// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/imagen.png"
};

/**function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
/*
    // SE LISTAN TODOS LOS PRODUCTOS
    fetchProducts();
}
*/
function init() {
    $("#description").val(JSON.stringify(baseJSON, null, 2));
}

$(document).ready(function() {

    let edit = false;
    console.log('jQuery is Working');
    $('#product-result').hide();
    fetchProducts();

    //Busqueda de productos
    $('#search').on("input",function() {
        let search = $(this).val();
        $.get("./backend/product-search.php", { search: search }, function (data) {
            let productos = JSON.parse(data);
            let template = "", template_bar = "";
            productos.forEach(producto => {
                let descripcion = `
                    <li>precio: ${producto.precio}</li>
                    <li>unidades: ${producto.unidades}</li>
                    <li>modelo: ${producto.modelo}</li>
                    <li>marca: ${producto.marca}</li>
                    <li>detalles: ${producto.detalles}</li>
                `;
                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>
                            <a href="#" class="product-item">${producto.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td><button class="product-delete btn btn-danger">
                            Eliminar
                        </button></td>
                    </tr>
                `;
                template_bar += `<li>${producto.nombre}</li>`;
            });
            $("#container").html(template_bar);
            $("#products").html(template);
            $("#product-result").addClass("d-block");
        });
    });
    //Agregar producto y validarlo
    $('#product-form').submit(function(e) {
        e.preventDefault();
        let productoJsonString = $("#description").val();
        let finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = $("#name").val();
        finalJSON['id'] = $("#productId").val();

        let mensajeError = "";
        if (!finalJSON['nombre'].trim() || finalJSON['nombre'].length > 100) {
            mensajeError = "El nombre no puede estar vacío y debe tener menos de 100 caracteres.";
        } else if (finalJSON['marca'].length > 25) {
            mensajeError = "La marca no debe exceder los 25 caracteres y debe ser alguna de las siguientes: Samsung, Apple, Alba, Espasa, Lenovo, Dell, Omega, Fossil, Oster.";
        } else if (finalJSON['modelo'].length > 25) {
            mensajeError = "El modelo es requerido, alfanumérico y debe tener 25 caracteres o menos.";
        } else if (finalJSON['precio'] < 99.99) {
            mensajeError = "El precio es requerido y debe ser mayor a 99.99.";
        } else if (finalJSON['detalles'].length >= 250) {
            mensajeError = "Los detalles deben tener 250 caracteres o menos.";
        } else if (finalJSON['unidades'] < 0) {
            mensajeError = "Las unidades deben ser un número mayor o igual a 1.";
        }

        if (mensajeError) {
            $("#container").html(`<li style="list-style: none;">${mensajeError}</li>`);
            $("#product-result").addClass("d-block");
            return;
        }

        //Verificamos si hay una edicion del producto
        let url = edit ? "./backend/product-edit.php" : "./backend/product-add.php";  
        $.ajax({
            url: url,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(finalJSON),
            success: function (response) {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#container").html(template_bar);
                $("#product-result").addClass("d-block");

                $('#product-form').trigger('reset');
                $("#description").val(JSON.stringify(baseJSON, null, 2));

                fetchProducts();
            }
        });
    });


    // Mostrar productos
    function fetchProducts() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                let products = JSON.parse(response);
                let template = '';
                products.forEach(product => {
                    let description = `
                        <li>precio: ${product.precio}</li>
                        <li>unidades: ${product.unidades}</li>
                        <li>modelo: ${product.modelo}</li>
                        <li>marca: ${product.marca}</li>
                        <li>detalles: ${product.detalles}</li>
                    `;

                    template += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>
                                <a href="#" class="product-item">${product.nombre}</a>
                            </td>
                            <td><ul>${description}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#products').html(template);
            }
        });
    }

    //Eliminar un proucto
    $(document).on('click', '.product-delete', function() {
        if (confirm('¿Seguro que desea eliminar este producto?')) {
            //let element = $(this)[0].parentElement.parentElement;
            let id = $(this).closest("tr").attr("productId");
            $.get("./backend/product-delete.php", { id: id }, function (response) {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#container").html(template_bar);
                $("#product-result").addClass("d-block");
                fetchProducts();
            });
        }
    });

    //Editar
    $(document).on('click', '.product-item', function() {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        
        $.post('./backend/product-single.php', { id }, function(response) {
            const product = JSON.parse(response);
            $('#name').val(product[0].nombre);
            $('#productId').val(product.id);

            // Convertir el description a un formato JSON y asignar
            const productDescription = {
                precio: product[0].precio,
                unidades: product[0].unidades,
                modelo: product[0].modelo,
                marca: product[0].marca,
                detalles: product[0].detalles,
                imagen: product[0].imagen
            };
            $('#description').val(JSON.stringify(productDescription, null, 2));
            $('#productId').val(id);
            
            $("#submit-btn").text("Editar Producto");
            edit = true;

            fetchProducts();
        });
    });
    init();
});

