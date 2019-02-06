<?php

namespace MongoTest;

/**
 * Class Config
 * @package MongoTest
 */
class Config
{
    /*
     * Connection params
     */
    public const HOST = 'localhost';
    public const PORT = 27017;
    public const DB = 'blog';

    /*
     * Sort values
     */
    public const SORT_ASC = 1;
    public const SORT_DESC = -1;

    /*
     * Default fields
     */
    public const FIELD_USER_ID = 'userId';
    public const FIELD_ID = '_id';


}