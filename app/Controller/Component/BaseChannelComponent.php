<?php


Abstract class BaseChannelComponent extends Component {

    public function getAllNewOrders($tSince = null, $sShopName, $sApiKey, $sPassword){
        return array_map(getMethodOffObject($this, "convertToStandardFormat"), $this->grabOrders($tSince) );
    }

    private function convertToStandardFormat($aOrderRow){

    }

    private function grabOrders($iSince, $sShopName, $sApiKey, $sPassword){
    }
} 
