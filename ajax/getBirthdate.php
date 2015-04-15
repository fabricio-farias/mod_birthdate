<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$path = '../../../includes.php';

if(file_exists($path)){
    include('../../../includes.php');
}else{
    echo 'Definições de inclusão não encontradas';
    die();
}

if(file_exists(dirname(__DIR__).'/helper.php')){
    require_once dirname(__DIR__).'/helper.php';
}else{
    echo 'Classe não localizada';
    die();
}

$post = JRequest::get('post');

try{
    $dbparams = modBirthdateHelper::getParams($post['id']);

    $registry = new JRegistry();
    $registry->loadString($dbparams);
    $objparams = $registry->toObject();

    $params = new JRegistry();
    $params->loadObject($objparams);
    $con = modBirthdateHelper::open($params);
    
    if($post['type'] == 'date'){
        if($post['data']){
            $rows = modBirthdateHelper::getBirthdateById($con, $post['data']);
        }else{
            $rows = modBirthdateHelper::getBirthdateByDate($con, $post['date']);  
        }

        $arr_units = array(
            'ISGH' => '<span class="flag flag-info">ISGH</span>',
            'HGWA' => '<span class="flag flag-success">HGWA</span>',
            'HRC' => '<span class="flag flag-success">HRC</span>',
            'HRN' => '<span class="flag flag-success">HRN</span>',
            'UPA' => '<span class="flag flag-danger">UPA</span>',
            'APS' => '<span class="flag flag-warning">APS</span>',
            'SMS' => '<span class="flag flag-warning">SMS</span>'
        );

        $html = '';
        foreach ($rows as $row){
            foreach($arr_units as $k => $v){
                if(strpos(strtoupper($row->dsc_filial), (string)$k)> -1){
                    $dsc_filial = str_replace($k, $row->dsc_filial, $v);
                }
            }

            $html .= '<tr>';
            $html .= '<td>'.$row->dsc_nome.'</td>';
            $html .= '<td>'.$row->dsc_funcao.'</td>';
            $html .= '<td>'.$row->dsc_setor.'</td>';
            $html .= '<td align="center">'.$row->dat_nasc.'</td>';
            $html .= '<td>'.$dsc_filial.'</td>';
            $html .= '</tr>';
        }

        echo $html;
    }else{
    
        $value = strtoupper($post['value']);
        $rows = modBirthdateHelper::getBirthdateByName($con, $value);
        $html = array();
        
        if($rows){
            foreach ($rows as $k => $v){
                $dsc_nome = str_replace($value, "<strong>".$value."</strong>", $v->dsc_nome);
                $html [] = '<div class="autocomplete-suggestion" data-index="'.$k.'" data="'.$v->isn_funcionario.'" onclick="findBirthdayByName(this)">'.$dsc_nome.'<span>'.$v->dat_nasc.'</span></div>';
            }
        }else{
            $html [] = '<div class="autocomplete-no-suggestion">Não há resultados para sua pesquisa</div>';
        }
        
        echo implode("\n", $html);
    }
    
}  catch (ErrorException $e){
    echo $e->getMessage();
}