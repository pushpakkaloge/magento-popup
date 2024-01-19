<?php

namespace PushpakMods\Popup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;
use PushpakMods\Popup\Api\Data\PopupInterface;
use PushpakMods\Popup\Api\PopupRepositoryInterface;
use PushpakMods\Popup\Model\ResourceModel\Popup\Collection;
use PushpakMods\Popup\Model\ResourceModel\Popup\CollectionFactory;

class InlineEdit extends Action{

    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly PopupRepositoryInterface $popupRepository
    ){
        parent::__construct($context);
    }

    public function execute():ResultInterface{
           
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $items = $this->getRequest()->getParam('items');
            $messages=[];
            $error=false;
            
            if(!count($items)){
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }else{
                foreach(array_keys($items) as $popupId){
                    try{
                        /** @var Popup $popup */
                        $popup = $this->popupRepository->getById((int) $popupId);
                        $popup->setData(array_merge($popup->getData(),$items[$popupId]));
                        $this->popupRepository->save($popup);
                    }catch(\Throwable $exception){
                        $messages[] = '[POPUP ID: '.$popupId.'] '.$exception->getMessage();
                        $error=true;
                    }
                }
            }

           return $result->setData(
            [
                'messages'=>$messages,
                'error'=>$error,
            ]
           ); 
    }
}