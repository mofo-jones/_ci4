<?php namespace App\Models;

class CategoriaModel extends Model {

    protected $table         = 'categorias';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
//    protected $useTimestamps = TRUE;
    protected $allowedFields = array(
        'id',
        'nome',
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