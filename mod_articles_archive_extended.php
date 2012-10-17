<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive_extended
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved. Modified by Iskar Enev.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$params->def('count', 10);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$list = modArchiveHelper::getList($params);

require JModuleHelper::getLayoutPath('mod_articles_archive_extended', $params->get('layout', 'default'));
