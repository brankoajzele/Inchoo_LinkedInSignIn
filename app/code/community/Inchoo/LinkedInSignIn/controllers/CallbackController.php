<?php

/**
 * @author Branko Ajzele <ajzele@gmail.com>
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Inchoo_LinkedInSignIn_CallbackController extends Mage_Core_Controller_Front_Action 
{
    public function loginAction() 
    {
        $helper = Mage::helper('inchoo_linkedinsignin');
        echo $this->getRequest()->getParam('id');
        
        $linkedInID = $this->getRequest()->getParam('id', false);
        $linkedInFirstname = $this->getRequest()->getParam('firstname', '');
        $linkedInLastname = $this->getRequest()->getParam('lastname', '');
        
        if (!$linkedInID) {
            exit('');
        }
        
        
        $customer = Mage::getModel('customer/customer')->getCollection()
                        ->addAttributeToFilter('website_id', array('eq'=>Mage::app()->getWebsite()->getId()))
                        ->addAttributeToFilter('inchoo_linkedinsignin_user', array('eq'=>$linkedInID))
                        ->getFirstItem();
        
        $existingCustomer = true;
        $email = '';

        if(!$customer->getId()) {
            $existingCustomer = false;
            $email = sprintf('%s-%s-%s@user-linkedin.com', $linkedInFirstname, $linkedInLastname, $linkedInID);
            $customer->setEmail($email);
            $customer->setFirstname($linkedInFirstname);
            $customer->setLastname($linkedInLastname);
            $customer->setPassword($customer->generatePassword());
            $customer->setData('inchoo_linkedinsignin_user', $linkedInID);

            try {
                $customer->save();
                //$customer->sendNewAccountEmail('registered', '', Mage::app()->getStore()->getId());
            } catch (Exception $e) {
                Mage::logException($e);
            }               
        }

        if ($customer->getId()) {
            Mage::getSingleton('customer/session')->loginById($customer->getId());
        }  
        
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            Mage::getSingleton('core/session')->addError($helper->__('Authorization trough LinkedIn has failed. Please try again later or login directly.'));
            $this->getResponse()->setHeader('HTTP/1.1','401 Unauthorized');
        } else {
            Mage::getSingleton('core/session')->addSuccess($helper->__('Successfully logged in through LinkedIn.'));
            
            if (!$existingCustomer) {
                Mage::getSingleton('core/session')->addNotice($helper->__('Please be sure to edit your email address %s.', $email));
            }
        }
    }
    
    public function logoutAction()
    {
        $this->_redirect('customer/account/logout');   
    }
}