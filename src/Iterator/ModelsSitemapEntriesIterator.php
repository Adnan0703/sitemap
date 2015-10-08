<?php
namespace Adnan0703\Sitemap\Iterator;

use AppendIterator;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Adnan0703\Sitemap\Iterator\PagesIterator;
use Adnan0703\Sitemap\Iterator\ModelSitemapEntriesIterator;


/**
 * Iterator to iterate over many tables one by one using AppendIterator
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelsSitemapEntriesIterator implements \Iterator
{
	
	/**
	* AppendIterator object.
	*
	* @var AppendIterator
	*/
	protected $_appendIterator = null;
	
	/**
	* Names of models that will be iterated.
	*
	* @var array
	*/
	protected $_models = [];

	
	
	/**
	*
	* @param array $models Array of models names
	*/
	public function __construct(array $models)
	{
		if (empty($models) || !is_array($models)) {
			throw new InvalidArgumentException('Invalid model(s).');
		}
		$this->_models = $models;
		$this->_findLimit = Configure::read('Sitemap.findLimit');
		if (!$this->_findLimit) {
			$this->_findLimit = 600;
		}
	}

	/**
	*
	*/
	public function rewind()
	{
		$this->_setAppendIterator();
	}

	/**
	*
	*/
	public function next()
	{
		$this->_appendIterator->next();
	}

	/**
	*
	*/
	public function valid()
	{
		return $this->_appendIterator->valid();
	}

	/**
	*
	*/
	public function current()
	{
		return $this->_appendIterator->current();
	}
	
	/**
	*
	*/
	protected function _setAppendIterator()
	{
		$this->_appendIterator = new AppendIterator();
		$this->_appendIterator->append(new PagesIterator());
		
		foreach ($this->_models as $a_model) {
			$this->_appendIterator->append($this->_getSitemapEntriesIterator($a_model));
		}
	}
	
	/**
	* @param string $model Model name.
	* @return ModelSitemapEntriesIterator instance
	*/
	protected function _getSitemapEntriesIterator($model) 
	{
		$model = TableRegistry::get($model);
		return new ModelSitemapEntriesIterator($model->sitemapQuery(), $this->_findLimit);
	}

	/**
	*
	*/
	public function key()
	{
		return null;
	}

}