<?php
$em = [];
define('ERROR_KEY_EXISTS', 23000);
define('ERROR_UNKNOWN', 4000);
define('ERROR_DATABASE_INSERT_FAILED', 40020);
define('ERROR_USER_NOT_EXIST', 40010);              $em[ERROR_USER_NOT_EXIST] = 'user-not-exist';
define('ERROR_CANNOT_CHANGE_USER_ID', 40031);       $em[ERROR_CANNOT_CHANGE_USER_ID] = 'cannot-change-user-id';
define('ERROR_SESSION_ID_EMPTY', 40051);            $em[ERROR_SESSION_ID_EMPTY] = 'session-id-is-empty';
define('ERROR_WRONG_SESSION_ID', 40052);            $em[ERROR_WRONG_SESSION_ID] = 'wrong-session-id';
define('OK', 0);
