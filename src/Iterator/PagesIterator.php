<?php
namespace Adnan0703\Sitemap\Iterator;

use Cake\Core\Configure;

/**
 * Iterator for non-model pages. It gets urls from the 'Sitemap.pages' configuration key.
 *
 * @author Adnan Aslam
 * @license MIT
 */
/**
 * An example configuration would be:
 *
 * ```
 *   Configure::write('Sitemap.pages', [
 *       [
 *           'url' => 'http://example.com/', 
 *           'priority' => '0.9', 
 *           'changefreq' => 'daily'
 *       ],
 *       [
 *           'url' => Router::url(['controller' => 'Books', 'action' => 'news'], true), 
 *           'priority' => '0.9', 
 *           'changefreq' => 'daily'
 *       ],
 *   ]);
 * ```
 *
 *
 */
class PagesIterator implements \Iterator
{

    /**
     * @var int
     */
    protected $_counter = 0;
    
    /**
     * @var array
     */
    protected $_pages = [];


    
    /**
     *
     */
    public function __construct()
    {
        $this->_pages = (array)Configure::read('Sitemap.pages'); 
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return void
     */
    public function rewind()
    {
        $this->_counter = 0;
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return void
     */
    public function next()
    {
        $this->_counter++;
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return bool
     */
    public function valid()
    {
        return array_key_exists($this->_counter, $this->_pages);
    }

    /**
     * Returns the current element.
     * @see http://php.net/manual/en/class.iterator.php
     * @return array
     */
    public function current()
    {
        return $this->_pages[$this->_counter];
    }

    /**
     * @see http://php.net/manual/en/class.iterator.php#96691
     * @return int
     */
    public function key()
    {
        return $this->_counter;
    }
}
