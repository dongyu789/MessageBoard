<?php


namespace App\Repository;


use App\Client\ES\ES;

class ESRepository
{
    public function __construct()
    {
        $this->client = app(ES::class)->getClient();
    }

    /**
     * 根据关键字搜索留言
     * @param $tags
     */
    public function searchTags($tags)
    {
        $params = [
            'index' => 'message',
            'body' => [
                'query' => [
                    'match' => [
                        "message" => $tags
                    ]
                ],
                'highlight' => [
                    'pre_tags' => '<font color="red">',
                    'post_tags' => '</font>',
                    'fields' => [
                        'message' => new \stdClass()
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        $hits = $response['hits']['hits'];
    //dd($hits);

        $datas = collect([]);
        if ($hits == null) {
            return $datas;
        }

        foreach ($hits as $hit) {
            $datas->push([
                'user_id' => $hit['_source']['user_id'],
                'message' => $hit['highlight']['message'][0],
                'message_id' => $hit['_source']['message_mysql_id']
            ]);
        }

        return $datas;

    }
    public function save($userId, $message, $messageId)
    {
        $params = [
            'index' => 'message',
            'id' => $messageId,
            'body' => [
                'user_id' => $userId,
                'message' => $message,
                'message_mysql_id' => $messageId
            ]
        ];
        $this->client->index($params);
    }

    public function delete($messageId)
    {
        $params = [
            'index' => 'message',
            'id' => $messageId
        ];
        $this->client->delete($params);
    }

    public function update($messageId, $newMessage)
    {
        $params = [
            'index' => 'message',
            'type' => '_doc',
            'id' => $messageId,
            'body' => [
                'doc' => [
                    'message' => $newMessage
                ]
            ]
        ];
        $this->client->update($params);
    }



}