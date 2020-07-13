<?php
/*
* Author: Alex Patricio Daqui Hernandez
* Web page: https://www.apdh.es
*/
class Apdh_Core_Model_Backend_User extends Mage_Core_Model_Config_Data
{
    protected function _afterSave()
    {
        $value = $this->getValue();
        $oldValue = $this->getOldValue();
        $scope = $this->getScope();
        $scopeId = $this->getScopeId();

        if ((!empty($value) && empty($oldValue)) || (!empty($value) && ($value != $oldValue))) {
            if (!empty($value)) {
                $result = Mage::helper('apdh')->checkUser($value);
                try {
                    $key = $result['msg'];
                    $coreConfig = Mage::getModel('core/config');
                    $coreConfig->saveConfig('apdh_options/data/key', $key, $scope, $scopeId);
                    parent::_afterSave();
                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError('Error:: ' . $e->getMessage());
                }
            }
        }

        if (empty($value) && !empty($oldValue)) {
            try {
                $coreConfig = Mage::getModel('core/config');
                $coreConfig->deleteConfig('apdh_options/data/key', $scope, $scopeId);
                parent::_afterSave();
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Error:: ' . $e->getMessage());
            }
        }
    }
}