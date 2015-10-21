<?php

namespace Sitemap\TestCase\Lib;

use Sitemap\Lib\Sitemap;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class SitemapTest extends TestCase {

	public $fixtures = ['app.articles', 'app.posts'];

	public function setUp() 
	{
		parent::setUp();

		$this->skipIf(!class_exists('Tackk\Cartographer\SitemapFactory'));
		$this->skipIf(!class_exists('League\Flysystem\Filesystem'));
	}

	/**
	 * Sitemap test
	 *
	 * @return void
	 */
	public function testCreateSitemap() 
	{
		set_time_limit(60*10); // if you have lots of records
		$dirPath = WWW_ROOT . DS . 'sitemaps';
		$filePath = $dirPath . DS . 'sitemap.xml';
        if (file_exists($filePath)) {
            unlink($filePath);
        }
		
		$models = ['Articles', 'Posts'];
		$this->_setPagesLinks();
		$sitemap = new \Adnan0703\Sitemap\Lib\Sitemap();
		$mainSitemap = $sitemap->createSitemap(
			$dirPath, 
			'http://cakephp.org/sitemaps/', 
			$models, 
			true
		);
		$this->assertTrue(file_exists($filePath));
		$this->assertTrue(filesize($filePath) > 0);
		// $mainSitemap will be 'http://cakephp.org/sitemaps/sitemap.xml'
		$this->assertTrue($mainSitemap == 'http://cakephp.org/sitemaps/sitemap.xml');
	}
	
	/**
	*
	*/
	private function _setPagesLinks()
	{
		Configure::write('Sitemap.pages', [
			[
				'url' => 'http://cakephp.org/pages/home',
				'priority' => '0.9', 
				'changefreq' => 'daily'
			],
			[
				'url' => 'http://cakephp.org/pages/about_us',
				'priority' => '0.9', 
				'changefreq' => 'daily'
			],
		]);
	}
}

