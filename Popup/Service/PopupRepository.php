<?php

namespace PushpakMods\Popup\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use PushpakMods\Popup\Api\PopupRepositoryInterface;
use PushpakMods\Popup\Api\Data\PopupInterface;
use PushpakMods\Popup\Model\ResourceModel\Popup as PopupResource;
use PushpakMods\Popup\Model\PopupFactory;
use Magento\Framework\Exception\AlreadyExistsException;

class PopupRepository implements PopupRepositoryInterface{

    public function __construct(
        private readonly PopupResource $resource,
        private readonly PopupFactory $factory
    )
    {}
    public function save(PopupInterface $popup):void{
        $this->resource->save($popup);
    }

    public function delete(PopupInterface $popup):void{
        $this->resource->delete($popup);
    }

    public function getById(int $popupId):PopupInterface{
        $popup = $this->factory->create();
        $this->resource->load($popup,$popupId);  
        if(!$popup->getId()){
            throw new NoSuchEntityException(__('The popup with id %1 does not exist.',$popupId));
        } 

        return $popup;
    }
}