<?php

namespace Aquatic\ByDesign\SOAP;

use \SoapClient;

\ini_set("soap.wsdl_cache_enabled", "0");

abstract class API
{
    protected $_user;
    protected $_password;
    protected $_token;
    protected $_wsdl;
    protected $_soapInstance;

    public function __construct(string $user, string $password, string $wsdl)
    {
        $this->_user = $user;
        $this->_password = $password;
        $this->_wsdl = $wsdl;
    }

    public function setWSDL(string $wsdl)
    {
        $this->_wsdl = $wsdl;
    }

    public function send($method, array $data = [])
    {
        $credentials = [
            'Credentials' => [
                'Username' => $this->_user,
                'Password' => $this->_password,
                //'Token' => $this->_token,
            ],
        ];

        $soap = $this->_getSOAPClient();
        $data = array_merge($credentials, $data);
        $result = $soap->$method($data);

        return $result;
    }

    protected function _getSOAPClient(): SoapClient
    {
        if (!($this->_soapInstance instanceof SoapClient)) {
            $this->_soapInstance = new SoapClient($this->_wsdl, ['trace' => 1]);
        }

        return $this->_soapInstance;
    }
}
