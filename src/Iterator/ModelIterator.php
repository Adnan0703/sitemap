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
     * Number of records that should be skipped from the original result set.
     * Option for query object.
     *
     * @var int
     */
    protected $_queryOffset = 0;
    
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
     * @param \Cake\ORM\Query $query
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
        $this->_queryOffset = 0;
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
                ->offset($this->_queryOffset)
                ->limit($this->_limit)
                ->all()
                ->toArray();
            $this->_queryOffset += $this->_limit;
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
	 * @param bool $sitemap_entry true means return sitemap entry array.
	 * false means return entity.
     * @return array | \Cake\Datasource\EntityInterface
	 *
	 * @see http://php.net/manual/en/class.iterator.php
     */
    public function current($sitemap_entry = true)
    {
		if ($sitemap_entry === true) {
			return $this->_sitemap_entry();
		}
		
        return $this->_resultSet[$this->_counter];
    }
	
	/**
	 * Returns the current sitemap entry.
	 */
	protected function _sitemap_entry()
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
