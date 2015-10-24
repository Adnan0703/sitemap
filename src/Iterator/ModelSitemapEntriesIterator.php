<?php
namespace Adnan0703\Sitemap\Iterator;

use Adnan0703\Sitemap\Iterator\ModelIterator;
use Cake\ORM\Query;

/**
 * Extends ModelIterator
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelSitemapEntriesIterator extends ModelIterator
{

    /**
     *
     */
    public function current()
    {
        return $this->_resultSet[$this->_counter]->sitemap_entry;
    }
}
