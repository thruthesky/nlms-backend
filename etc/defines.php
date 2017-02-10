<?php
$em = [];
define('ERROR_WRONG_MODEL_CLASS', 40040);           $em[ERROR_WRONG_MODEL_CLASS] = "model-class-not-found";
define('ERROR_NO_HANDLER', 40041);                  $em[ERROR_NO_HANDLER] = "handler-not-found";
define('ERROR_KEY_EXISTS', 23000);                  $em[ERROR_KEY_EXISTS] = 'key-exists';
define('ERROR_UNKNOWN', 4000);                      $em[ERROR_UNKNOWN] = 'unknown-error';
define('ERROR_DATABASE_INSERT_FAILED', 40020);      $em[ERROR_DATABASE_INSERT_FAILED] = 'insert-failed';
define('ERROR_USER_NOT_EXIST', 40010);              $em[ERROR_USER_NOT_EXIST] = 'user-not-exist';
define('ERROR_CANNOT_CHANGE_USER_ID', 40031);       $em[ERROR_CANNOT_CHANGE_USER_ID] = 'cannot-change-user-id';
define('ERROR_SESSION_ID_EMPTY', 40051);            $em[ERROR_SESSION_ID_EMPTY] = 'session-id-is-empty';
define('ERROR_WRONG_SESSION_ID', 40052);            $em[ERROR_WRONG_SESSION_ID] = 'wrong-session-id';
define('ERROR_USER_ID_EMPTY', 40053 );              $em[ERROR_USER_ID_EMPTY] = 'user-id-empty';
define('ERROR_PASSWORD_EMPTY', 40054 );             $em[ERROR_PASSWORD_EMPTY] = 'password-empty';
define('ERROR_USER_NOT_FOUND',40055 );              $em[ERROR_USER_NOT_FOUND] = 'user-not-found';
define('ERROR_WRONG_PASSWORD', 40056 );             $em[ERROR_WRONG_PASSWORD] = 'wrong-password';
define('ERROR_USER_NOT_SET', 40057);                $em[ERROR_USER_NOT_SET] = 'user-not-set-in-user-class-call-reset-method';
define('ERROR_MALFORMED_RESPONSE', 40060);          $em[ERROR_MALFORMED_RESPONSE] = 'malformed-response';
define('ERROR_RECORD_NOT_SET', 40070);              $em[ERROR_RECORD_NOT_SET] = 'record-not-set';
define('OK', 0);


