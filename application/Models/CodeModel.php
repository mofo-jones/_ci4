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
class CodeModel extends KiModel {

    protected $table         = 'code';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = array(
        'code',
        'description'
    );

}
