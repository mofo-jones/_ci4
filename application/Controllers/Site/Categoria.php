<?php

/**
 * Controlador de métodos de acessa a dados de Categoria
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Site;

use App\Controllers\KiController;
use App\Models\Site\CategoriaModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Logger;

class Categoria extends KiController {

    public function index() {
        echo 'ok';
    }

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        parent::__construct($request, $response, $logger);
    }

    public function getList() {
        $categoriaModel = new CategoriaModel();
        return json_encode(array('data' => array('categorias' => $categoriaModel->findAll())));
    }

    public function get() {
        $json           = json_decode($this->request->getVar('data')); //decodifica o json User do post data
        $categoriaModel = new CategoriaModel();
        $categoria      = $categoriaModel->find($json->id);
        return json_encode(array('data' => array('card' => $categoria, 'success' => true, 'error' => '---')));
    }

}
