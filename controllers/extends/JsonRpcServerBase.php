<?php

namespace controllers\bases;

abstract class JsonRpcServerBase extends UriMethodBase {

    public function beforeProcedure($username, $password, $class, $method){
        if($method == 'beforeProcedure' || $method == 'execute') {
            throw new \JsonRPC\AuthenticationFailure('Wrong credentials!');
        }
        _logDebug("Peticion de $username al método $method");
    }

    public function execute() {
        $server = new \JsonRPC\Server;
        $server->authentication($this->getUsersAuthentication());
        $server->before('beforeProcedure');
        $server->attach($this);
        $response = $server->execute();
        return $response;
    }

    private function getUsersAuthentication() {
        return [RPC_SERVER_USER => RPC_SERVER_PASSWORD];
    }



}
