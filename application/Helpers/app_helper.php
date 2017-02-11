<?php

/**
 * 
 * Helper do App
 * @author Jones <jones.pereira@gmail.com>
 *   
 */
function log_msg($text, $symbol = '', $file = NULL) {
    if (is_array($text)) {
        $path = (is_null($file) ? \WRITEPATH . 'logs/logSysControllers.php' : \WRITEPATH . $file );

        file_put_contents($path, PHP_EOL . $symbol . keyParam($text), FILE_APPEND);
    }
    $path = (is_null($file) ? \WRITEPATH . 'logs/logSysControllers.php' : \WRITEPATH . $file );
    file_put_contents($path, PHP_EOL . $symbol . $text, FILE_APPEND);
}

function getPaginationList($data, $fildsSearch, $nameSpaceClass, $method = NULL) {

    $pessoaModel = new $nameSpaceClass;
    $methodExec  = empty($method) ? 'getListPaginate' : $method;

    // Decodifica json e envia os parâmetros para a busca
    if ($data === 'undefined') {
        $return = $pessoaModel->$methodExec();
    } else {

        $pgJson = json_decode($data); //decodifica o json pagination do post data

        $sortField = empty($pgJson->sortField) ? NULL : $sortField = $pgJson->sortField;
        $sortOrder = empty($pgJson->sortField) ? NULL : $sortOrder = $pgJson->sortField;

        $search = array();
        foreach ($fildsSearch as $field) {
            empty($pgJson->filters->$field->value) ?: $search[] = $pgJson->filters->$field->value;
        }

        if (!empty($pgJson->filters->LAST_NAME->value)) {
            $return = $pessoaModel->$methodExec($pgJson->first, $pgJson->rows, NULL, NULL, $search, $sortField, $sortOrder);
        } else {
            $return = $pessoaModel->$methodExec($pgJson->first, $pgJson->rows, NULL, NULL, array(), $sortField, $sortOrder);
        }
    }

    // Log do systema
    \log_msg($data, ' Get List - data : ');
    \log_msg(count($return->list), ' Nº de registros retornados : ');
    \log_msg($return->recordsTotal, ' Nº de registros na Tabela : ');
    \log_msg($return->recordsFiltered, ' Nº de registros filtrados : ');

    return $return;
}

/**
 * @param number $page -> Parâmetro _page enviado do ng2-smart-table
 * @return Retorna o valor para o Start do método de paginaçã
 */
function paginator($page) {
    return ($page - 1) * 10;
}

function keyParam($param) {
    $text = '';
    if (is_array($param)) {
        foreach ($param as $key => $value) {
            $text .= PHP_EOL . ' --> ' . $key . ' <-> ' . $value;
        }
    }
    $text .= PHP_EOL;
    return $text;
}

/**
 * @param type $fields
 * @return array de Campos de busca para paginação
 */
function getFildsSearch($fields): array {
    $fieldsList = array_keys($fields);
    $params     = array();
    foreach ($fieldsList as $key) {
        if (!($key[0] === '_')) {
            $params[str_replace('_like', '', $key)] = $fields[$key];
        }
    }
    return $params;
}

function momentToDateSql($momentDate, $momentTime) {
    return getMomentFullDay($momentDate) . ' ' . getMomentTime($momentTime);
}

function getMomentFullDay($moment) {
    return '"' . explode('T', $moment)[0] . '"';
}

function getMomentTime($moment) {
    $fullDate = explode('T', $moment);
    return explode('-', $fullDate[1])[0] . '.0';
}

/**
 *  Converte a data com / para - 
 * @param type $searchStr 
 * @return string
 */
function isDate($searchStr) {
    if (strpos($searchStr, '/')) {
        $aux = str_replace('/', '-', $searchStr);
        $r   = explode('-', $aux);
        $c   = count($r);
        switch ($c) {
            case 2:
                return $searchStr = $r[1] . '-' . $r[0];
            case 3:
                return $searchStr = $r[2] . '-' . $r[1] . '-' . $r[0];
        }
    }
    return $searchStr;
}

