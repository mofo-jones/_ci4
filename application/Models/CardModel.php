<?php

namespace App\Models;

use CodeIgniter\Model;
use stdClass;
use function log_msg;

/**
 * @author Jones Pereira <jonespereiratk@gmail.com>
 */

/**
 * Description of TaskModel
 *
 * Classe responsável pela administração da tabela card
 * consultas e demais operações que se relacionem com base em Card
 * 
 * 
 * @author Jones Pereira 25/01/2017
 */
class CardModel extends KiModel {

    protected $table         = 'card';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = array(
        'title',
        'subtitle',
        'text',
        'minitext',
        'link',
        'linktitle',
        'info',
        'images',
    );

    /**
     * Método que retorna a paginada de card
     * @return list cards
     */
    public function getListPaginateST($start = NULL, $limit = NULL, $search = array(), $sortField = NULL, $sortOrder = NULL) {
        $limt         = createLimit($start, $limit);
        $columnsNames = array_keys($search);
        $where        = createWhere($search, $columnsNames);
        $sql          = createSql($columnsNames, $this->table, $where, $sortField, $sortOrder, $limt);
        $return       = $this->records($sql, $where);
        log_msg($sql, ' sql:::');
        return $return;
    }

    public function records($sql, $where): stdClass {
        $return                  = new stdClass();
        $return->recordsTotal    = $this->db->query('SELECT count(*) as total FROM ' . $this->table)->getResultArray()[0]['total'];
        $return->recordsFiltered = $this->db->query('SELECT count(*) as filtered FROM ' . $this->table . ( empty($where) ? ' ' : ' WHERE ' . $where ))->getResultArray()[0]['filtered'];
        $return->list            = $this->db->query($sql)->getResultArray();
        return $return;
    }

}
