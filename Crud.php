<?php

namespace MongoTest;

/**
 * Class Crud
 * @package MongoTest
 */
class Crud
{
    /** @var \MongoDB\Driver\Manager $mongoClient */
    private $mongoClient = null;

    /**
     * Crud constructor.
     * @throws \MongoConnectionException
     */
    public function __construct()
    {
        $this->mongoClient = Client::getInstance();
    }

    /**
     * @param string $collection
     * @param int $id
     * @param array $filter
     * @param array $options
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function getOneRecord(string $collection, int $id, array $filter = [], array $options = []): array
    {
        if (empty($filter)) {
            $filter = [
                Config::FIELD_ID => $id,
            ];
        }

        $query = new \MongoDB\Driver\Query($filter, $options);

        $fullCollectionName = Config::DB
            . '.'
            . $collection;

        /** @var \MongoDB\Driver\Cursor $rows */
        $rows = $this->getMongoClient()->executeQuery($fullCollectionName, $query);

        return $rows->toArray();
    }

    /**
     * @param string $collection
     * @param array $filter
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function getRecords(string $collection, $filter = []): array
    {
        $options = [
            'sort' => [
                'dateCreated' => Config::SORT_DESC
            ]
        ];

        $query = new \MongoDB\Driver\Query($filter, $options);

        $fullCollectionName = Config::DB
            . '.'
            . $collection;

        /** @var \MongoDB\Driver\Cursor $rows */
        $rows = $this->getMongoClient()->executeQuery($fullCollectionName, $query);

        return $rows->toArray();
    }


    /**
     * @param string $collection
     * @param array $pipeline
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function aggregation(string $collection, array $pipeline):array
    {
        $command = new \MongoDB\Driver\Command(
            [
                'aggregate' => $collection,
                'pipeline' => $pipeline,
                'cursor' => new \stdClass(),
            ]
        );

        /** @var \MongoDB\Driver\Cursor $rows */
        $rows = $this->getMongoClient()->executeCommand(Config::DB, $command);

        return $rows->toArray();

    }

    /**
     * @param string $collection
     * @param array $filter
     * @param array $data
     * @return bool
     */
    public function updateRecord(string $collection, array $filter, array $data):bool
    {
        $fullCollectionName = Config::DB
            . '.'
            . $collection;

        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->update(
            $filter,
            $data
        );

        /** @var \MongoDB\Driver\WriteResult $result */
        $result = $this->getMongoClient()->executeBulkWrite($fullCollectionName,$bulk);

        if (
            $result->getModifiedCount()
            || $result->getMatchedCount()
            || $result->getInsertedCount()
            || $result->getUpsertedCount()
        ){
            return true;
        }

        return false;

    }


    /**
     * @throws \Exception
     */
    public function insertRecord()
    {
        throw new \Exception('Not implemented yet.');
    }

    /**
     * @throws \Exception
     */
    public function deleteRecord()
    {
        throw new \Exception('Not implemented yet.');
    }

    /**
     * @return \MongoDB\Driver\Manager
     */
    private function getMongoClient()
    {
        return $this->mongoClient;
    }

}