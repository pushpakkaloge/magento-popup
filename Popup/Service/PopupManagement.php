<?php

namespace PushpakMods\Popup\Service;

use PushpakMods\Popup\Api\Data\PopupInterface;
use PushpakMods\Popup\Api\PopupManagementInterface;
use PushpakMods\Popup\Model\ResourceModel\Popup\Collection;
use PushpakMods\Popup\Model\ResourceModel\Popup\CollectionFactory;
use PushpakMods\Story22\Api\Data\PopupInterface as DataPopupInterface;

class PopupManagement implements PopupManagementInterface{

    public function __construct(
        private readonly CollectionFactory $collectionFactory
    )
    {
        
    }

    public function getApplicablePopup(): PopupInterface
    {
        $popup = $this->getCollection()->addFieldToFilter('is_active',PopupInterface::STATUS_ENABLED)
        ->addOrder('popup_id')->getFirstItem();

        return $popup;
    }

    private function getCollection():Collection{
        return $this->collectionFactory->create();
    }
}