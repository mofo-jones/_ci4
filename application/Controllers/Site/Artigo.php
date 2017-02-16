<?php

namespace App\Controllers\Site;

use App\Controllers\KiController;
use App\Models\Site\ArtigoModel;
use App\Models\Site\CapaModel;
use App\Models\Site\CardModel;
use App\Models\Site\CategoriaModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\Logger;
use Exception;
use function getFildsSearch;
use function log_msg;
use function paginator;

/**
 * Controlador de métodos de acessa a dados do Artigo
 *
 * @author Jones Pereira 15/12/2016
 */
class Artigo extends KiController {

    public function index() {
        echo 'ok';
    }

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        parent::__construct($request, $response, $logger);
        //        ob_start();
    }

    public function get() {
        $json        = json_decode($this->request->getVar('data')); //decodifica o json User do post data
        $capaModel   = new CapaModel();
        $artigoModel = new ArtigoModel();

        $artigo = $artigoModel->find($json->id);
        $capa   = $capaModel->find($artigo['site_capa_id']);
        return json_encode(array('data' => array('artigo' => $artigo, 'capa' => $capa, 'success' => true, 'error' => '---')));
    }

    public function save() {
        $error = ''; // retorna o erro da tentativa de inserir o cliente
        $json  = json_decode($this->request->getVar('data')); //decodifica o json Cliente do post data

        $capaModel   = new CapaModel();
        $artigoModel = new ArtigoModel();

        try {

            $idCapa = $capaModel->save(array(
                'id'          => $json->capa->id,
                'titulo'      => $json->capa->titulo,
                'subtitulo'   => $json->capa->subtitulo,
                'descricao'   => $json->capa->descricao,
                'link'        => $json->capa->link,
                'link_titulo' => $json->capa->link_titulo,
                'imagem'      => $json->capa->imagem
            ));

            // Se artigo não tem ID, não tem capa, então artigo recebe o id da capa, do contrário é update
            $site_capa_id = ($json->artigo->id !== '') ? $json->artigo->site_capa_id : $idCapa;

            log_msg(var_export($json->artigo->id,true), ':::', TRUE);
            
            
            $idArtigo = $artigoModel->save(array(
                'id'           => $json->artigo->id,
                'site_capa_id' => $site_capa_id,
                'titulo'       => $json->artigo->titulo,
                'subtitulo'    => $json->artigo->subtitulo,
                'resumo'       => $json->artigo->resumo,
                'descricao'    => $json->artigo->descricao,
                'categoria'    => $json->artigo->categoria
            ));

            if ($idArtigo == false) {
                $capaModel->delete($idCapa);
            }
            
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            log_msg($ex->getMessage(), ':::');
        }
        return json_encode(array(
            'data' => array(
                'capa'   => array('id' => $idCapa),
                'artigo' => array('id' => $idArtigo)
            ))
        );
    }

    public function getList() {
        $cardModel = new CardModel();
        return json_encode(array('data' => $cardModel->findAll()));
    }

    public function getCustomList() {
        $artigoModel  = new ArtigoModel();
        $searchFields = getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');

        $return = $artigoModel->getCustomList($start, $limit, $searchFields, $sort, $order);


        $categoriaModel = new CategoriaModel(); // Fake Model

        foreach ($return as $key => $value) {
            $return[$key]['categoria'] = $categoriaModel->find($value['categoria'])['nome'];
        }

        return json_encode(array('data' => $return, 'recordsFiltered' => 20));
    }

    public function getPaginationList() {
        $cardModel    = new CardModel();
        $searchFields = getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');
        $return       = $cardModel->getListPaginateST($start, $limit, $searchFields, $sort, $order);
        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

//    public function __destruct() {
//        $result = ob_get_clean();
//        $path   = \WRITEPATH . 'logs/help.html';
//        file_put_contents($path, $result);
//    }
}
