<?php

App::uses("BaseChannelComponent", "Controller/Component");

class ShopifyChannelComponent extends BaseChannelComponent {
    var $id = 1;

    public function getAllNewOrders($tSince = null, $sShopName, $sApiKey, $sPassword){
        $aInventoryChanges = $this->grabOrders($tSince, $sShopName, $sApiKey, $sPassword);
        /* We might here want to look for other events that are relevant (e.g. cancellations on orders, returns) */
        $aResults = $this->convertToStandardFormat($aInventoryChanges);
        return array_values($aResults);
    }

    private function convertToStandardFormat($aOrderRows){
        $aFormattedResults = [];

        foreach ($aOrderRows as $aOrderRow) {
            if (count($aOrderRow)) {
                $tBought = expect($aOrderRow, 'created_at');
                $aLineItems = expect($aOrderRow, 'line_items');

                foreach ($aLineItems as $aLineItem){
                    $sUniqueId = "Shopify:" . expect($aOrderRow, 'id') . '.' . expect($aLineItem, 'id');
                    $sSku = expect($aLineItem, 'sku');
                    $iIncrease = 0 - expect($aLineItem, 'quantity');

                    //probably better to use a class soon
                    $aFormattedResults[] = [
                        "occurred" => (new DateTime( $tBought))->format("Y-m-d H:i:s"),/*converts timezone to CA*/
                        "increase" => $iIncrease,
                        "SKU" => $sSku,
                        "unique_identifier" => $sUniqueId
                    ];
                }
            }
        }
        return $aFormattedResults;
    }

    private function grabOrders($iSince, $sShopName, $sApiKey, $sPassword){
        $sPath = "admin/orders.json";
        $aParams = [];

        if ($iSince) {
            $aParams[] = ["since_id" => $iSince];
        }
        return $this->curlShopify($sShopName, $sPath, $aParams, $sApiKey, $sPassword);
    }

    private function curlShopify($sShopName, $sPath, $aGetParams, $sApiKey, $sPassword){
        $this->CurlHelper = new CurlHelperComponent($this->_Collection);
        try {
            //should also strip non-alpha-numeric characters from shopName with a regex
            $sUrl = "https://$sShopName.myshopify.com/$sPath";
            return $this->CurlHelper->executeJsonRequest("GET", $sUrl, [], [], ["user" => $sApiKey, "password" => $sPassword ]);
        } catch (Exception $e) {
            //log this somewhere appropriate and continue
        }
        return [];
    }
} 
