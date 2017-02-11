<?php

/**
 * Controlador de métodos de acessa a dados do cliente
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Cliente;

use App\Controllers\KiController;
use App\Models\ClienteModel;
use Exception;
use function getFildsSearch;
use function paginator;

class Cliente extends KiController {

    public function index() {
        echo 'ok';
    }

    public function save() {
//        if (!empty($this->request->getVar('data'))) {

        $error  = ''; // retorna o erro da tentativa de inserir o cliente
        $json   = json_decode($this->request->getVar('data')); //decodifica o json Cliente do post data
//        $json   = json_decode(' {"id":"2","nome":"jones pereira","mae":"delma","pai":"antônio","genero":"1","cpf":"000.000.000-00","rg":"0000000000","dtNascimento":"1984-12-13T03:00:00.000Z","fonePessoal":"5198889243","foneResidencial":"5135631150","foneTrabalho":"5136531367","estadoCivil":"1","profissao":"Programador","email":"jones@kodeinside.com","salario":"1500.00","cidade":"1","pais":"1","naturalidade":"Taquariense","estado":"1","cep":"95860-000","numeroCasa":"147","endereco":"rua 20 de setembro","proximidade":"Boto autopeças","bairro":"Santo Antônio","complemento":"...","dtUltimaCompra":"0000000"}'); //decodifica o json Cliente do post data
        $tmodel = new ClienteModel();
        try {
            $id = $tmodel->save(array(
                'id'               => $json->id,
                'nome'             => $json->nome,
                'mae'              => $json->mae,
                'pai'              => $json->pai,
                'genero'           => $json->genero,
                'cpf'              => preg_replace('~\D~', '', $json->cpf),
                'rg'               => $json->rg,
                'dt_nascimento'    => dateFrontToBack($json->dtNascimento),
                'fone_pessoal'     => $json->fonePessoal,
                'fone_residencial' => $json->foneResidencial,
                'fone_trabalho'    => $json->foneTrabalho,
                'estado_civil'     => $json->estadoCivil,
                'profissao'        => $json->profissao,
                'email'            => $json->email,
                'salario'          => $json->salario,
                'conjuge'          => (!empty($json->conjuge)) ? $json->conjuge : '',
                'cidade'           => $json->cidade,
                'pais'             => $json->pais,
                'naturalidade'     => $json->naturalidade,
                'estado'           => $json->estado,
                'cep'              => preg_replace('~\D~', '', $json->cep),
                'numero_casa'      => $json->numeroCasa,
                'endereco'         => $json->endereco,
                'proximidade'      => $json->proximidade,
                'bairro'           => $json->bairro,
                'complemento'      => $json->complemento,
                'dt_ultima_compra' => $json->dtUltimaCompra,
            ));
            log_msg(dateFrontToBack($json->dtNascimento), '>>>>>>>>>>>>>>');
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
