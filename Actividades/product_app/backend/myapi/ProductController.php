<?php
namespace TECWEB\MYAPI;
require_once 'ProductModel.php';  // Incluir el modelo
require_once 'ProductView.php';   // Incluir la vista

class ProductController {
    private $model;
    private $view;

    // Constructor que recibe los parámetros de conexión y crea el modelo
    public function __construct($db, $user ='root', $pass ='jojoyrl8') {
        $this->model = new ProductModel($db, $user, $pass);  // Crear el modelo con la conexión a la base de datos
        $this->view = new ProductView();  // Crear la vista
    }

     // Mostrar la lista de productos
     public function showProductList() {
        $this->model->list();  // Llamar al método del modelo para obtener la lista de productos
        $products = $this->model->getData();  // Obtener los datos del modelo
        $this->view->renderProductList($products);  // Pasar los productos a la vista para mostrarlos
    }

    // Agregar un nuevo producto
    public function addProduct($prod) {
        $this->model->add($prod);  // Llamar al método del modelo para agregar el producto
        $result = $this->model->getData();  // Obtener los resultados
        $this->view->renderMessage($result);  // Mostrar el mensaje resultante (success o error)
    }

    public function editProduct($data) {
        $this->model->edit($data);  // Llamar al método del modelo para editar el producto
        $result = $this->model->getData();  // Obtener los resultados
    
        // Verificar que el resultado contenga las claves 'status' y 'message'
        $status = isset($result['status']) ? $result['status'] : 'error';
        $message = isset($result['message']) ? $result['message'] : 'Hubo un problema al procesar la solicitud';
    
        // Mostrar el mensaje resultante (success o error)
        $this->view->renderMessage($status, $message);
    }

    // Eliminar un producto
    public function deleteProduct($id) {
        $this->model->delete($id);  // Llamar al método del modelo para eliminar el producto
        $result = $this->model->getData();  // Obtener los resultados
        $this->view->renderMessage($result);  // Mostrar el mensaje resultante (success o error)
    }

    // Buscar productos
    public function searchProduct($search) {
        $this->model->search($search);  // Llamar al método del modelo para realizar la búsqueda
        $result = $this->model->getData();  // Obtener los resultados
        $this->view->renderSearchResults($result);  // Mostrar los resultados de la búsqueda
    }

    // Ver un solo producto por ID
    public function viewProduct($id) {
        $this->model->single($id);  // Llamar al método del modelo para obtener el producto
        $result = $this->model->getData();  // Obtener los resultados
        $this->view->renderSingleProduct($result);  // Mostrar los detalles del producto
    }


}
?>


