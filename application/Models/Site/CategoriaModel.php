<?php

namespace App\Models\Site;

class CategoriaModel {

    private $list = [
        ['id' => '1', 'nome' => 'Angular 2'],
        ['id' => '2', 'nome' => 'Codeigniter 4'],
        ['id' => '3', 'nome' => 'PHP 7'],
        ['id' => '4', 'nome' => 'PRIME-NG'],
        ['id' => '5', 'nome' => 'Ng2-Admin'],
        ['id' => '6', 'nome' => 'MariaDB'],
        ['id' => '7', 'nome' => 'HTML5']
    ];

    public function findAll(int $limit = 0, int $offset = 0) {
        return $this->list;
    }

    public function find($id) {
        return $this->list[$id - 1]; // macete by mofo-jones kkkkk
    }

}
