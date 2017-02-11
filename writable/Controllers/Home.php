<?php

namespace App\Controllers;

use App\Models\TempModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\Logger;
use Exception;

class Home extends Controller {

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers:Authorization');
//        header('Access-Control-Allow-Headers:authorization');
        parent::__construct($request, $response, $logger);
    }

    public function save() {
        if (!empty($this->request->getVar('data'))) {

            $error = ''; // retorna o erro da tentativa de inserir o Usuário

            $json = json_decode($this->request->getVar('data')); //decodifica o json User do post data

            $tmodel = new TempModel();
            try {
                $id = $tmodel->save(array(
                    'FIRST_NAME' => $json->first_name,
                    'LAST_NAME'  => $json->last_name,
                    'EMAIL'      => $json->email));

                $success = (empty($id)) ? false : true;
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
            return json_encode(array('data' => array('id' => $id, 'success' => $success, 'error' => $error)));
        }
        return;
    }

    public function getUsers() {
       (empty(getallheaders()['authorization']))? die : $user = getallheaders()['authorization'];          
        $tmodel = new TempModel();
        return json_encode($tmodel->findAll());
    }

}
