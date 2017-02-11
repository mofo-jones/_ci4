<?php

/**
 * Controlador de métodos de acessa a dados do contato
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Cliente;

use App\Controllers\KiController;
use App\Models\ContatoModel;
use Exception;
use function getFildsSearch;
use function paginator;

class Contato extends KiController {

    public function index() {
        echo 'ok';
    }

    public function save() {
//        if (!empty($this->request->getVar('data'))) {

        $error  = ''; // retorna o erro da tentativa de inserir o contato
        $json   = json_decode($this->request->getVar('data')); //decodifica o json Contato do post data
//        $json   = json_decode('{"id":"","clientesId":"1","nome":"Jones","fonePessoal":"51998889243","foneResidencial":"05136531150","tipoContato":"1","observacoes":"nenhuma"}'); //decodifica o json Contato do post data
        $tmodel = new ContatoModel();
        try {
            $id = $tmodel->save(array(
                'id'               => $json->id,
                'clientes_id'      => $json->clientesId,
                'nome'             => $json->nome,
                'fone_pessoal'     => $json->fonePessoal,
                'fone_residencial' => $json->foneResidencial,
                'tipo_contato'     => $json->tipoContato,
                'observacoes'      => $json->observacoes,
            ));
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            log_msg($ex->getMessage(), ':::');
        }

        $success = ((!empty($id)) && ($id != false) ) ? TRUE : false;
        return json_encode(array('data' => array('id' => ($id === TRUE ) ? $json->id : $id, 'success' => $success, 'error' => $error)));
//        }
//        return '>>>>>>>>>>>>>>>>>>>';
    }

    public function get() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ContatoModel();
            $contato = $tmodel->find($json->id);
            return json_encode(array('data' => array('contato' => $contato, 'success' => true, 'error' => '---')));
        }
    }

    public function getCountContato() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ContatoModel();
            $contatos = count($tmodel->findWhere('clientes_id', $json->id));
            log_msg($contatos);
            return json_encode(array('data' => array('countContato' => $contatos, 'success' => true, 'error' => '')));
        }
    }

    public function shutoff() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ContatoModel();
            $Contato = $tmodel->delete($json->id);
            return json_encode(array('data' => array('success' => ($Contato->connID->affected_rows > 0 ) ? TRUE : FALSE, 'id' => $json->id, 'error' => '---')));
        }
    }

    public function getList() {
        $contatoModel = new ContatoModel();
        $json   = json_decode($this->request->getVar('data'));         
        return json_encode(array('data' => $contatoModel->findWhere('clientes_id', $json->id ), 'recordsFiltered' => 0));
    }

}
