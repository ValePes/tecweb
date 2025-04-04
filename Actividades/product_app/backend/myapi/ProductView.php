<?php
/*namespace TECWEB\MYAPI;

class ProductView {

    // Devolver la lista de productos en formato JSON
    public function renderProductList($products) {
        echo json_encode($products, JSON_PRETTY_PRINT);
    }

    // Devolver un solo producto en formato JSON
    public function renderSingleProduct($product) {
        if (empty($product)) {
            echo json_encode(["status" => "error", "message" => "Producto no encontrado"]);
            return;
        }
        echo json_encode($product, JSON_PRETTY_PRINT);
    }

    // Mostrar mensaje de éxito o error
    public function renderMessage($message) {

        echo json_encode($message, JSON_PRETTY_PRINT);
    }

    // Devolver los resultados de búsqueda en formato JSON
    public function renderSearchResults($results) {
        echo json_encode($results, JSON_PRETTY_PRINT);
    }

    // Para devolver el formulario de agregar o editar producto (si es necesario)
    public function renderProductForm($product = null) {
        // Este método solo se usará si necesitas devolver el formulario en formato JSON o si se usa de alguna manera para el frontend
        if ($product) {
            echo json_encode($product, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay datos del producto"], JSON_PRETTY_PRINT);
        }
    }
}*/

namespace TECWEB\MYAPI;
class ProductView {
    // Devolver la lista de productos en formato JSON
    public function renderProductList($products) {
        echo json_encode($products, JSON_PRETTY_PRINT);
    }

    // Devolver un solo producto en formato JSON
    public function renderSingleProduct($product) {
        if (empty($product)) {
            echo json_encode(["status" => "error", "message" => "Producto no encontrado"]);
            return;
        }
        echo json_encode($product, JSON_PRETTY_PRINT);
    }

    // Mostrar mensaje de éxito o error
    public function renderMessage($message) {
        echo json_encode($message, JSON_PRETTY_PRINT);
    }

    // Devolver los resultados de búsqueda en formato JSON
    public function renderSearchResults($results) {
        echo json_encode($results, JSON_PRETTY_PRINT);
    }

    // Para devolver el formulario de agregar o editar producto (si es necesario)
    public function renderProductForm($product = null) {
        // Este método solo se usará si necesitas devolver el formulario en formato JSON o si se usa de alguna manera para el frontend
        if ($product) {
            echo json_encode($product, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["status" => "error", "message" => "No hay datos del producto"], JSON_PRETTY_PRINT);
        }
    }
}
?>


