<?php namespace App\Models\Site;

use App\Models\KiModel;
use stdClass;
use function createLimit;
use function createSql;
use function createWhere;
use function log_msg;

/**
 * @author Jones Pereira <jonespereiratk@gmail.com>
 */

/**
 * Description of ArtigoModel
 *
 * Classe responsável pela administração da tabela site_artivos
 * consultas e demais operações que se relacionem com base em site_artigos
 * 
 * 
 * @author Jones Pereira 25/01/2017
 */
class CapaModel extends KiModel {

    protected $table         = 'site_capas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = array(
        'titulo',
        'subtitulo',
        'descricao',
        'link',
        'link_titulo',
        'imagem'
    );

    /**
     * Método que retorna a paginação de site_artigos
     * @return list cards
     */
    public function getListPaginateST($start = NULL, $limit = NULL, $search = array(), $sortField = NULL, $sortOrder = NULL) {
        $limt         = createLimit($start, $limit);
        $columnsNames = array_keys($search);
        $where        = createWhere($search, $columnsNames);
        $sql          = createSql($columnsNames, $this->table, $where, $sortField, $sortOrder, $limt);
        $return       = $this->records($sql, $where);
        log_msg($sql, ' sql:::', TRUE);
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
