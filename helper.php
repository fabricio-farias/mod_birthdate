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
        
        //$con = @pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
        
        try {
            $con = new PDO("pgsql:host=$host;dbname=$dbname;port=$port;", $user, $password);
            @pg_set_client_encoding($con, "UNICODE");
            
            if(!$con){
                print pg_last_error($con);
            }
        
            return $con;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    static function close() {
        @pg_close($con);
    }

    static function getBirthdate(&$params) {
        try {
            $con = self::open($params);
            $rows = array();
            if($con){
                $query = "select f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, to_char(f.dat_nascimento, 'dd/mm') as dat_nasc"
                . " from eventosrh.t_funcionario f"
                . " inner join eventosrh.t_funcao fu on f.isn_funcao = fu.isn_funcao"
                . " inner join eventosrh.t_setor s on f.isn_setor = s.isn_setor"
                . " inner join eventosrh.t_filial fi on f.isn_filial = fi.isn_filial"
                . " where dat_nascimento is not null"
                . " and cod_situacao <> 'D'"
                . " and date_part('DAY', f.dat_nascimento) = date_part('DAY', now())"
                . " and date_part('MONTH', f.dat_nascimento) = date_part('MONTH', now())"
                . " group by f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, f.dat_nascimento"
                . " order by f.dsc_nome"
                ;

                $result = $con->query($query);

                if (!$result) {
                    echo pg_last_error();
                } 

                while($row = $result->fetchObject()){
                    $rows[] = $row;
                }

                return $rows;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    static function getBirthdateByDate($con, $date) {
        try {

            $rows = array();
            
            list($day, $month, $year) = explode("-", $date);
            $dbDate = trim($year) .'-'. trim($month) .'-'. trim($day);
            
            if($con){
                $query = "select f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, to_char(f.dat_nascimento, 'dd/mm') as dat_nasc"
                . " from eventosrh.t_funcionario f"
                . " inner join eventosrh.t_funcao fu on f.isn_funcao = fu.isn_funcao"
                . " inner join eventosrh.t_setor s on f.isn_setor = s.isn_setor"
                . " inner join eventosrh.t_filial fi on f.isn_filial = fi.isn_filial"
                . " where dat_nascimento is not null"
                . " and cod_situacao <> 'D'"
                . " and date_part('DAY', f.dat_nascimento) = date_part('DAY', date '$dbDate')"
                . " and date_part('MONTH', f.dat_nascimento) = date_part('MONTH', date '$dbDate')"
                . " group by f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, f.dat_nascimento"
                . " order by f.dsc_nome"
                ;

                $result = $con->query($query);

                if (!$result) {
                    echo pg_last_error();
                } 

                while($row = $result->fetchObject()){
                    $rows[] = $row;
                }

                return $rows;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    static function getBirthdateByName($con, $value) {
        try {

            $rows = array();
            
            if($con){
                $query = "select f.isn_funcionario, f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, to_char(f.dat_nascimento, 'dd/mm') as dat_nasc"
                . " from eventosrh.t_funcionario f"
                . " inner join eventosrh.t_funcao fu on f.isn_funcao = fu.isn_funcao"
                . " inner join eventosrh.t_setor s on f.isn_setor = s.isn_setor"
                . " inner join eventosrh.t_filial fi on f.isn_filial = fi.isn_filial"
                . " where f.dat_nascimento is not null"
                . " and cod_situacao <> 'D'"
                . " and f.dsc_nome LIKE '%$value%'"
                . " group by f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, f.dat_nascimento, f.isn_funcionario"
                . " order by f.dsc_nome"
                ;

                $result = $con->query($query);

                if (!$result) {
                    echo pg_last_error();
                } 

                while($row = $result->fetchObject()){
                    $rows[] = $row;
                }

                return $rows;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    static function getBirthdateById($con, $value) {
        try {

            $rows = array();
            
            if($con){
                $query = "select f.isn_funcionario, f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, to_char(f.dat_nascimento, 'dd/mm') as dat_nasc"
                . " from eventosrh.t_funcionario f"
                . " inner join eventosrh.t_funcao fu on f.isn_funcao = fu.isn_funcao"
                . " inner join eventosrh.t_setor s on f.isn_setor = s.isn_setor"
                . " inner join eventosrh.t_filial fi on f.isn_filial = fi.isn_filial"
                . " where f.dat_nascimento is not null"
                . " and cod_situacao <> 'D'"
                . " and f.isn_funcionario =  $value"
                . " group by f.dsc_nome, fu.dsc_funcao ,s.dsc_setor, fi.dsc_filial, f.dat_nascimento, f.isn_funcionario"
                . " order by f.dsc_nome"
                ;

                $result = $con->query($query);

                if (!$result) {
                    echo pg_last_error();
                } 

                while($row = $result->fetchObject()){
                    $rows[] = $row;
                }

                return $rows;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    static function getBirthdateFilial(&$params) {
        try {
            $con = self::open($params);
            $rows = array();
            if($con){
                $query = "select f.dsc_filial from eventosrh.t_filial f";

                $result = $con->query($query);

                if (!$result) {
                    echo pg_last_error();
                } 
                
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $rows[] = $row;
                }

                return $rows;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    static function getParams($id){
        $db = JFactory::getDbo();
        $query	= $db->getQuery(true);
        $query->select("params");
        $query->from("#__modules");
        $query->where("id = " . (int)$id);

        $db->setQuery($query);
        $row = $db->loadResult();

        return $row;
    }
}