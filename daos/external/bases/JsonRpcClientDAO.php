<?php

namespace daos\external\bases;

class JsonRpcClientDAO {

    public static function execute($endPoint,$method,$params = array()) {
        $client = new \JsonRPC\Client($endPoint, 60);
        $client->authentication(RPC_CLIENT_USER, RPC_CLIENT_PASSWORD);
        _logDebug("Metodo llamado: " . $method);
        try {
            return $client->execute($method,$params);
        } catch (\Exception $e) {
            _logDebug("Messasge error: " . $e->getMessage());
            throw new \Exception('Error in Client RPC Connection',ERROR_503);
        }
    }

}
