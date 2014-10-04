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

    function executeJsonRequestFake(){

           $sResponse = ' {"order": {
                "buyer_accepts_marketing": false,
    "cancel_reason": "other",
    "cancelled_at": "2014-10-02T13:07:22-04:00",
    "cart_token": "68778783ad298f1c80c3bafcddeea02f",
    "checkout_token": null,
    "closed_at": null,
    "confirmed": false,
    "created_at": "2008-01-10T11:00:00-05:00",
    "currency": "USD",
    "email": "bob.norman@hostmail.com",
    "financial_status": "authorized",
    "fulfillment_status": null,
    "gateway": "authorize_net",
    "id": 450789469,
    "landing_site": "http://www.example.com?source=abc",
    "location_id": null,
    "name": "#1001",
    "note": null,
    "number": 1,
    "reference": "fhwdgads",
    "referring_site": "http://www.otherexample.com",
    "source_identifier": "fhwdgads",
    "source_name": "web",
    "source_url": null,
    "subtotal_price": "398.00",
    "taxes_included": false,
    "test": false,
    "token": "b1946ac92492d2347c6235b4d2611184",
    "total_discounts": "0.00",
    "total_line_items_price": "398.00",
    "total_price": "409.94",
    "total_price_usd": "409.94",
    "total_tax": "11.94",
    "total_weight": 0,
    "updated_at": "2014-10-02T13:07:22-04:00",
    "user_id": null,
    "browser_ip": null,
    "landing_site_ref": "abc",
    "order_number": 1001,
    "discount_codes": [
      {
          "code": "TENOFF",
        "amount": "10.00",
        "type": "percentage"
      }
    ],
    "note_attributes": [
      {
          "name": "custom engraving",
        "value": "Happy Birthday"
      },
      {
          "name": "colour",
        "value": "green"
      }
    ],
    "processing_method": "direct",
    "source": "browser",
    "checkout_id": 450789469,
    "tax_lines": [
      {
          "price": "11.94",
        "rate": 0.06,
        "title": "State Tax"
      }
    ],
    "tags": "",
    "line_items": [
      {
          "fulfillment_service": "manual",
        "fulfillment_status": null,
        "gift_card": false,
        "grams": 200,
        "id": 466157049,
        "price": "199.00",
        "product_id": 632910392,
        "quantity": 1,
        "requires_shipping": true,
        "sku": "IPOD2008GREEN",
        "taxable": true,
        "title": "IPod Nano - 8gb",
        "variant_id": 39072856,
        "variant_title": "green",
        "vendor": null,
        "name": "IPod Nano - 8gb - green",
        "variant_inventory_management": "shopify",
        "properties": [
          {
              "name": "Custom Engraving",
            "value": "Happy Birthday"
          }
        ],
        "product_exists": true,
        "fulfillable_quantity": 1,
        "tax_lines": [

      ]
      },
      {
          "fulfillment_service": "manual",
        "fulfillment_status": null,
        "gift_card": false,
        "grams": 200,
        "id": 518995019,
        "price": "199.00",
        "product_id": 632910392,
        "quantity": 1,
        "requires_shipping": true,
        "sku": "IPOD2008RED",
        "taxable": true,
        "title": "IPod Nano - 8gb",
        "variant_id": 49148385,
        "variant_title": "red",
        "vendor": null,
        "name": "IPod Nano - 8gb - red",
        "variant_inventory_management": "shopify",
        "properties": [

      ],
        "product_exists": true,
        "fulfillable_quantity": 1,
        "tax_lines": [

      ]
      },
      {
          "fulfillment_service": "manual",
        "fulfillment_status": null,
        "gift_card": false,
        "grams": 200,
        "id": 703073504,
        "price": "199.00",
        "product_id": 632910392,
        "quantity": 1,
        "requires_shipping": true,
        "sku": "IPOD2008BLACK",
        "taxable": true,
        "title": "IPod Nano - 8gb",
        "variant_id": 457924702,
        "variant_title": "black",
        "vendor": null,
        "name": "IPod Nano - 8gb - black",
        "variant_inventory_management": "shopify",
        "properties": [

      ],
        "product_exists": true,
        "fulfillable_quantity": 1,
        "tax_lines": [

      ]
      }
    ],
    "shipping_lines": [
      {
          "code": "Free Shipping",
        "price": "0.00",
        "source": "shopify",
        "title": "Free Shipping",
        "tax_lines": [

      ]
      }
    ],
    "billing_address": {
                    "address1": "Chestnut Street 92",
      "address2": "",
      "city": "Louisville",
      "company": null,
      "country": "United States",
      "first_name": "Bob",
      "last_name": "Norman",
      "latitude": 45.41634,
      "longitude": -75.6868,
      "phone": "555-625-1199",
      "province": "Kentucky",
      "zip": "40202",
      "name": "Bob Norman",
      "country_code": "US",
      "province_code": "KY"
    },
    "shipping_address": {
                    "address1": "Chestnut Street 92",
      "address2": "",
      "city": "Louisville",
      "company": null,
      "country": "United States",
      "first_name": "Bob",
      "last_name": "Norman",
      "latitude": 45.41634,
      "longitude": -75.6868,
      "phone": "555-625-1199",
      "province": "Kentucky",
      "zip": "40202",
      "name": "Bob Norman",
      "country_code": "US",
      "province_code": "KY"
    },
    "fulfillments": [
      {
          "created_at": "2014-10-02T13:07:19-04:00",
        "id": 255858046,
        "order_id": 450789469,
        "service": "manual",
        "status": "failure",
        "tracking_company": null,
        "updated_at": "2014-10-02T13:07:19-04:00",
        "tracking_number": "1Z2345",
        "tracking_numbers": [
          "1Z2345"
      ],
        "tracking_url": "http://wwwapps.ups.com/etracking/tracking.cgi?InquiryNumber1=1Z2345&TypeOfInquiryNumber=T&AcceptUPSLicenseAgreement=yes&submit=Track",
        "tracking_urls": [
          "http://wwwapps.ups.com/etracking/tracking.cgi?InquiryNumber1=1Z2345&TypeOfInquiryNumber=T&AcceptUPSLicenseAgreement=yes&submit=Track"
      ],
        "receipt": {
          "testcase": true,
          "authorization": "123456"
        },
        "line_items": [
          {
              "fulfillment_service": "manual",
            "fulfillment_status": null,
            "gift_card": false,
            "grams": 200,
            "id": 466157049,
            "price": "199.00",
            "product_id": 632910392,
            "quantity": 1,
            "requires_shipping": true,
            "sku": "IPOD2008GREEN",
            "taxable": true,
            "title": "IPod Nano - 8gb",
            "variant_id": 39072856,
            "variant_title": "green",
            "vendor": null,
            "name": "IPod Nano - 8gb - green",
            "variant_inventory_management": "shopify",
            "properties": [
              {
                  "name": "Custom Engraving",
                "value": "Happy Birthday"
              }
            ],
            "product_exists": true,
            "fulfillable_quantity": 1,
            "tax_lines": [

          ]
          }
        ]
      }
    ],
    "client_details": {
                    "accept_language": null,
      "browser_height": null,
      "browser_ip": "0.0.0.0",
      "browser_width": null,
      "session_hash": null,
      "user_agent": null
    },
    "refunds": [
      {
          "created_at": "2014-10-02T13:07:19-04:00",
        "id": 509562969,
        "note": "it broke during shipping",
        "order_id": 450789469,
        "restock": true,
        "user_id": 799407056,
        "refund_line_items": [
          {
              "id": 104689539,
            "line_item_id": 703073504,
            "quantity": 1,
            "line_item": {
              "fulfillment_service": "manual",
              "fulfillment_status": null,
              "gift_card": false,
              "grams": 200,
              "id": 703073504,
              "price": "199.00",
              "product_id": 632910392,
              "quantity": 1,
              "requires_shipping": true,
              "sku": "IPOD2008BLACK",
              "taxable": true,
              "title": "IPod Nano - 8gb",
              "variant_id": 457924702,
              "variant_title": "black",
              "vendor": null,
              "name": "IPod Nano - 8gb - black",
              "variant_inventory_management": "shopify",
              "properties": [

              ],
              "product_exists": true,
              "fulfillable_quantity": 1,
              "tax_lines": [

              ]
            }
          },
          {
              "id": 709875399,
            "line_item_id": 466157049,
            "quantity": 1,
            "line_item": {
              "fulfillment_service": "manual",
              "fulfillment_status": null,
              "gift_card": false,
              "grams": 200,
              "id": 466157049,
              "price": "199.00",
              "product_id": 632910392,
              "quantity": 1,
              "requires_shipping": true,
              "sku": "IPOD2008GREEN",
              "taxable": true,
              "title": "IPod Nano - 8gb",
              "variant_id": 39072856,
              "variant_title": "green",
              "vendor": null,
              "name": "IPod Nano - 8gb - green",
              "variant_inventory_management": "shopify",
              "properties": [
                {
                    "name": "Custom Engraving",
                  "value": "Happy Birthday"
                }
              ],
              "product_exists": true,
              "fulfillable_quantity": 1,
              "tax_lines": [

              ]
            }
          }
        ],
        "transactions": [
          {
              "amount": "209.00",
            "authorization": "authorization-key",
            "created_at": "2005-08-05T12:59:12-04:00",
            "currency": "USD",
            "gateway": "bogus",
            "id": 179259969,
            "kind": "refund",
            "location_id": null,
            "message": null,
            "order_id": 450789469,
            "parent_id": null,
            "source_name": "web",
            "status": "success",
            "test": false,
            "user_id": null,
            "device_id": null,
            "receipt": {}
          }
        ]
      }
    ],
    "payment_details": {
                    "avs_result_code": null,
      "credit_card_bin": null,
      "cvv_result_code": null,
      "credit_card_number": "•••• •••• •••• 4242",
      "credit_card_company": "Visa"
    },
    "customer": {
                    "accepts_marketing": false,
      "created_at": "2014-10-02T13:07:19-04:00",
      "email": "bob.norman@hostmail.com",
      "first_name": "Bob",
      "id": 207119551,
      "last_name": "Norman",
      "last_order_id": 450789469,
      "multipass_identifier": null,
      "note": null,
      "orders_count": 1,
      "state": "disabled",
      "total_spent": "200.94",
      "updated_at": "2014-10-02T13:07:22-04:00",
      "verified_email": true,
      "tags": "",
      "last_order_name": "#1001",
      "default_address": {
                        "address1": "Chestnut Street 92",
        "address2": "",
        "city": "Louisville",
        "company": null,
        "country": "United States",
        "first_name": null,
        "id": 207119551,
        "last_name": null,
        "phone": "555-625-1199",
        "province": "Kentucky",
        "zip": "40202",
        "name": "",
        "province_code": "KY",
        "country_code": "US",
        "country_name": "United States",
        "default": true
      }
    }
  }
}';
        return json_decode($sResponse, true);
    }
} 
