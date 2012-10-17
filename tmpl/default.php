<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive_extended
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved. Modified by Iskar Enev.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (!empty($list)) :?>
	<ul class="archive-module<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) : ?>
	<li>
		<a href="<?php echo $item->link; ?>">
			<?php echo $item->text; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
