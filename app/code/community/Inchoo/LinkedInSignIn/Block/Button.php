<?php
/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_LinkedInSignIn_Block_Button extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('inchoo/linkedinsignin/button.phtml');
    }
    
    protected function _toHtml()
    {
        if (!$this->helper('inchoo_linkedinsignin')->isModuleOutputEnabled()) {
            return '';
        }
        
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            return '';
        }

        return parent::_toHtml();
    }
    
    /**
     * Used for All Files /app/code/core/Mage/Page/Block/Template/Links.php -> addLinkBlock()
     * @return int
     */
    public function getPosition()
    {
        return $this->helper('inchoo_linkedinsignin')->getButtonPosition();
    }
}