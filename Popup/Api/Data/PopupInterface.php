<?php

namespace PushpakMods\Popup\Api\Data;

interface PopupInterface{

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;
    public function getPopupId():int;
    public function setPopupId(int $popupId);
    public function getName():string;
    public function setName(string $name);
    public function getContent():string;
    public function setContent(string $content);
    public function getCreatedAt():string;
    public function setCreatedAt(string $content);
    public function getUpdatedAt():string;
    public function setUpdatedAt(string $content);
    public function getTimeout():int;
    public function setTimeout(int $content);
    public function setIsActive(int $status);
    public function getIsActive():int;
    
}