<?php

/**
 * Controlador de métodos de acessa a dados do Produto
 *
 * @author Jones Pereira 15/12/2016
 */

namespace App\Controllers\Card;

use App\Controllers\KiController;
use App\Models\CardModel;
use App\Models\CodeModel;
use App\Models\PostHasCodeModel;
use App\Models\PostModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Log\Logger;
use Exception;
use function log_msg;

class Card extends KiController {

    public function index() {

        echo 'ok';
    }

    public function __construct(RequestInterface $request, ResponseInterface $response, Logger $logger = null) {
        parent::__construct($request, $response, $logger);
//        ob_start();
//        var_export(,$v , TRUE);
    }

    public function img() {
        $location = \WRITEPATH . 'img/';
        $path = 'http://localhost/kodeinside.com/index/writable/img/';
        if (isset($_FILES['file'])) {
            $name     = randomString() . '.' . explode('/', $_FILES['file']['type'])[1]; // cria um nome randomico para o arquivo e o explode pega a extenção e concatena tudo....
            log_msg(var_export($_FILES['file'], true));
            $tmp_name = $_FILES['file']['tmp_name'];
            $error    = $_FILES['file']['error'];
            if ($error !== UPLOAD_ERR_OK) {
                return json_encode(array('data' => array('fail' => 'fail')));
            } elseif (move_uploaded_file($tmp_name, $location . $name)) {
                return json_encode(array('data' => array('name' => $path . $name)));
            }
        }
    }

    public function getList() {
        $cardModel = new CardModel();
        return json_encode(array('data' => $cardModel->findAll()));
    }

    public function save() {
//        if (!empty($this->request->getVar('data'))) {
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

            $postId = $postModel->save(array('id' => $json->idPost, 'title' => $json->titlePost, 'description' => $json->description, 'card_id' => $idCard));

            $codeId = $codeModel->save(array('code' => $json->idCode, 'description' => $json->descriptionCode, 'code' => $json->code));

            $postCodeId = $postHasCodeModel->save(array('code_id' => $codeId, 'post_id' => $postId));

            log_msg($idCard, 'Card:::');
            log_msg($postId, 'Post:::');
            log_msg($codeId, 'Code:::');
            log_msg($postCodeId, 'POSTCODE:::');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            log_msg($ex->getMessage(), ':::');
        }

        $success = ((!empty($idCard)) && ($idCard != false) ) ? TRUE : false;
        return json_encode(array('data' => array('id' => ($idCard === TRUE ) ? $json->id : $idCard, 'success' => $success, 'error' => $error . 'Card: ' . $idCard . ' Post: ' . $postId . ' Code: ' . $codeId . ' PostCode: ' . $postCodeId)));
    }

//    }
//    public function __destruct() {
//        $result = ob_get_clean();
//        $path   = \WRITEPATH . 'logs/help.html';
//        file_put_contents($path, $result);
//    }
}
