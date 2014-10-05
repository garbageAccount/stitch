<?php

class CurlHelperComponent extends Component {

    const CURL_TIMEOUT = 3;//3 seconds, arbitrarily picked

    function executeJsonRequest(/*...*/){
        $sForwardedResult = call_user_func_array(getMethodOffObject($this, 'executeRequest'), func_get_args());//forward call
        return json_decode( $sForwardedResult , true);
    }

    function executeRequest($sVerb, $sUrl, $aGet, $aPost, $aBasicAuthentication = [], $aHeaders = []){

        if ($aBasicAuthentication){
            $sAuthString = $aBasicAuthentication['user'] . ':' . $aBasicAuthentication['password'];
            $aHeaders[] = "Authorization: Basic " . base64_encode($sAuthString);
        }

        $sUrl .= "?" . http_build_query($aGet);

        $oCurl = curl_init($sUrl);
        curl_setopt($oCurl, CURLOPT_CUSTOMREQUEST, $sVerb);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $aPost);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $aHeaders);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT , self::CURL_TIMEOUT);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, self::CURL_TIMEOUT); //timeout in seconds

        $sOutput = curl_exec($oCurl) or "FAIL";
        $sStatus = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);

        if ( curl_error($oCurl) ){
            throw new Exception(curl_error($oCurl));
        }
        curl_close($oCurl);
        return $sOutput;

    }
} 
