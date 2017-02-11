<?php

namespace App\Controllers\Task;

use CodeIgniter\Controller;
use Task\TaskModel;
use function paginator;

class Task extends \App\Controllers\KiController {

    public function index() {
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '99999999999999999999999999999999999999999999999';
    }

    public function __construct(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \CodeIgniter\Log\Logger $logger = null) {
        header('Access-Control-Allow-Origin:*');
        parent::__construct($request, $response, $logger);
    }

    public function save() {
        if (!empty($this->request->getVar('data'))) {

            $error  = ''; // retorna o erro da tentativa de inserir o Usuário
            $json   = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel = new TaskModel();

            try {
                $id      = $tmodel->save(array(
                    'id'               => $json->id,
                    'title'            => $json->title,
                    'task_priority_id' => ($json->rating === null) ? 1 : $json->rating,
                    'description'      => $json->description,
                    'first_datetime'   => $this->momentToDateSql($json->firstDate, $json->firstTime), // $this->dateToSql($json->firstDate,$json->firstTime)  $this->momentToSql($json->firstDate), //$json->firstDate . $json->firstTime,
                    'last_datetime'    => $this->momentToDateSql($json->lastDate, $json->lastTime), //$json->lastDate + $json->lastTime,
                    'elapsed_datetime' => $this->momentToDateSql($json->lastDate, $json->lastTime) //$json->elapsedTime
                ));
                $success = (empty($id)) ? false : true;
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
            return json_encode(array('data' => array('id' => $id, 'success' => $success, 'error' => $error)));
        }
        return;
    }

    public function getTask() {
        if (!empty($this->request->getVar('data'))) {
            $json   = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel = new TaskModel();
            $task   = $tmodel->find($json->id);
            return json_encode(array('data' => array('task' => $task, 'success' => true, 'error' => '---')));
        }
    }

    public function delete() {
        if (!empty($this->request->getVar('data'))) {
            $json   = json_decode($this->request->getVar('data')); //decodifica o json User do post data
            $tmodel = new TaskModel();
            $task   = $tmodel->delete($json->id);
            return json_encode(array('data' => array('success' => ($task->connID->affected_rows > 0 ) ? TRUE : FALSE, 'id' => $json->id, 'error' => '---')));
        }
    }

    public function getList() {
        $taskModel    = new TaskModel();
        $searchFields = $this->getFildsSearch($this->request->getPostGet());
        $sort         = $this->request->getVar('_sort');
        $order        = $this->request->getVar('_order');
        $start        = paginator($this->request->getVar('_page'));
        $limit        = $this->request->getVar('_limit');
        $return       = $taskModel->getListPaginateST($start, $limit, NULL, $searchFields, $sort, $order);
        return json_encode(array('data' => $return->list, 'recordsFiltered' => $return->recordsFiltered));
    }

    /**
     * @param type $fields
     * @return array de Campos de busca para paginação
     */
    public function getFildsSearch($fields): array {
        $fieldsList = array_keys($fields);
        $params     = array();
        foreach ($fieldsList as $key) {
            if (!($key[0] === '_')) {
                $params[str_replace('_like', '', $key)] = $fields[$key];
            }
        }
        return $params;
    }

    public function momentToDateSql($momentDate, $momentTime) {
        return $this->getMomentFullDay($momentDate) . ' ' . $this->getMomentTime($momentTime);
    }

    public function getMomentFullDay($moment) {
        return explode('T', $moment)[0];
    }

    public function getMomentTime($moment) {
        $fullDate = explode('T', $moment);
        return explode('-', $fullDate[1])[0] . '.0';
    }

}
