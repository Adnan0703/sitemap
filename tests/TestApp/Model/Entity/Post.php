<?php
namespace TestApp\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tests entity class used for asserting correct loading
 *
 */
class Post extends Entity
{

    protected function _getSitemapEntry()
    {
        $url = 'http://example.com/posts/view/' . rand(1, 999999);

        return [
            'url' => $url, // required
            'changefreq' => 'weekly', // optional
            'priority' => '0.8', // optional
        ];
    }
}
