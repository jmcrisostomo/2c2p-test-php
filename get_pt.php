 
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
        MERCHANTID: <input type="text" name="MERCHANTID" value="<?php echo isset($_POST['MERCHANTID']) ? $_POST['MERCHANTID'] : 'JT' ?>"><br>
        SECRETKEY: <input type="text" name="SECRETKEY" value="<?php echo isset($_POST['SECRETKEY']) ? $_POST['SECRETKEY'] : 'QEapqL2CigJEFGHIJKLMNO' ?>"><br> 
        invoiceNo: <input type="text" name="invoiceNo" value="<?php echo time(); ?>"><br>
        description: <input type="text" name="description" value="<?php echo isset($_POST['description']) ? $_POST['description'] : '2 days 1 night' ?>"><br>
        amount: <input type="text" name="amount" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : '000000001000' ?>"> 12 digit format<br>
        currencyCode: <input type="text" name="currencyCode" value="<?php echo isset($_POST['currencyCode']) ? $_POST['currencyCode'] : 'THB' ?>"> A3 format<br>
        paymentChannel: <input type="text" name="paymentChannel" value="<?php echo isset($_POST['paymentChannel']) ? $_POST['paymentChannel'] : 'CC,IPP,BANK' ?>"> multiple channels separated by comma<br>
        request3DS: <input type="text" name="request3DS" value="<?php echo isset($_POST['request3DS']) ? $_POST['request3DS'] : '' ?>"> Y=do 3ds, F=force 3ds, N=no 3ds, default=do 3ds<br>
        promotion: <input type="text" name="promotion" value="<?php echo isset($_POST['promotion']) ? $_POST['promotion'] : '' ?>"> promocode<br>
        tokenize: <input type="text" name="tokenize" value="<?php echo isset($_POST['tokenize']) ? $_POST['tokenize'] : '' ?>"> true/false<br>
        cardTokens: <input type="text" name="cardTokens" value="<?php echo isset($_POST['cardTokens']) ? $_POST['cardTokens'] : '' ?>"> multiple token separated by comma<br>
        tokenizeOnly: <input type="text" name="tokenizeOnly" value="<?php echo isset($_POST['tokenizeOnly']) ? $_POST['tokenizeOnly'] : '' ?>"> true/false<br>
        interestType: <input type="text" name="interestType" value="<?php echo isset($_POST['interestType']) ? $_POST['interestType'] : '' ?>"> A=all, C=customer, M=merchant<br>
        installmentPeriodFilter: <input type="text" name="installmentPeriodFilter" value="<?php echo isset($_POST['installmentPeriodFilter']) ? $_POST['installmentPeriodFilter'] : '' ?>"> multiple period separated by comma<br>
        productCode: <input type="text" name="productCode" value="<?php echo isset($_POST['productCode']) ? $_POST['productCode'] : '' ?>"><br>
        recurring: <input type="text" name="recurring" value=""> true/false<br>
        invoicePrefix: <input type="text" name="invoicePrefix" value=""><br>
        recurringAmount: <input type="text" name="recurringAmount" value=""><br>
        allowAccumulate: <input type="text" name="allowAccumulate" value=""><br>
        maxAccumulateAmount: <input type="text" name="maxAccumulateAmount" value=""><br>
        recurringInterval: <input type="text" name="recurringInterval" value=""><br>
        recurringCount: <input type="text" name="recurringCount" value=""><br> 
        chargeNextDate: <input type="text" name="chargeNextDate" value=""> ddMMyyyy<br> 
        chargeOnDate: <input type="text" name="chargeOnDate" value=""> ddMM<br> 
        paymentExpiry: <input type="text" name="paymentExpiry" value=""> yyyy-MM-dd<br> 
        userDefined1: <input type="text" name="userDefined1" value="<?php echo isset($_POST['userDefined1']) ? $_POST['userDefined1'] : 'data 1' ?>"><br> 
        userDefined2: <input type="text" name="userDefined2" value="<?php echo isset($_POST['userDefined2']) ? $_POST['userDefined2'] : 'data 2' ?>"><br> 
        userDefined3: <input type="text" name="userDefined3" value="<?php echo isset($_POST['userDefined3']) ? $_POST['userDefined3'] : 'data 3' ?>"><br> 
        userDefined4: <input type="text" name="userDefined4" value="<?php echo isset($_POST['userDefined4']) ? $_POST['userDefined4'] : 'data 4' ?>"><br> 
        userDefined5: <input type="text" name="userDefined5" value="<?php echo isset($_POST['userDefined5']) ? $_POST['userDefined5'] : 'data 5' ?>"><br> 
		paymentRouteID: <input type="text" name="paymentRouteID" value="<?php echo isset($_POST['paymentRouteID']) ? $_POST['paymentRouteID'] : '' ?>"><br>
        statementDescriptor: <input type="text" name="statementDescriptor" value="<?php echo isset($_POST['statementDescriptor']) ? $_POST['statementDescriptor'] : '' ?>"><br> 
        subMerchants: <input type="text" name="subMerchants" value="<?php echo isset($_POST['subMerchants']) ? $_POST['subMerchants'] : '' ?>"> place the whole json here<br> 
        frontendReturnUrl: <input type="text" name="frontendReturnUrl" value="<?php echo isset($_POST['frontendReturnUrl']) ? $_POST['frontendReturnUrl'] : 'https://demo2.2c2p.com/PaymentResult/StoredCardFrontendUrl.aspx' ?>"><br> 
        backendReturnUrl: <input type="text" name="backendReturnUrl" value="<?php echo isset($_POST['backendReturnUrl']) ? $_POST['backendReturnUrl'] : 'https://demo2.2c2p.com/PaymentResult/StoredCardBackendUrl.aspx' ?>"><br> 
        locale: <input type="text" name="locale" value="<?php echo isset($_POST['locale']) ? $_POST['locale'] : 'en' ?>"> en/th/jp/id/mm/my/...<br> 
        nonceStr: <input type="text" name="nonceStr" value="<?php echo time(); ?>"> dont need to change, it is suppose to be random<br>  
        <br> <input type="submit">
    </form>

