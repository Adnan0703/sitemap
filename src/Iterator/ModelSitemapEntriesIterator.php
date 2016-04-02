<?php
namespace Adnan0703\Sitemap\Iterator;

/**
 * Extends ModelIterator
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelSitemapEntriesIterator extends ModelIterator
{

    /**
     * Returns the current element.
     * @see http://php.net/manual/en/class.iterator.php
     * @return array
     */
    public function current()
    {
        return $this->_resultSet[$this->_counter]->sitemap_entry;
    }
}
