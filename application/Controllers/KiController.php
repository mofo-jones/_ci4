<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\Logger;

/**
 * Controlador para ser extendido. compartilhar funções
 *
 * @author Jones Pereira 15/12/2016
 */
class KiController extends Controller {

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        parent::__construct($request, $response, $logger);

        //carrega as bibliotecas necessárias para os controladores
        helper(['url', 'app']);

        // Cabeçalho padrão para as requisições
        header('Access-Control-Allow-Origin:*');
//        header('Content-Type:image/*');
        header('Content-Type:multipart/form-data');
//        header('Accept', 'application/json');
    }

}
