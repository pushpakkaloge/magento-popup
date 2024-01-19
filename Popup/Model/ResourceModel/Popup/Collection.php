<?php

namespace PushpakMods\Popup\Model\ResourceModel\Popup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use PushpakMods\Popup\Model\ResourceModel\Popup as PopupResource;
use PushpakMods\Popup\Model\Popup;

class Collection extends AbstractCollection{
    protected function _construct()
    {
        $this->_init(
            Popup::class,
            PopupResource::class
        );
    }
}