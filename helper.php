<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive_extended
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved. Modified by Iskar Enev.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_articles_archive_extended
 *
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive_extended
 * @since       1.5
 */
class modArchiveHelper
{
	/*
	 * @since  1.5
	 */
	public static function getList(&$params)
	{
		
		// get category
		$catid = $params->get('catid', array());
		$catid = (is_array($catid) && count($catid)) ? (int)$catid[0] : 0;
		
		//get database
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($query->month($query->quoteName('created')) . ' AS created_month');
		$query->select($query->year($query->quoteName('created')) . ' AS created_year');
		// we need only the month and year from the created date, besides if we include the day GROUP BY will not work as we want
		$query->select('DATE_FORMAT(' . $query->quoteName('created') . ', ' . $query->quote('%Y-%m') . ') as created_date');
		$query->from('#__content');
		$query->where('state = 1 AND checked_out = 0');
		if ((int)$catid) $query->where('catid = ' . (int)$catid);
		$query->group('created_year, created_month, created_date');
		$query->order('created_date DESC');

		// Filter by language
		if (JFactory::getApplication()->getLanguageFilter()) {
			$query->where('language in ('.$db->quote(JFactory::getLanguage()->getTag()).','.$db->quote('*').')');
		}

		$db->setQuery($query, 0, (int) $params->get('count'));
		$rows = (array) $db->loadObjectList();

		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$item	= $menu->getItems('link', 'index.php?option=com_content&view=archive', true);
		$itemid = (isset($item) && !empty($item->id) ) ? $item->id : '';
		$itemid = '&Itemid=' . $itemid;

		$i		= 0;
		$lists	= array();
		foreach ($rows as $row) {
			$date = JFactory::getDate($row->created_date);

			$created_month	= $date->format('n');
			$created_year	= $date->format('Y');

			$created_year_cal	= JHTML::_('date', $row->created_date, 'Y');
			$month_name_cal	= JHTML::_('date', $row->created_date, 'F');

			$lists[$i] = new stdClass;

			$lists[$i]->link	= JRoute::_('index.php?option=com_content&view=archive&year=' . $created_year . '&month=' . $created_month . ((int)$catid ? '&catid=' . (int)$catid : '') . $itemid);
			$lists[$i]->text	= JText::sprintf('MOD_ARTICLES_ARCHIVE_EXTENDED_DATE', $month_name_cal, $created_year_cal);

			$i++;
		}
		return $lists;
	}
}
