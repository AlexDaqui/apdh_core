<?php
/*
* Author: Alex Patricio Daqui Hernandez
* Web page: https://www.apdh.es
*/

class Apdh_Core_Block_Adminhtml_System_Config_Info
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = Mage::helper('apdh');
        $msg = $helper->__('I am working hard to build great extensions and provide excellent service to you.');

        $this->_element = $element;
        $html = "<div style='width:100%; margin:auto;overflow:hidden;padding: 10px;'>";
        $html .= "<div style='float:left;max-width: 15%'>
                    <img src='https://marketplace.magento.com/media/customer/MAG002816769/mm_avatar.jpg'
                    style='max-width: 80%'
                    title='Apdh'/></div>";
        $html .= "<div style='float:left;max-width: 80%; padding: 10px'>
                    <a href='https://www.apdh.es/' title='Apdh' target='blank'>Apdh.es</a>    
                    <p>$msg</p>";

        $html .= "<p><strong>".$helper->__('Extension Installed:')."</strong></p><ol>";

        foreach ($helper->getModules() as $module) {
            $html .= $this->_getFieldHtml($module);
        }

        $html .= "</ol>";
        $html .= "</div></div>";
        return $html;
    }


    protected function _getFieldHtml($module)
    {
        $checkVersion = Mage::helper('apdh')->checkVersion($module['name'], $module['version']);

        return "<li>".$checkVersion["msg"]."</li>";
    }
}