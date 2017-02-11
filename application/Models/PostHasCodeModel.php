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
 * Classe responsável pela administração da tabela post_has_code
 * consultas e demais operações que se relacionem com base em post_has_code
 * 
 * 
 * @author Jones Pereira 25/01/2017
 */
class PostHasCodeModel extends KiModel {

    protected $table         = 'post_has_code';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = array(
        'post_id',
        'code_id',
    );

}
