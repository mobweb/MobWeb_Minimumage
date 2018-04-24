<?php
/**
 * @author    Louis Bataillard <info@mobweb.ch>
 * @package    MobWeb_Minimumage
 * @copyright    Copyright (c) MobWeb GmbH (https://mobweb.ch)
 */
class MobWeb_Minimumage_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function customerSaveBefore($observer)
    {
        $customer = $observer->getCustomer();
        if ($customer && $customer instanceof Mage_Customer_Model_Customer) {
            $customerIsNew = $customer->isObjectNew();
            if ($customerIsNew) {
                $customerDob = $customer->getData('dob');
                if ($customerDob) {
                    $customerDob = strtotime($customerDob);
                    $customerDobPlus18Years = strtotime('+18 years', $customerDob);
                    if(time() < $customerDobPlus18Years)  {
                        $message = Mage::helper('mobweb_minimumage')->__('The minimum age is 18 years.');
                        Mage::throwException($message);
                    }
                }
            }
        }
    }
}