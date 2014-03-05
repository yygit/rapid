<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',

    /*preloading 'log' component*/
    'preload' => array('log'),
    /*autoloading model and component classes*/
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.auditTrail.models.AuditTrail', // traces changes in AR models
    ),
    /*application components*/
    'components' => array(
        'db2' => array( // default for unit testing
            'connectionString' => 'mysql:host=localhost;dbname=rapid_test',
            'emulatePrepare' => true,
            'username' => 'yy',
            'password' => 'yura',
            'charset' => 'utf8',
        ),
        'db' => array(
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
                    'logFile' => 'console.log',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                    'categories' => 'jobprocessor',
                    'logFile' => 'jobprocessor.log',
                ),
            ),
        ),
        'Smtpmail' => array(
            'class' => 'ext.smtpmail.PHPMailer',
            'Host' => "smtp.gmail.com",
            'Username' => 'nebazori@gmail.com',
            'Password' => 'z87654312',
            'Mailer' => 'smtp',
            'Port' => 587,
            'SMTPAuth' => true,
            'SMTPSecure' => 'tls',
        ),
    ),
    /*'modules' => array(
        'auditTrail' => array(
            'userClass' => 'User', // the class name for the user object, 'User' is default
            'userIdColumn' => 'id', // the column name of the primary key for the user, 'id' is default
            'userNameColumn' => 'username', // the column name of the primary key for the user, 'username' is default
        ),
    ),*/
);
