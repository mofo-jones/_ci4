<?php

/**
 * Controlador de métodos de acessa a dados do Produto
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Site;

use App\Controllers\KiController;
use App\Models\CodeModel;
use App\Models\PostHasCodeModel;
use App\Models\PostModel;
use App\Models\Site\CardModel;
use Exception;
use function getFildsSearch;
use function paginator;


class Card extends KiController {

    public function index() {
        return 'ok';
    }

    public function get() {
        $json          = json_decode($this->request->getVar('data')); //decodifica o json User do post data
        $conteudoModel = new CardModel();
        $conteudo      = $conteudoModel->find($json->id);
        return json_encode(array('data' => array('card' => $conteudo, 'success' => true, 'error' => '---')));
    }

    public function save() {

        $error = ''; // retorna o erro da tentativa de inserir o cliente
        $json  = json_decode($this->request->getVar('data')); //decodifica o json Cliente do post data

        $model            = new CardModel();
        $postModel        = new PostModel();
        $codeModel        = new CodeModel();
        $postHasCodeModel = new PostHasCodeModel();

        try {
            $idCard = $model->save(array(
                'id'        => $json->id,
                'title'     => $json->title,
                'subtitle'  => $json->subtitle,
                'text'      => $json->text,
                'minitext'  => $json->minitext,
                'link'      => $json->link,
                'linktitle' => $json->linktitle,
                'info'      => $json->info,
                'images'    => $json->images,
            ));

            $postId     = $postModel->save(array('id' => $json->idPost, 'title' => $json->titlePost, 'description' => $json->description, 'card_id' => $idCard));
            $codeId     = $codeModel->save(array('code' => $json->idCode, 'description' => $json->descriptionCode, 'code' => $json->code));
            $postCodeId = $postHasCodeModel->save(array('code_id' => $codeId, 'post_id' => $postId));
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }

        $success = ((!empty($idCard)) && ($idCard != false) ) ? TRUE : false;
        return json_encode(array('data' => array('id' => ($idCard === TRUE ) ? $json->id : $idCard, 'success' => $success, 'error' => $error . 'Card: ' . $idCard . ' Post: ' . $postId . ' Code: ' . $codeId . ' PostCode: ' . $postCodeId)));
    }

    public function getList() {
        $conteudoModel = new ConteudoModel();
        return json_encode(array('data' => $conteudoModel->findAll()));
    }

    public function getPaginationList() {
        $conteudoModel = new ConteudoModel();
        $searchFields  = getFildsSearch($this->request->getPostGet());
        $sort          = $this->request->getVar('_sort');
        $order         = $this->request->getVar('_order');
        $start         = paginator($this->request->getVar('_page'));
        $limit         = $this->request->getVar('_limit');
        $return        = $conteudoModel->getListPaginateST($start, $limit, $searchFields, $sort, $order);
        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

}
