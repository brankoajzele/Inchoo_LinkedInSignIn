<?php
/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_LinkedInSignIn_Helper_Data extends Mage_Core_Helper_Data 
{
    const CONFIG_XML_PATH_SETTINGS_ACTIVE = 'inchoo_linkedinsignin/settings/active';
    const CONFIG_XML_PATH_SETTINGS_API_KEY = 'inchoo_linkedinsignin/settings/api_key';
    const CONFIG_XML_PATH_SETTINGS_PLATFORM_JS = 'inchoo_linkedinsignin/settings/platform_js';
    const CONFIG_XML_PATH_SETTINGS_BUTTON_POSITION = 'inchoo_linkedinsignin/settings/button_position';
    
    public function isModuleEnabled($moduleName = null)
    {
        if (Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_ACTIVE) == '0') {
            return false;
        }
        
        return parent::isModuleEnabled($moduleName = null);
    }
    
    public function isModuleOutputEnabled($moduleName = null)
    {        
        $apiKey = $this->getApiKey();
        
        if (empty($apiKey)) {
            return false;
        }

        return parent::isModuleOutputEnabled($moduleName);
    }   
    
    public function getApiKey()
    {
        return trim(Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_API_KEY));
    }
    
    public function getPlatformJs()
    {
        return Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_PLATFORM_JS);
    }    
    
    public function getButtonPosition()
    {
        return (int)Mage::getStoreConfig(self::CONFIG_XML_PATH_SETTINGS_BUTTON_POSITION);
    }    
    
    public function getLoginUrl()
    {
        return Mage::getUrl('linkedinsignin/callback/login');
    }
    
    public function getLogoutUrl()
    {
        return Mage::getUrl('linkedinsignin/callback/logout');
    }
}
