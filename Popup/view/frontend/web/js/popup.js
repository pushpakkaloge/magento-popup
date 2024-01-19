define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'text!PushpakMods_Popup/template/popup.html',
    'mage/cookies',
],function($,model,template){
    'use strict';

    return function(settings){
        // console.log(settings);
        // const title = settings.title;
        const timeout = settings.timeout;
        const content = settings.content;
        const cookieName = 'pushpakmods_popup_shown';

        if($.mage.cookies.get(cookieName)){
            return;
        }
        // console.log(timeout);

        const options={
            type:'popup',
            responsive:true,
            autoOpen:true,
            modalClass:'pushpakmods_popup',
            popupTpl:template,
            closed:()=>{
                const date = new Date();
                const expMinutes = 10;
                date.setTime(date.getTime()+(expMinutes*60*100));
                $.mage.cookies.set(cookieName,'1',{expires:date});
            }
        };
        setTimeout(()=>{
            $('<div/>').html(content).modal(options);
        },timeout*1000);
    }
});