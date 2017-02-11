<?php

/* */

/**
 * Controlador de métodos de acessa a dados do cliente
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Parcela;

use App\Controllers\KiController;
use App\Models\ClienteModel;
use Exception;
use function getFildsSearch;
use function paginator;

class Parcela extends KiController {

    public function index() {
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '99999999999999999999999999999999999999999999999';
    }

    public function save() {
//        if (!empty($this->request->getVar('data'))) {


        $error  = ''; // retorna o erro da tentativa de inserir o cliente
//        $json   = json_decode($this->request->getVar('data')); //decodifica o json Cliente do post data
        $json   = json_decode('{"id":"","nome":"1","nomeMae":"1","nomePai":"1","pais":"1","cidade":1,"dtNascimento":"2016-12-21T03:49:35.469Z","foneResidencial":"1","foneTrabalho":"1","foneCelular":"1","genero":"1","salario":"1","cep":"1","numeroCasa":"1","endereco":"1","email":"gyc@tycuy.com","estado":"1"}'); //decodifica o json Cliente do post data
        $tmodel = new ClienteModel();
        try {
            $id = $tmodel->save(array(
                'id'               => $json->id,
                'nome'             => $json->nome,
                'nome_mae'         => $json->nomeMae,
                'nome_pai'         => $json->nomePai,
                'pais'             => $json->pais,
                'cidade'           => $json->cidade,
                'dt_nascimento'    => getMomentFullDay($json->dtNascimento),
                'fone_residencial' => $json->foneResidencial,
                'fone_trabalho'    => $json->foneTrabalho,
                'fone_celular'     => $json->foneCelular,
                'genero'           => $json->genero,
                'salario'          => $json->salario,
                'cep'              => $json->cep,
                'numero_casa'      => $json->numeroCasa,
                'endereco'         => $json->endereco,
                'email'            => $json->email,
                'estado'           => $json->estado,
            ));
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }

        $success = ((!empty($id)) && ($id != false) ) ? TRUE : false;
        return json_encode(array('data' => array('id' => ($id === TRUE ) ? $json->id : $id, 'success' => $success, 'error' => $error)));
//        }
//        return '>>>>>>>>>>>>>>>>>>>';
    }

    public function get() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ClienteModel();
            $cliente = $tmodel->find($json->id);
            return json_encode(array('data' => array('cliente' => $cliente, 'success' => true, 'error' => '---')));
        }
    }

    public function shutoff() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ClienteModel();
            $Cliente = $tmodel->delete($json->id);
            return json_encode(array('data' => array('success' => ($Cliente->connID->affected_rows > 0 ) ? TRUE : FALSE, 'id' => $json->id, 'error' => '---')));
        }
    }

    public function getList() {
        $clienteModel = new ClienteModel();
        $searchFields = getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');
        $return       = $clienteModel->getListPaginateST($start, $limit, $searchFields, $sort, $order);

        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

}
