<?php
namespace model\system;
class System extends \model\base\Base {

    public function version() {

        success(['version'=>'0.0.2'] );
    }

    public function error() {
        error( ERROR_FAKE_ERROR );
    }

    public function scriptError() {
        die( 1 / 0 );
    }
    public function internalError() {

        http_response_code(500);
        die();
    }
    public function timeoutError() {
        sleep(5);
        success(['note'=>'This should be timeout error'] );
    }

}