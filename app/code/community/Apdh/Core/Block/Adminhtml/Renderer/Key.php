<?php
/*
* Author: Alex Patricio Daqui Hernandez
* Web page: https://www.apdh.es
*/
class Apdh_Core_Block_Adminhtml_Renderer_Key extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml($element)
    {
        $element->setDisabled('readonly');
        return parent::_getElementHtml($element);
    }
}