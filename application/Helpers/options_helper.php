<?php

/**
 * Helper de Options
 * @author Jones <jones.pereira@gmail.com>   
 */

/**
 * @param ID $idPriority -> Key do array de Prioridade 
 * @return Array com as Prioridades da Tarefa
 *         String do is recebido como parâmetro
 */
function getTaksPriority($idPriority = NULL) {
    $priorityLIst = array('1' => 'Nehuma', '2' => 'Alta', '3' => 'Média', '4' => 'Baixa');
    return (empty($idPriority)) ? $priorityLIst : $priorityLIst[$idPriority];
}
