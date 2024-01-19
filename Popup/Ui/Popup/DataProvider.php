<?php

namespace PushpakMods\Popup\Ui\Popup;

use PushpakMods\Popup\Model\ResourceModel\Popup\Collection;
use PushpakMods\Popup\Model\ResourceModel\Popup\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    private array $loadedData=[];

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $blockCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData():array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \PushpakMods\Popup\Model\Popup $popup */
        foreach ($items as $popup) {
            $this->loadedData[$popup->getId()] = $popup->getData();
        }

        $data = $this->dataPersistor->get('pushpakmods_popup_popup');
        if (!empty($data)) {
            $popup = $this->collection->getNewEmptyItem();
            $popup->setData($data);
            $this->loadedData[$popup->getId()] = $popup->getData();
            $this->dataPersistor->clear('pushpakmods_popup_popup');
        }

        return $this->loadedData;
    }
}
