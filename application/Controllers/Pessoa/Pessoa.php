<?php

namespace App\Controllers\Pessoa;

use App\Controllers\KiController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\Logger;
use Pessoa\PessoaModel;
use function getPaginationList;
use function log_msg;
use function paginator;

class Pessoa extends KiController {

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        header('Access-Control-Allow-Origin:*');
        parent::__construct($request, $response, $logger);
    }

    public function index() {
        echo 'ok';
    }

    public function getList() {

        $pessoaModel  = new PessoaModel;
        $searchFields = $this->getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');
        $return       = $pessoaModel->getListPaginateST($start, $limit, NULL, $searchFields, $sort, $order);
        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

    public function getList2() {
        return json_encode(
                array('data' => getPaginationList(
                            $this->request->getVar('data') // Fields de busca 
                            , array('LAST_NAME', 'FIRST_NAME', 'EMAIL') // colunas de busca e tabela
                            , 'Pessoa\PessoaModel' // Modelo que contém o método getListPaginate e seus parâmetros
                    )
                )
        );
    }

    /**
     * 
     * @param type $fields
     * @return array de Campos de busca para paginação
     */
    public function getFildsSearch($fields): array {
        $fieldsList = array_keys($fields);
        $params     = array();
        foreach ($fieldsList as $key) {
            if (!($key[0] === '_')) {
                $params[] = $fields[$key];
            }
        }
        return $params;
    }

    public function login() {
        session_start();
        log_msg(session_id(), ':::::::::::::::session_id()::::::::');
        return json_encode(array('data' => array('token' => session_id() )));
    }

}

//            if ($key[0] === '_') {
//                $params[] = substr($key, 1);
//                unset($keys[$key]);
//            } else {
//                $clearKeys[] = str_replace('_like', '', $key);
//            }