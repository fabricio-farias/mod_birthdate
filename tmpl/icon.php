<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$rel = (strpos($moduleclass_sfx, 'modal')> -1) ? "{handler: 'iframe', size: {x: 875, y: 550}, iframeOptions: {scrolling: 'auto'}, onClose: function() {}}" : "";
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
            <a class="birthdate-icon <?php echo $moduleclass_sfx ?> button-icon" <?php echo $data_counter;?> href="<?php echo $birth_link;?>" rel="<?php echo $rel; ?>"></a>
        </div>
    </div>
</div>