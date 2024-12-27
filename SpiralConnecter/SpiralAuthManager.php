<?php

class SpiralAuthManager
{
    private $connection;
    private ?HttpRequestParameter $request = null;
    private string $myAreaTitle = '';

    public function __construct(?\SiLibrary\SpiralConnecter\SpiralConnecterInterface $connector = null)
    {
        if (is_null($connector)) {
            $this->connection = \SiLibrary\SpiralConnecter\SpiralWeb::getConnection();
        } else {
            $this->connection = $connector;
        }
        $this->request = new HttpRequestParameter();
    }

    public function setMyAreaTitle(string $myAreaTitle)
    {
        $this->myAreaTitle = $myAreaTitle;
        return $this;
    }

    public function login($id , $password = ''){
        $this->request->set('my_area_title', $this->myAreaTitle);
        $this->request->set('url_type', '2');
        $this->request->set('id', $id);
        $password && $this->request->set('password', $password);

        $xSpiralApiHeader = new \SiLibrary\SpiralConnecter\XSpiralApiHeaderObject('area', 'login');

        return $this->connection->request(
            $xSpiralApiHeader,
            $this->request
        );
    }

    public function logout(){
        $this->request->set('my_area_title', $this->myAreaTitle);
        $this->request->set('jsessionid', $_COOKIE['JSESSIONID']);

        $xSpiralApiHeader = new \SiLibrary\SpiralConnecter\XSpiralApiHeaderObject('area', 'logout');

        return $this->connection->request(
            $xSpiralApiHeader,
            $this->request
        );
    }
}
