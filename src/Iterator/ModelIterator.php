<?php
namespace Sitemap\Iterator;

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
	* @var Query
	*/
	protected $_query = null;
	
	/**
	* Retrieved records.
	*
	* @var array
	*/
	protected $_resultSet = [];

	
	
	/**
	*
	*/
	public function __construct(Query $query, $limit = 500)
	{
		$this->_query = $query;
		$this->_limit = $limit;
	}

	/**
	*
	*/
	public function rewind()
	{
		$this->_counter = 0;
		$this->_queryOffset = 0;
		$this->next();
	}

	/**
	*
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
			$this->_resultSet = $this->_resultSet;
			$this->_queryOffset += $this->_limit;
			$this->_counter = 0;
		}
	}

	/**
	*
	*/
	public function valid()
	{
		return array_key_exists($this->_counter, $this->_resultSet);
	}

	/**
	*
	*/
	public function current()
	{
		return $this->_resultSet[$this->_counter];
	}

	/**
	*
	*/
	public function key()
	{
		return null;
	}

}