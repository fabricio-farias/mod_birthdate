<?php

/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_archive
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

class modBirthdateHelper {
    
    static function open(&$params) {
        
        $host       = $params->get('mod_birthdate_host');
        $port       = $params->get('mod_birthdate_port');
        $dbname     = $params->get('mod_birthdate_dbname');
        $user       = $params->get('mod_birthdate_user');
        $password   = $params->get('mod_birthdate_password');
        
        $con = @pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        if(!$con){
            print pg_last_error($con);
        }
        
        return $con;
    }


    static function close() {
        @pg_close($con);
    }

    static function getBirthdate(&$params) {
        $con = self::open($params);
        $rows = array();
        if($con){
            $query = "select f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial"
            . " from eventosrh.t_funcionario f"
            . " inner join eventosrh.t_funcao fu on f.isn_funcao = fu.isn_funcao"
            . " inner join eventosrh.t_setor s on f.isn_setor = s.isn_setor"
            . " inner join eventosrh.t_filial fi on f.isn_filial = fi.isn_filial"
            . " where dat_nascimento is not null"
            . " and cod_situacao <> 'D'"
            . " and date_part('DAY', f.dat_nascimento) = date_part('DAY', now())"
            . " and date_part('MONTH', f.dat_nascimento) = date_part('MONTH', now())"
            . " group by f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial"
            . " order by f.dsc_nome"
            ;
            
            $result = pg_query($con, $query);

            if (!$result) {
                echo pg_last_error();
            } 

            while($row = pg_fetch_object($result)){
                $rows[] = $row;
            }
        }
        
        return $rows;
    }
}
