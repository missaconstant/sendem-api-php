<?php

namespace SENDEM;

include_once __DIR__ . '/SENDEMURL.php';

/**
 * SENDM SMS API
 * @author SENDEM DEV TEAM
 */
class SMSApi
{

    /**
     * Api path
     */
    private $path = 'http://api.sendem.ci/webSMS';

    /**
     * Api Username
     */
    private $username;

    /**
     * Api Password
     */
    private $password;


    public function __construct( $username, $password )
    {
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @method
     * Send a messagae
     * @param params
     */
    public function send( $params )
    {
        $params = (object) $params;
        
        return $this->query( '/send', [
            "sender"    => $params->senderID,
            "numbers"   => is_array( $params->numbers ) ? implode( ',', $params->numbers ) : $params->numbers,
            "message"   => $params->message
        ]);
    }


    /**
     * @method
     * Check SMS balance
     */
    public function balance()
    {
        return $this->query( '/checkbalance' );
    }


    /**
     * @method
     * do HTTP queries
     * @param params
     */
    private function query( $path, $params = [] )
    {
        /* merging datas */
        $v = array_merge( $params, [ "username" => $this->username, "password" => $this->password ]);

        /* query */
        $r = URL::post( $this->path . $path, $v );

        /* answer tests */
        if ( !$r )
        {
            return [ 'error' => true, 'errorcode' => 'NETFAILED', 'message' => 'Network Error' ];
        }
        else {
            return json_decode( $r );
        }
    }

}
