<?php

namespace PushpakMods\Popup\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use PushpakMods\Popup\Api\Data\PopupInterface;
use PushpakMods\Popup\Api\PopupManagementInterface;

class PopupViewModel implements ArgumentInterface{

    public function __construct(
        private readonly PopupManagementInterface $popupManagement,
    )
    {
        
    }

    public function getPopup():PopupInterface{
        return $this->popupManagement->getApplicablePopup();
    }
}