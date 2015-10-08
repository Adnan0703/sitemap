<?php
namespace Sitemap\Iterator;

use Cake\ORM\Query;
use Sitemap\Iterator\ModelIterator;


/**
 * Extends ModelIterator
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelSitemapEntriesIterator extends ModelIterator
{

	public function current()
	{
		return $this->_resultSet[$this->_counter]->sitemap_entry;
	}
}
