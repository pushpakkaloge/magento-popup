<?php

namespace PushpakMods\Popup\Api;

use PushpakMods\Popup\Api\Data\PopupInterface;

interface PopupManagementInterface {



    public function getApplicablePopup():PopupInterface;


}

