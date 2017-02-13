<?php
$em = [];


define('ERROR_UNKNOWN', -40000);                     $em[ERROR_UNKNOWN] = 'unknown-error';


define('ERROR_MODEL_CLASS_NOT_FOUND', -40040);       $em[ERROR_MODEL_CLASS_NOT_FOUND] = "model-class-not-found";
define('ERROR_NO_RESPONSE', -40041);                  $em[ERROR_NO_RESPONSE] = "no-success-error-response";
define('ERROR_MODEL_CLASS_EMPTY', -40042);              $em[ERROR_MODEL_CLASS_EMPTY] = 'model-class-empty';
define('ERROR_MODEL_CLASS_METHOD_NOT_EXIST', -40043);    $em[ERROR_MODEL_CLASS_METHOD_NOT_EXIST] = 'method-not-exist';



define('ERROR_KEY_EXISTS', -40080);                  $em[ERROR_KEY_EXISTS] = 'key-exists';
define('ERROR_DATABASE_INSERT_FAILED', -40081);      $em[ERROR_DATABASE_INSERT_FAILED] = 'insert-failed';
define('ERROR_DATABASE_QUERY', -40083);             $em[ERROR_DATABASE_QUERY] = 'database-query-failed';
define('ERROR_EMPTY_SQL_CONDITION', -40084);            $em[ERROR_EMPTY_SQL_CONDITION] = 'error-empty-sql-condition';
define('ERROR_INSCURE_SQL_CONDITION', -40085);          $em[ERROR_INSCURE_SQL_CONDITION] = 'sql-condition-not-secure';


define('ERROR_MALFORMED_RESPONSE', -40101);          $em[ERROR_MALFORMED_RESPONSE] = 'malformed-response.return-data-is-not-array';

define('ERROR_USER_NOT_EXIST', -40102);              $em[ERROR_USER_NOT_EXIST] = 'user-not-exist';
define('ERROR_CANNOT_CHANGE_USER_ID', -40103);       $em[ERROR_CANNOT_CHANGE_USER_ID] = 'cannot-change-user-id';
define('ERROR_SESSION_ID_EMPTY', -40104);            $em[ERROR_SESSION_ID_EMPTY] = 'session-id-is-empty';
define('ERROR_WRONG_SESSION_ID', -40105);            $em[ERROR_WRONG_SESSION_ID] = 'wrong-session-id';
define('ERROR_USER_ID_EMPTY', -40106 );              $em[ERROR_USER_ID_EMPTY] = 'user-id-empty';
define('ERROR_PASSWORD_EMPTY', -40107 );             $em[ERROR_PASSWORD_EMPTY] = 'password-empty';
define('ERROR_USER_NOT_FOUND',-40108 );              $em[ERROR_USER_NOT_FOUND] = 'user-not-found';
define('ERROR_WRONG_PASSWORD', -40109 );             $em[ERROR_WRONG_PASSWORD] = 'wrong-password';
define('ERROR_USER_NOT_SET', -40100);                $em[ERROR_USER_NOT_SET] = 'user-not-set-in-user-class-call-reset-method';
define('ERROR_RECORD_NOT_SET', -40102);              $em[ERROR_RECORD_NOT_SET] = 'record-not-set';
define('OK', 0);