function dateFrontToBack($dateBr) {
    if (!empty($dateBr)) {
        $date = explode('/', $dateBr);
        return $date[2] . '-' . $date[1] . '-' . $date[0];
    }
    return "1900-01-01";
}

/**
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * helper de banco de dados 
 * @param type $columnsNames
 * @param type $table
 * @param type $where
 * @param type $sortField
 * @param type $sortOrder
 * @param type $strt
 * @param type $max
 * @return string
 */
function createSql($columnsNames, $table, $where, $sortField, $sortOrder, $limit) {
    $sql = '   SELECT ' . ((count($columnsNames) > 0 ) ? implode(' , ', $columnsNames) : '*');
    $sql .= ' FROM  ' . $table;
    $sql .= empty($where) ? '' : ' WHERE ' . $where;
    $sql .= empty($sortField) ? '' : ' ORDER BY ' . $sortField . ' ' . $sortOrder;
    $sql .= ' LIMIT ' . $limit;
    return $sql;
}

function createLimit($start, $limit): string {
    return (((!empty($start) ) && ($start < 0) ) ? 0 : $start) . ',' . ((empty($limit) ? 10 : $limit) );
}

function createWhere($search, $columnsNames): string {
    $where = '';
    foreach ($search as $searchStr) {
        foreach ($columnsNames as $columns) {
            $searchStr  = isDate($searchStr);
            $listSearch = explode(' ', $searchStr);
            foreach ($listSearch as $s) {
                $where .= $columns . ' like "%' . $s . '%" ';
                (!next($listSearch)) ?: $where .= ' or ';
            }
            (!next($columnsNames)) ?: $where .= ' or ';
        }
        (!next($search)) ?: $where .= ' and ';
    }
    return $where;
}

//function getMenu()
//{
//    helper('url');
//
//    $menu   = array();
//    $menu[] = array(
//        'menu'     => '1 - SubMenu',
//        'link'     => '#',
//        'hint'     => '0',
//        'level'    => 0,
//        'icon'     => 'fa fa-files-o fa-fw',
//        'children' => array(
//            array('menu'     => '2 - Sub Menu',
//                'link'     => '#',
//                'hint'     => '0',
//                'icon'     => 'fa fa-files-o fa-fw',
//                'level'    => 2,
//                'children' => array(
//                    array('menu'  => '3 - Sub Menu',
//                        'link'  => '#',
//                        'hint'  => '0',
//                        'level' => 3,
//                        'icon'  => 'fa fa-files-o fa-fw'
//                    )
//                )
//            )
//        )
//    );
//    return $menu;
//}
//
//function createMenu($menu_array)
//{
//    foreach ($menu_array as $menu) {
//        print '<li>';
//        print '<a href="' . $menu['link'] . '">'
//                . '<i class="fa fa-sitemap fa-fw"></i>'
//                . $menu['menu']
//                . '<span class="fa arrow"></span>'
//                . '</a>';
//        if (array_key_exists('children', $menu)) {
//            print '<ul class="nav ' . getLevel($menu['level']) . '">';
//            createMenu($menu['children']);
//            print '</ul>';
//        }
//        print '</li>';
//    }
//}
//
//function showMenu()
//{
//    print '<ul class="nav" id="side-menu">';
//    createMenu(getMenu());
//    print'</ul>';
//}
//
//function getLevel($level)
//{
//    switch ($level) {
//        case 1:return '';
//            break;
//        case 2: return 'nav-second-level';
//            break;
//        case 3: return 'nav-third-level';
//            break;
//        default: return '';
//            break;
//    }
//}


function to_monetary($dimdim) {
    $valor   = explode(' ', $dimdim)[1];
    $source  = array('.', ',');
    $replace = array('', '.');
    return str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
    //retorna o valor formatado para gravar no banco
}
