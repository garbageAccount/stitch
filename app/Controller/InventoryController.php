<?php
App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');

/**
 * Inventory Controller
 *
 */
class InventoryController extends AppController
{

    var $uses = ["SoftInventoryEvent"];
    var $components = ["CurlHelper", "Security", 'ShopifyChannel', 'VendChannel', 'Security'];

    public function beforeFilter(){
        $this->Components->disable('Security');
    }

    function updateAllInventories()
    {
        //most of this logic should be moved out of a controller, fat controller is kinda old. That way this could
        // be triggered by a cron or from many other sources

        $aChannelLookup = [1 => $this->ShopifyChannel, 2 => $this->VendChannel]; //

        //probably worth investigating this query-execution-plan a little more to ensure it runs as intended (< log(softInventoryEvent))
        $aUserChannels = $this->SoftInventoryEvent->query("select * from userChannels as UC left join (SELECT MAX(id) as mid, user_channel_id  from softInventoryEvent GROUP BY user_channel_id) as SIE on UC.id = SIE.user_channel_id");

        foreach ($aUserChannels as $aUserChannel) {
            $aUserChannel = $aUserChannel['UC'];
            /* Password should be symmetrically encrypted, but I'm not in the mood to screw with mcrypt rigth now*/
            $iChannelId = expect($aUserChannel, 'channel_id');
            $sShopName = expect($aUserChannel, 'shop_channel_identifier');
            $sApiKey = expect($aUserChannel, 'shop_api_key');
            $sPassword = expect($aUserChannel, 'shop_api_password');
            $iMaxPreviousId = ifset($aUserChannel, 'mid', 0);

            $oChannel = expect($aChannelLookup, $iChannelId);
            $aNewOrders = $oChannel->getAllNewOrders($iMaxPreviousId, $sShopName, $sApiKey, $sPassword);
            foreach ($aNewOrders as $aNewOrder) {
                $aNewOrder['user_channel_id'] = expect($aUserChannel, 'id');
                $aNewOrder['user_id'] = expect($aUserChannel, 'user_id');
                $this->SoftInventoryEvent->create();
                $this->SoftInventoryEvent->save($aNewOrder);
            }
        }
        echo json_encode(['success' => true]);
    }


}
