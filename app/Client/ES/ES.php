<?php


namespace App\Client\ES;


use Elasticsearch\ClientBuilder;

class ES
{
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(config('elasticSearch.https'))->build();
    }

    public function getClient()
    {
        return $this->client;
    }


    public function search()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}