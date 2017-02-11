<?php

namespace Task;

use CodeIgniter\Model;

/**
 * @author Jones Pereira <jonespereiratk@gmail.com>
 */

/**
 * Description of TaskModel
 *
 * Classe responsável pela administração da tabela task 
 * consultas e demais operações que se relacionem com base em task
 * 
 * 
 * @author Jones
 */
class TaskModel extends Model {

    protected $table = 'task';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
//    protected $useTimestamps = TRUE;
    protected $allowedFields = array(
        'id',
        'title',
        'description',
        'created_at',
        'updated_at',
        'first_datetime',
        'last_datetime',
        'elapsed_datetime',
        'deleted',
        'task_priority_id'
    );

    /**
     * 
     * @param array $columns => Recebe as colunas para fazer o select em new_pessoa
     * @return list => retorna uma lista de array de new_pessoa
     */
    public function getList($columns = NULL, $max = NULL) {
        $limit = empty($max) ? 100 : $max;
        $selectColumns = ( empty($columns) ) ? '*' : implode(' , ', $columns);
        return $this->db->query('SELECT ' . $selectColumns . ' FROM ' . $this->table . ' limit ' . ($limit + 1) . ';')->getResultArray();
    }

    /**
     * Método que retorna a lista completa de grupos
     * @return list grupos
     */
    public function getListPaginateST($start = NULL, $limit = NULL, $searchColumns = null, $search = array(), $sortField = NULL, $sortOrder = NULL) {

        $max = empty($limit) ? 10 : $limit;
        $strt = empty($start) ? 0 : $start;

//        $searchColumns = array('id', 'title', 'description', 'created_at', 'updated_at', 'first_datetime', 'last_datetime', 'elapsed_datetime', 'deleted', 'task_priority_id');

        $where = '';

        $columnsNames = array_keys($search);

        foreach ($search as $searchStr) {
            foreach ($columnsNames as $columns) {
                $searchStr = $this->isDate($searchStr);
                $where .= $columns . ' like "%' . $searchStr . '%" ';
                (!next($columnsNames)) ?: $where .= ' or ';
            }
            (!next($search)) ?: $where .= ' and ';
        }

        $sql = '   SELECT ' . ((count($columnsNames) > 0 ) ? implode(' , ', $columnsNames) : '*');
        $sql .= ' FROM  ' . $this->table;
        $sql .= empty($where) ? '' : ' WHERE ' . $where;
        $sql .= empty($sortField) ? '' : ' ORDER BY ' . $sortField . ' ' . $sortOrder;
        $sql .= ' LIMIT ' . $strt . ',' . $max;

        $return = new \stdClass();
        $return->recordsTotal = $this->db->query('SELECT count(*) as total FROM ' . $this->table)->getResultArray()[0]['total'];
        $return->recordsFiltered = $this->db->query('SELECT count(*) as filtered FROM ' . $this->table . ( empty($where) ? ' ' : ' WHERE ' . $where ))->getResultArray()[0]['filtered'];
        $return->list = $this->db->query($sql)->getResultArray();

        log_msg($sql, ' sql:::');

        return $return;
    }

    public function isDate($searchStr) {
        if (strpos($searchStr, '/')) {
            $aux = str_replace('/', '-', $searchStr);
            $r = explode('-', $aux);
            $c = count($r);
            switch ($c) {
                case 2:
                    return $searchStr = $r[1] . '-' . $r[0];
                case 3:
                    return $searchStr = $r[2] . '-' . $r[1] . '-' . $r[0];
            }
        }
        return $searchStr;
    }

}
