<?php

namespace PushpakMods\Popup\Api;

use PushpakMods\Popup\Api\Data\PopupInterface;

interface PopupRepositoryInterface {

    public function save(PopupInterface $popup):void;

    public function delete(PopupInterface $popup):void;

    public function getById(int $popupId):PopupInterface;

}

