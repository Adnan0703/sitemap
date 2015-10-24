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

    protected $_counter = 0;
    protected $_pages = [];


    
    /**
     *
     */
    public function __construct()
    {
        $this->_pages = (array)Configure::read('Sitemap.pages'); 
    }

    /**
     *
     */
    public function rewind()
    {
        $this->_counter = 0;
    }

    /**
     *
     */
    public function next()
    {
        $this->_counter++;
    }

    /**
     *
     */
    public function valid()
    {
        return array_key_exists($this->_counter, $this->_pages);
    }

    /**
     *
     */
    public function current()
    {
        return $this->_pages[$this->_counter];
    }

    /**
     *
     */
    public function key()
    {
        return $this->_counter;
    }
}
