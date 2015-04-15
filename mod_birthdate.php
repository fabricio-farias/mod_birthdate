<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

if ($params->def('prepare_content', 1))
{
	JPluginHelper::importPlugin('content');
	$module->content = JHtml::_('content.prepare', $module->content, '', 'mod_birthdate.content');
}

$connection = modBirthdateHelper::open($params);
$births = modBirthdateHelper::getBirthdate($params);

$birth_title    = $params->get('modulebutton_title') ? $params->get('modulebutton_title') : 'Aniversariante(s)';
$birth_link     = $params->get('modulebutton_link') ? $params->get('modulebutton_link') : 'javascript:;';

$moduleclass_sfx = $params->get('moduleclass_sfx');
$layoutModulePath = JModuleHelper::getLayoutPath('mod_birthdate', $params->get('layout', 'default'));
require ($layoutModulePath);