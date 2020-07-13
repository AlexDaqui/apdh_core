<?php
/*
* Author: Alex Patricio Daqui Hernandez
* Web page: https://www.apdh.es
*/
class Apdh_Core_Helper_Data extends Mage_Core_Helper_Abstract
{
    public static $newUser = "https://www.apdh.es/api/magento/user";
    public static $versions = "https://www.apdh.es/api/magento";

    public function checkUser($email)
    {
        $params = array(
            "email" => $email,
            "modules" => $this->getModules(false),
            "sites" => $this->getSites(false),
        );

        return $this->sendInfo("GET", self::$newUser, $params);

    }

    public function getModules($array = true)
    {
        $modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
        $extensions = array();
        $names = array();

        foreach ($modules as $moduleName) {
            if (strstr($moduleName, 'Apdh_')) {
                $version = (string)Mage::getConfig()->getModuleConfig($moduleName)->version;
                $args = array(
                    "name" => $moduleName,
                    "version" => $version
                );

                $names[] = $moduleName;
                $extensions[] = $args;
            }
        }

        return ($array)?$extensions:implode(",", $names);
    }

    public function getSites($array = true)
    {
        $stores = Mage::app()->getStores();
        $sites = array();

        foreach ($stores as $store) {
            $url = Mage::getModel('core/url')->parseUrl(Mage::getStoreConfig('web/unsecure/base_url', $store->getId()));
            $sites[] = $url['host'];
        }

        return ($array)?$array:implode(",", $sites);
    }


    public function sendInfo($type, $url, $params)
    {


        try {
            $client = new Zend_Http_Client($url);
            $client->setHeaders('Content-Type', "application/json");

            if ($type == 'GET') {
                $client->setMethod(Zend_Http_Client::GET);
                $client->setParameterGet($params);
            } else {
                $client->setMethod(Zend_Http_Client::POST);
                $client->setParameterPost($params);
            }

            $response = $client->request();
            $responseBody = $response->getBody();
            $responseBody = json_decode($responseBody, true);
            return $responseBody;
        } catch (Exception $e){
            Mage::log("Exception:: ".$e->getMessage(), Zend_Log::ALERT, 'apdh.log', true);
        }
    }

    public function checkVersion($moduleName, $version)
    {
        $params = array(
            "code" => $moduleName,
            "version" => $version
        );

        return $this->sendInfo("GET", self::$versions, $params);
    }
}