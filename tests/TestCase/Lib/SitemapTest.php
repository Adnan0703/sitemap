<?php

namespace Sitemap\TestCase\Lib;

use Sitemap\Lib\Sitemap;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

class SitemapTest extends TestCase {

	//public $fixtures = ['core.articles'];

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
	}

}