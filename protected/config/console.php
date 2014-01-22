<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',

    /*preloading 'log' component*/
    'preload' => array('log'),

    /*application components*/
    'components' => array(
        'db' => array( // default for unit testing
            'connectionString' => 'mysql:host=localhost;dbname=rapid_test',
            'emulatePrepare' => true,
            'username' => 'yy',
            'password' => 'yura',
            'charset' => 'utf8',
        ),
        'db2' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=rapid',
            'emulatePrepare' => true,
            'username' => 'yy',
            'password' => 'yura',
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db2',
            'assignmentTable' => 'auth_assignment',
            'itemTable' => 'auth_item',
            'itemChildTable' => 'auth_item_child',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);
