<?php
namespace Adnan0703\Sitemap\Iterator;

use Cake\ORM\Query;

/**
 * Iterator to iterate over table records.
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelIterator implements \Iterator
{
    /**
     * @var int
     */
    protected $_counter = 0;

    /**
     * Number of records that should be retrieved from database on each iteration.
     *
     * @var int
     */
    protected $_limit = 500;
    
    /**
     * The page of results.
     *
     * @var int
     */
    protected $_page = 1;

    /**
     * Query object.
     *
     * @var \Cake\ORM\Query
     */
    protected $_query = null;

    /**
     * Retrieved records.
     *
     * @var array
     */
    protected $_resultSet = [];



    /**
     * @param \Cake\ORM\Query $query Query object
     * @param int $limit Number of records that should be retrieved from database on each iteration.
     */
    public function __construct(Query $query, $limit = 500)
    {
        $this->_query = $query;
        $this->_limit = $limit;
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return void
     */
    public function rewind()
    {
        $this->_counter = 0;
        $this->_page = 1;
        $this->next();
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return void
     */
    public function next()
    {
        $this->_counter++;
        if (!isset($this->_resultSet[$this->_counter])) {
            $this->_resultSet = $this->_query
                ->limit($this->_limit)
                ->page($this->_page)
                ->all()
                ->toArray();
            $this->_page++;
            $this->_counter = 0;
        }
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return bool
     */
    public function valid()
    {
        return array_key_exists($this->_counter, $this->_resultSet);
    }

    /**
     * Returns the current sitemap entry or entity.
     *
     * @param bool $sitemapEntry true means return sitemap entry array.
     * false means return entity.
     * @return array | \Cake\Datasource\EntityInterface
     *
     * @see http://php.net/manual/en/class.iterator.php
     */
    public function current($sitemapEntry = true)
    {
        if ($sitemapEntry === true) {
            return $this->_sitemapEntry();
        }

        return $this->_resultSet[$this->_counter];
    }

    /**
     * Returns the current sitemap entry.
     * @return array
     */
    protected function _sitemapEntry()
    {
        return $this->_resultSet[$this->_counter]->sitemap_entry;
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return null
     */
    public function key()
    {
        return null;
    }
}
