<?php


$url = "https://test.myfatoorah.com/pg/PayGatewayServiceV2.asmx";

$post_string = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <PaymentRequest xmlns="http://tempuri.org/">
      <req>
        <CustomerDC>
          <Name>Ahmed Hafez</Name>
          <Email>test@myfatoorah.com</Email>
          <Mobile>4444</Mobile>
          <Gender></Gender>
          <DOB></DOB>
          <civil_id></civil_id>
          <Area></Area>
          <Block></Block>
          <Street></Street>
          <Avenue></Avenue>
          <Building></Building>
          <Floor></Floor>
          <Apartment></Apartment>
        </CustomerDC>
        <MerchantDC>
          <merchant_code>999999</merchant_code>
          <merchant_username>testapi@myfatoorah.com</merchant_username>
          <merchant_password>E55D0</merchant_password>
          <merchant_ReferenceID>1256578</merchant_ReferenceID>
          <ReturnURL>https://www.myfatoorah.com</ReturnURL>
          <merchant_error_url>https://www.myfatoorah.com/error</merchant_error_url>
          <udf1></udf1>
          <udf2></udf2>
          <udf3></udf3>
          <udf4></udf4>
          <udf5></udf5>
        </MerchantDC>
        <lstProductDC>
          <ProductDC>
            <product_name>BMW</product_name>
            <unitPrice>500</unitPrice>
            <qty>3</qty>
          </ProductDC>
           <ProductDC>
            <product_name>BMW 2</product_name>
            <unitPrice>800</unitPrice>
            <qty>2</qty>
          </ProductDC>
          
        </lstProductDC>
        <totalDC>
          <subtotal>2400</subtotal>
        </totalDC>
        <paymentModeDC>
          <paymentMode>SADAD</paymentMode>
        </paymentModeDC>
        <paymentCurrencyDC>
          <paymentCurrrency>KSA</paymentCurrrency>
        </paymentCurrencyDC>
      </req>
    </PaymentRequest>
  </soap:Body>
</soap:Envelope>';
             
        
$soap_do = curl_init();

curl_setopt($soap_do, CURLOPT_URL,$url );

curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);

curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);

curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );

curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($soap_do, CURLOPT_POST, true );

curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);

curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($post_string) ));

curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password); 
            

curl_setopt($soap_do, CURLOPT_HTTPHEADER, array(

'Content-type: text/xml'

));

$result = curl_exec($soap_do);
         //echo $result;
$err = curl_error($soap_do);

 

$file_contents = htmlspecialchars(curl_exec($soap_do));
        
        curl_close($soap_do);
        
        $doc = new DOMDocument();
        
        if ($doc != null) {
            $doc->loadXML(html_entity_decode($file_contents));
            
            $ResponseCode = $doc->getElementsByTagName("ResponseCode");
            $ResponseCode = $ResponseCode->item(0)->nodeValue;
                       
            $paymentUrl = $doc->getElementsByTagName("paymentURL");
            $paymentUrl = $paymentUrl->item(0)->nodeValue;
            
            $referenceID = $doc->getElementsByTagName("referenceID");
            $referenceID = $referenceID->item(0)->nodeValue;
            
            $ResponseMessage = $doc->getElementsByTagName("ResponseMessage");
            $ResponseMessage = $ResponseMessage->item(0)->nodeValue;
        } else {
            echo "Error connecting server.....";
            die;
        }

        
        
         if ($ResponseCode == 0) {
                //  $referenceID
               header("location: https://test.myfatoorah.com/pg/payment_invoice.aspx?id=".$referenceID);
      
        } else {
            echo "this is error page";
         }

   
    //https://test.myfatoorah.com/pg/payment_invoice.aspx?id=




?>
