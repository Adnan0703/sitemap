<?php
namespace TestApp\Model\Entity;

use Cake\ORM\Entity;

/**
 *
 *
 */
class Article extends Entity
{

    protected function _getSitemapEntry() 
    {
        $url = 'http://example.com/articles/view/' . rand(1, 999999);
        return [
            'url' => $url, // required
            'changefreq' => 'weekly', // optional
            'priority' => '0.8', // optional
        ];
    }
}
