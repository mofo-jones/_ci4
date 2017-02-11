<?php

/* */

/**
 * Controlador de métodos de acessa a dados do Produto
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Produto;

use App\Controllers\KiController;
use App\Models\ProdutoModel;
use Exception;
use function getFildsSearch;
use function paginator;

class Produto extends KiController {

    public function index() {
        echo 'ok';
    }

    public function save() {
//        if (!empty($this->request->getVar('data'))) {

        $error  = ''; // retorna o erro da tentativa de inserir o Produto
        $json   = json_decode($this->request->getVar('data')); //decodifica o json Produto do post data
//        $json   = json_decode('{"id":"","codigo":"7777777777777","descricao":"7777777777777","valorCompra":77.77,"valorVenda":777.77,"valorLucro":700,"valorPromocional":7.77,"percentualLucro":900.0900090009001,"estoque":77,"estoqueMim":7,"estoqueMax":777,"ativo":"1","observacoes":"7777777777777777777777","marcasId":"1","fornecedoresId":"1","coresId":"1","juros":7.77,"categoriasId":"1","tamanhosId":"2"}'); //decodifica o json Produto do post data
        $tmodel = new ProdutoModel();
        try {
            $id = $tmodel->save(array(
                'id'                => $json->id,
                'codigo'            => $json->codigo,
                'descricao'         => $json->descricao,
                'marcas_id'         => $json->marcasId,
                'fornecedores_id'   => $json->fornecedoresId,
                'valor_compra'      => str_replace(',', '', $json->valorCompra),
                'valor_venda'       => str_replace(',', '', $json->valorVenda),
                'valor_lucro'       => str_replace(',', '', $json->valorLucro),
                'valor_promocional' => str_replace(',', '', $json->valorPromocional),
                'percentual_lucro'  => str_replace(',', '', $json->percentualLucro),
                'estoque'           => $json->estoque,
                'ativo'             => $json->ativo,
                'observacoes'       => $json->observacoes,
                'categorias_id'     => $json->categoriasId,
                'estoque_mim'       => $json->estoqueMim,
                'estoque_max'       => $json->estoqueMax,
                'cores_id'          => $json->coresId,
                'juros'             => $json->juros,
                'tamanhos_id'       => $json->tamanhosId,
            ));

        } catch (Exception $ex) {
            $error = $ex->getMessage();

            log_msg($ex->getMessage(), ':::: ::::::::::::::::::::::::\n');
        }

        $success = ((!empty($id)) && ($id != false) ) ? TRUE : false;
        return json_encode(array('data' => array('id' => ($id === TRUE ) ? $json->id : $id, 'success' => $success, 'error' => $error)));
//        }
//        return '>>>>>>>>>>>>>>>>>>>';
    }

    public function get() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ProdutoModel();
            $produto = $tmodel->find($json->id);
            return json_encode(array('data' => array('produto' => $produto, 'success' => true, 'error' => '---')));
        }
    }

    public function shutoff() {
        if (!empty($this->request->getVar('data'))) {
            $json    = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel  = new ProdutoModel();
            $produto = $tmodel->delete($json->id);
            return json_encode(array('data' => array('success' => ($produto->connID->affected_rows > 0 ) ? TRUE : FALSE, 'id' => $json->id, 'error' => '---')));
        }
    }

    public function getList() {
        $produtoModel = new ProdutoModel();
        $searchFields = getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');
        $return       = $produtoModel->getListPaginateST($start, $limit, $searchFields, $sort, $order);

        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

}
