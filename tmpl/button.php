<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<link rel="stylesheet" href="<?php echo JURI::base() . 'modules/mod_birthdate/css/birthdate.css'; ?>" type="text/css" />

<?php if(!$connection){ ?>
        <?php $data_counter = 'data-counter="Não há conexão"'; ?>
<?php } elseif($births){?>
    <?php $data_counter = 'data-counter="'.count($births).'"';?>
<?php } ?>

<div class="custom<?php echo $moduleclass_sfx ?>" <?php if ($params->get('backgroundimage')): ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?> >
    <div class="topmenu">
        <div class="rt-block">
            <a class="btn btn-default previous" <?php echo $data_counter;?> href="<?php echo $birth_link;?>"><?php echo $birth_title;?></a>
        </div>
    </div>
</div>