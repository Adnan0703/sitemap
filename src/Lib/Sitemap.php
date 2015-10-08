<?php
namespace Adnan0703\Sitemap\Lib;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;
use Tackk\Cartographer\SitemapFactory;
use Adnan0703\Sitemap\Iterator\ModelsSitemapEntriesIterator;


/**
 * Main class for generating sitemap.
 *
 * @author Adnan Aslam
 * @license MIT
 */
class Sitemap
{
	
	/**
	* Filesystem object
	*
	* @var Filesystem
	*/
	public $Filesystem = null;
	
	/**
	* SitemapFactory object
	*
	* @var SitemapFactory
	*/
	public $SitemapFactory = null;
	
	
	
	/**
	* Utility function to generates the sitemap(s).
	*
	* @param string $dirPath Path of directory to save the sitemap(s) in.
	* @param string $baseUrl Base url for the sitemap "files".
	* @param array  $models  Models to generate the sitemap from.
	* @param bool   $renameFile If true, renames the sitemap file to 'sitemap.xml'.
	* @return string The URL of the sitemap or sitemap index.
	*/
	public function createSitemap($dirPath, $baseUrl, array $models, $renameFile = true)
	{
		$adapter = new LocalAdapter($dirPath);
		$this->Filesystem = new Filesystem($adapter);
		$this->SitemapFactory = new SitemapFactory($this->Filesystem);
		$this->SitemapFactory->setBaseUrl($baseUrl);

		// Create an Iterator of your URLs.
		$urlsIterator = new ModelsSitemapEntriesIterator($models);

		// Returns the URL to the main Sitemap/Index file
		$mainSitemap = $this->SitemapFactory->createSitemap($urlsIterator);
		$dirPath = static::trimPath(static::normalizePath($dirPath));
		$sitemapFile = $dirPath . DS .  basename($mainSitemap);
		if ($renameFile && file_exists($sitemapFile)) {
			rename($sitemapFile, $dirPath . DS . 'sitemap.xml');
			$mainSitemap = static::trimPath($baseUrl) . '/sitemap.xml';
		}
		return $mainSitemap;
	}
	
	/**
	 * Helper method to trim last trailing slash in file path
	 *
	 * @param string $path Path to trim
	 * @return string Trimmed path
	 */
	public static function trimPath($path) {
		$len = strlen($path);
		if ($path[$len - 1] == '\\' || $path[$len - 1] == '/') {
			$path = substr($path, 0, $len - 1);
		}
		return $path;
	}

	/**
	 * Converts windows to linux pathes and vice versa
	 *
	 * @param string
	 * @return string
	 */
	public static function normalizePath($string) {
		if (DS == '\\') {
			return str_replace('/', '\\', $string);
		} else {
			return str_replace('\\', '/', $string);
		}
	}	
}