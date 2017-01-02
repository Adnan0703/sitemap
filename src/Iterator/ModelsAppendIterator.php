<?php
namespace Adnan0703\Sitemap\Iterator;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 *
 *
 * @author Adnan Aslam
 * @license MIT
 */
class ModelsAppendIterator extends \AppendIterator
{

    /**
     * Names of models that will be iterated.
     *
     * @var array
     */
    protected $_models = [];

    /**
     * Number of records that should be retrieved from database on each iteration.
     *
     * @var int
     */
    protected $_findLimit;


    /**
     * @param array $models Array of models names
     */
    public function __construct(array $models)
    {
        parent::__construct();

        if (empty($models) || !is_array($models)) {
            throw new InvalidArgumentException('Invalid model(s).');
        }

        $this->_models = $models;
        $this->_findLimit = Configure::read('Sitemap.findLimit');
    }

    /**
     * @return void
     */
    protected function _setAppendIterator()
    {
        $this->append(new PagesIterator());

        foreach ($this->_models as $modelName) {
            $this->append($this->_getModelIterator($modelName));
        }
    }

    /**
     * @param string $model Model name.
     * @return ModelSitemapEntriesIterator instance
     */
    protected function _getModelIterator($model)
    {
        $model = TableRegistry::get($model);
        if (is_int($this->_findLimit)) {
            return new ModelIterator($model->sitemapQuery(), $this->_findLimit);
        } else {
            return new ModelIterator($model->sitemapQuery());
        }
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return null
     */
    public function key()
    {
        return null;
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return void
     */
    public function rewind()
    {
        $this->_setAppendIterator();
    }
}
