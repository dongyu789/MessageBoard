<?php
/**
 * 使用elasticSearch进行留言关键词检索功能
 */

namespace App\Service;


use App\Client\ES\ES;
use App\Repository\ESRepository;
use Elasticsearch\ClientBuilder;


class ESSearchMessageService
{
    public function __construct()
    {
        $this->client = app(ES::class)->getClient();
    }

    /**
     * 根据关键字搜索留言
     * @param $tags
     */
    public function searchMessage($tags)
    {
       $datas = app(ESRepository::class)->searchTags($tags);


       return $datas;

    }


}