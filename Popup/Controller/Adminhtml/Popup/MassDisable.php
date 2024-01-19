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

class MassDisable extends Action{

    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly PopupRepositoryInterface $popupRepository
    ){
        parent::__construct($context);
    }

    public function execute():ResultInterface{
        
            try{
                $collection =  $this->filter->getCollection($this->collectionFactory->create());
                $collectionSize = $collection->getSize();

                /** @var PopupInterface  $popup */
                foreach($collection as $popup){
                    $popup->setIsActive(PopupInterface::STATUS_DISABLED);
                    $this->popupRepository->save($popup);
                }

            }catch(\Throwable $exception){
                $this->messageManager->addErrorMessage(__('Something went wrong while processing the operation.'));
            }
            
            
            $this->messageManager->addSuccessMessage(__('A total of %1 records have been disabled.',$collectionSize));
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $result->setPath('pushpakmods_popup/popup/index'); 
    }
}