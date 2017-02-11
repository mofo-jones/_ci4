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
 * Classe responsável pela administração da tabela post
 * consultas e demais operações que se relacionem com base em post
 * 
 * 
 * @author Jones Pereira 25/01/2017
 */
class PostModel extends KiModel {

    protected $table         = 'post';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = array(
        'title',
        'description',
        'card_id'
    );

}