<?php if(!empty($_POST)): ?>

<?php 
function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
} 


	include_once('HTTP.php');
	$http = new HTTP();
	$BASEURL = "https://sandbox-pgw.2c2p.com/payment/4.1/";
	$APIURL = "PaymentToken";
	   
echo "//========================= GET PAYMENT TOKEN ==============================//";
	//Merchant's account information
	$MERCHANTID = $_POST["MERCHANTID"];		//Get MerchantID when opening account with 2C2P
	$SECRETKEY = $_POST["SECRETKEY"];	//Get SecretKey from 2C2P PGW Dashboard
 
	//Request Information    
	$invoiceNo = $_POST["invoiceNo"];
	$description =$_POST["description"];
	$amount =$_POST["amount"];
	$currencyCode = $_POST["currencyCode"];
	$paymentChannel = array_filter(explode(",",$_POST["paymentChannel"])); 
	$request3DS = $_POST["request3DS"]; 
	$promotion= $_POST["promotion"]; 
	$tokenize= ($_POST["tokenize"]==="true"?true:false);
	$cardTokens= array_filter(explode(",",$_POST["cardTokens"]));
	$tokenizeOnly= ($_POST["tokenizeOnly"]==="true"?true:false);
	$interestType= $_POST["interestType"];
	$installmentPeriodFilter=array_filter(array_map('intval', explode(",",$_POST["installmentPeriodFilter"])));
	$productCode= $_POST["productCode"];
	$recurring= ($_POST["recurring"]==="true"?true:false);
	$invoicePrefix= $_POST["invoicePrefix"];
	$recurringAmount=$_POST["recurringAmount"];
	$allowAccumulate= $_POST["allowAccumulate"];
	$maxAccumulateAmount= $_POST["maxAccumulateAmount"];
	$recurringInterval= $_POST["recurringInterval"];
	$recurringCount= $_POST["recurringCount"];
	$chargeNextDate= $_POST["chargeNextDate"];
	$chargeOnDate= $_POST["chargeOnDate"];
	$paymentExpiry= $_POST["paymentExpiry"];
	$userDefined1= $_POST["userDefined1"];
	$userDefined2= $_POST["userDefined2"];
	$userDefined3= $_POST["userDefined3"];
	$userDefined4= $_POST["userDefined4"];
	$userDefined5= $_POST["userDefined5"];
	$paymentRouteID= $_POST["paymentRouteID"];
	$statementDescriptor= $_POST["statementDescriptor"];
	$subMerchants= $_POST["subMerchants"];
	$frontendReturnUrl = $_POST["frontendReturnUrl"];
	$backendReturnUrl = $_POST["backendReturnUrl"];
	$locale= $_POST["locale"]; 
	$nonceStr= $_POST["nonceStr"];
	
	$PT_dataArray = array(
	//MANDATORY PARAMS
	"merchantID" => $MERCHANTID,
	"invoiceNo" => $invoiceNo,
	"description" => $description,
	"amount" => $amount,
	"currencyCode" => $currencyCode,
	
	
	//OPTIONAL PARAMS
	"paymentChannel" => $paymentChannel,
	"request3DS" => $request3DS,
	"promotion" => $promotion,
	"tokenize" => $tokenize,
	"cardTokens" => $cardTokens,
	"tokenizeOnly" => $tokenizeOnly,
	"interestType" => $interestType,
	"installmentPeriodFilter" => $installmentPeriodFilter,
	"productCode" => $productCode,
	"recurring" => $recurring,
	"invoicePrefix" => $invoicePrefix,
	"recurringAmount" => $recurringAmount,
	"allowAccumulate" => $allowAccumulate,
	"maxAccumulateAmount" => $maxAccumulateAmount,
	"recurringInterval" => $recurringInterval,
	"recurringCount" => $recurringCount,
	"chargeNextDate" => $chargeNextDate,
	"chargeOnDate" => $chargeOnDate,
	"paymentExpiry" => $paymentExpiry,
	"userDefined1" => $userDefined1,
	"userDefined2" => $userDefined2,
	"userDefined3" => $userDefined3,
	"userDefined4" => $userDefined4,
	"userDefined5" => $userDefined5,
	"paymentRouteID" => $paymentRouteID,
	"statementDescriptor" => $statementDescriptor,
	"subMerchants" => $subMerchants,
	"locale" => $locale,
	"frontendReturnUrl" => $frontendReturnUrl,
	"backendReturnUrl" => $backendReturnUrl,

	//MANDATORY RANDOMIZER
	"nonceStr" => $nonceStr
	);                                         
	$PT_dataArray = (object) array_filter((array) $PT_dataArray);    
	$PT_data = json_encode($PT_dataArray);     
	echo "<br/>"; 
	echo "request PT_data: <br/><textarea style='width:100%;height:100px'>". $PT_data."</textarea>";  
	echo "<br/>"; 

	$PT_dataB64= base64url_encode($PT_data);

	//JWT header
	$PT_header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
	$PT_headerB64= base64url_encode($PT_header);

	$PT_signature= hash_hmac('sha256', $PT_headerB64 . "." . $PT_dataB64 ,$SECRETKEY, true); 
	$PT_signatureB64= base64url_encode($PT_signature);
 
	$PT_payloadData = $PT_headerB64 . "." . $PT_dataB64 . "." . $PT_signatureB64;
	$PT_payloadArray = array(
		"payload" => $PT_payloadData
	);
	$PT_payloadArray = (object) array_filter((array) $PT_payloadArray);                 
	$PT_payload = json_encode($PT_payloadArray);    
	echo "<br/>"; 
	echo "payload:<br/><textarea style='width:100%;height:40px'>". $PT_payload."</textarea>";    
	echo "<br/>"; 
 
	//Send request to 2C2P PGW and get back response
 	$PT_response = $http->post($BASEURL.$APIURL,$PT_payload);

	$PT_resData = json_decode($PT_response);
	$PT_resPayload = json_decode(base64_decode($PT_resData->{"payload"}));

	echo "<br/>"; 
	echo "RESPONSE:<br/><textarea style='width:100%;height:80px'>". base64_decode($PT_resData->{"payload"})."</textarea>"; 
	echo "<br/>";
	 
	echo "//========================= END OF GET PAYMENT TOKEN ==============================//";



?>  
<?php endif; ?>