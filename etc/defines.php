<?php
$em = [];


define('ERROR_UNKNOWN', 40000);                     $em[ERROR_UNKNOWN] = 'unknown-error';


define('ERROR_MODEL_CLASS_NOT_FOUND', 40040);       $em[ERROR_MODEL_CLASS_NOT_FOUND] = "model-class-not-found";
define('ERROR_NO_HANDLER', 40041);                  $em[ERROR_NO_HANDLER] = "handler-not-found";
define('ERROR_MODEL_CLASS_EMPTY', 40042);

define('ERROR_KEY_EXISTS', 40080);                  $em[ERROR_KEY_EXISTS] = 'key-exists';
define('ERROR_DATABASE_INSERT_FAILED', 40081);      $em[ERROR_DATABASE_INSERT_FAILED] = 'insert-failed';
define('ERROR_USER_NOT_EXIST', 40082);              $em[ERROR_USER_NOT_EXIST] = 'user-not-exist';
define('ERROR_CANNOT_CHANGE_USER_ID', 40083);       $em[ERROR_CANNOT_CHANGE_USER_ID] = 'cannot-change-user-id';
define('ERROR_SESSION_ID_EMPTY', 40084);            $em[ERROR_SESSION_ID_EMPTY] = 'session-id-is-empty';
define('ERROR_WRONG_SESSION_ID', 40085);            $em[ERROR_WRONG_SESSION_ID] = 'wrong-session-id';
define('ERROR_USER_ID_EMPTY', 40086 );              $em[ERROR_USER_ID_EMPTY] = 'user-id-empty';
define('ERROR_PASSWORD_EMPTY', 40087 );             $em[ERROR_PASSWORD_EMPTY] = 'password-empty';
define('ERROR_USER_NOT_FOUND',40088 );              $em[ERROR_USER_NOT_FOUND] = 'user-not-found';
define('ERROR_WRONG_PASSWORD', 40089 );             $em[ERROR_WRONG_PASSWORD] = 'wrong-password';
define('ERROR_USER_NOT_SET', 40090);                $em[ERROR_USER_NOT_SET] = 'user-not-set-in-user-class-call-reset-method';
define('ERROR_MALFORMED_RESPONSE', 40091);          $em[ERROR_MALFORMED_RESPONSE] = 'malformed-response';
define('ERROR_RECORD_NOT_SET', 40092);              $em[ERROR_RECORD_NOT_SET] = 'record-not-set';
define('OK', 0);


