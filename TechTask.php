<?php

namespace MongoTest;

/**
 * Class TechTask
 * @package MongoTest
 */
class TechTask
{
    private const COLLECTION_ARTICLES = 'articles';
    private const COLLECTION_USERS = 'users';


    /** @var Crud */
    private $crud;

    /**
     * TechTask constructor.
     * @throws \MongoConnectionException
     */
    public function __construct()
    {
        $this->crud = new Crud();
    }


    /**
     * @param int|null $user
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    function getArticles(int $user = null): array
    {

        if (false === empty($user)) {
            $filter = [
                Config::FIELD_USER_ID => $user,
            ];
        } else {
            $filter = [];
        }
        return $this->getCrud()->getRecords(self::COLLECTION_ARTICLES, $filter);


    }

    /**
     * @param int $id
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    function getArticleByID(int $id): array
    {

        //db.articles.aggregate({ $match: {_id : 2 }},{$unwind: '$comments'},{ $sort: {'comments.dateCreated': -1 }},{$group:{'_id':'$_id','title':{$first:'$title'},'userId':{$first:'$userId'},'text':{$first:'$text'},'dateCreated':{$first:'$dateCreated'},comments:{$push:'$comments'}}})
        $pipeline = [
            ['$match' => [Config::FIELD_ID => $id]],
            ['$unwind' => '$comments'],
            ['$sort' => ['comments.dateCreated' => Config::SORT_DESC]],
            ['$group' => [
                '_id' => '$_id',
                'title' => ['$first' => '$title'],
                'userId' => ['$first' => '$userId'],
                'text' => ['$first' => '$text'],
                'dateCreated' => ['$first' => '$dateCreated'],
                'comments' => ['$push' => '$comments'],
            ]
            ],
        ];
        return $this->getCrud()->aggregation(self::COLLECTION_ARTICLES, $pipeline);

    }

    /**
     * @param string $text
     * @param int $articleID
     * @return array
     */
    function addCommentToArticle(string $text, int $articleID): array
    {
        $filter = [
            Config::FIELD_ID => $articleID,
        ];

        $createDate = date(DATE_ISO8601);

        $data = [
            '$push' => [
                'comments' => [
                    'text' => $text,
                    'userId' => 3,
                    'dateCreated' => $createDate
                ]
            ]
        ];

        //db.articles.updateOne({'_id':1},{"$push":{"comments":{"text":"sample text","userId":3,"dateCreated":"2019-02-07T00:09:04+0200"}}})
        if ($this->getCrud()->updateRecord(self::COLLECTION_ARTICLES, $filter, $data)) {
            return ['dateCreated' => $createDate];
        }
        return [];

    }

    /**
     * @return Crud
     */
    protected function getCrud(): Crud
    {
        return $this->crud;
    }

}