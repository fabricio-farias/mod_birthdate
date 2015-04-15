<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.html.html' );
JHTML::_('behavior.calendar');
?>

<link rel="stylesheet" href="<?php echo JURI::base() . 'modules/mod_birthdate/css/birthdate.css'; ?>" type="text/css" />
<?php if (strpos($_SERVER["HTTP_USER_AGENT"], 'Linux')) {?>
        <link rel="stylesheet" href="<?php echo JURI::base() . 'modules/mod_birthdate/css/birthdate-linux.css'; ?>" type="text/css" />
<?php } ?>

<?php if(!$connection){ ?>
    <div class="jumbotron jumbotron-center">
        <h1><span class="glyphicon glyphicon-warning-sign"></span></h1>
        <p>Não há conexão com banco de dados</p>
    </div>
<?php }elseif($births){ ?>
<div class="custom<?php echo $moduleclass_sfx ?>" <?php if ($params->get('backgroundimage')): ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >
    <div class="birthdate-input-container">
        <div class="birthdate-input-name">
            <input type="text" class="birthdate-class" name="birthdate-input-name" id="birthdate-input-date" style="padding: 5px 25px 5px 10px;width: 350px;" placeholder="pesquisar aniversariante..." />
            <span class="glyphicon glyphicon-search birthdate-img-generic"></span>
            <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>
            <!--<img src="media/system/images/calendar.png" alt="Calendário" class="birthdate-img-generic" class="calendar" />-->
        </div>
        
        <div class="birthdate-input-date">
            <?php echo JHTML::_('calendar', '', 'birthdate-input-date','birthdate-id', '%d-%m-%Y', array('size'=>'18','maxlength'=>'10','class'=>'birthdate-class','readonly'=>'true', 'onchange'=>'findBirthday(this.value);')); ?>
            <span class="glyphicon glyphicon-calendar birthdate-img-generic"></span>
            
            <!--<img src="media/system/images/calendar.png" alt="Calendário" id="birthdate-img-generic" class="calendar" />-->
            
            
            <!--<a href="javascript;:" class="btn btn-warning btn-sm" id="birthdate-search"><span class="glyphicon glyphicon-search"></span> Pesquisar</a>-->
            <!--<a href="javascript;:" class="btn btn-success btn-sm" id="birthdate-clean">&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;</a>-->
        </div>
        <input type="hidden" id="module-id" value="<?php echo $module->id; ?>" />
        <input type="hidden" id="module-date" value="<?php echo date('d/m/Y'); ?>" />
        <input type="hidden" id="sysdate" value="<?php echo date('d-m-Y'); ?>" />
        <input type="hidden" id="output" value="" />
    </div>
    <div id="birthdate-table">
        <!--<div id="loading-id" class="loading"></div>-->
        <table class="birthdate-vert <?php echo $params->get('moduleclass_sfx'); ?>">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>Setor</th>
                    <th>Aniversário</th>
                    <th>Unidade</th>
                </tr>
            </thead>
            <tbody id="birthdate-tbody">
                <?php
                        $arr_units = array(
                            'ISGH' => '<span class="flag flag-info">ISGH</span>',
                            'HGWA' => '<span class="flag flag-success">HGWA</span>',
                            'HRC' => '<span class="flag flag-success">HRC</span>',
                            'HRN' => '<span class="flag flag-success">HRN</span>',
                            'UPA' => '<span class="flag flag-danger">UPA</span>',
                            'APS' => '<span class="flag flag-warning">APS</span>',
                            'SMS' => '<span class="flag flag-warning">SMS</span>'
                        );
                    ?>
                <?php foreach ($births as $birth){?>
                    <?php foreach($arr_units as $k => $v){   
                                  if(strpos(strtoupper($birth->dsc_filial), (string)$k)> -1){   
                                      $dsc_filial = str_replace($k, $birth->dsc_filial, $v);   
                                  }   

                          }
                          ?>
                <tr>
                    <td><?php echo $birth->dsc_nome;?></td>
                    <td><?php echo $birth->dsc_funcao;?></td>
                    <td><?php echo $birth->dsc_setor;?></td>
                    <td align="center"><?php echo $birth->dat_nasc;?></td>
                    <td><?php echo $dsc_filial;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php }else{ ?>
<div class="jumbotron jumbotron-center" style="padding: 3px; margin-bottom: 0;">
    <h1 style="font-size: 40px; margin: 3px 0;"><span class="glyphicon glyphicon-user"></span></h1>
    <p style="font-size: 14px; margin: 0 0 3px;">Não há aniversariantes para a data atual</p>
    </div>
<?php } ?>
                
<script src="<?php echo jURI::base() . 'modules/mod_birthdate/js/mod_birthdate.js'; ?>" type="text/javascript"></script>