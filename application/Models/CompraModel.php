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
 * Classe responsável pela administração da tabela task 
 * consultas e demais operações que se relacionem com base em task
 * 
 * 
 * @author Jones Pereira 15/12/2016
 */
class CompraModel extends KiModel {

    protected $table         = 'compras';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
//    protected $useTimestamps = TRUE;
    protected $allowedFields = array(
        'id',
        'dt_compra',
        'vlr_compra',
        'qtd_total',
        'clientes_id',
        'qtd_produtos',
    );

    
    /**
     * Método que retorna a lista completa de grupos
     * @return list grupos
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
