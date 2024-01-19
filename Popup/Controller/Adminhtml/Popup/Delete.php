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

class Delete extends Action{

    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly PopupRepositoryInterface $popupRepository
    ){
        parent::__construct($context);
    }

    public function execute():ResultInterface{
        
            $popupId = (int)$this->getRequest()->getParam('popup_id',0);
            
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            if(!$popupId){
                $this->messageManager->addWarningMessage(__('The popup with provided id was not found. 1'));
                return $result->setPath('pushpakmods_popup/popup/index');
            }

            try{
                $popup = $this->popupRepository->getById($popupId);

                if(!$popup->getPopupId()){
                    $this->messageManager->addWarningMessage(__('The popup with provided id was not found. 2'));
                }else{
                    $this->popupRepository->delete($popup);
                    $this->messageManager->addSuccessMessage(__('A total of %1 records has been deleted.'));
                }

            }catch(\Throwable $exception){
                $this->messageManager->addErrorMessage(__('Something went wrong while processing the operation.'));
            }
            
            
           return $result->setPath('pushpakmods_popup/popup/index'); 
    }
}