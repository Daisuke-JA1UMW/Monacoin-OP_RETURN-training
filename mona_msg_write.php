<?php
//送信データ準備
	$send_data = $argv[1];	//コマンドライン引数から文字列を入力

	$send_data_hex = bin2hex($send_data);	//16進表記変換
	if(strlen($send_data_hex) > 80*2){	//データチェック
		printf("Error: Data size > 80byte");
		exit;
	}
	
	printf("Data: %s\n", $send_data);
	printf("Hex : %s\n\n", $send_data_hex);

//送信準備
	$coind = curl_init("http://mona:1234@127.0.0.1:7985");	//coindへの接続設定
	curl_setopt($coind, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($coind, CURLOPT_RETURNTRANSFER, true);

	$input_tx = get_input_tx();	//トランザクション入力データの取得
	$output_coin = array($input_tx["address"]=>round($input_tx["amount"] - 0.0001, 4));	//TX手数料を引いた釣銭を自分宛に送金、演算誤差が出るので対策で丸める
	$output_data = array("data"=>$send_data_hex);	//トランザクションに添付するOP_RETURNデータ

//トランザクション生成
	printf("Create Transaction...\n");
	$postdata = array("jsonrpc"=>"1.0", "id"=>"curltext", "method"=>"createrawtransaction", "params"=>array($input_tx["inputs"], array($output_coin, $output_data)));
	curl_setopt($coind, CURLOPT_POSTFIELDS, json_encode($postdata));
	$transaction_data = json_decode(curl_exec($coind), true); //var_dump($transaction_data);

//トランザクション署名
	printf("Sign Transaction...\n");
	$postdata = array("jsonrpc"=>"1.0", "id"=>"curltext", "method"=>"signrawtransactionwithwallet", "params"=>array($transaction_data["result"]));
	curl_setopt($coind, CURLOPT_POSTFIELDS, json_encode($postdata));
	$transaction_signed = json_decode(curl_exec($coind),true); //var_dump($transaction_signed);
	
//トランザクション送信
	printf("Send Transaction...\n");
	$postdata = array("jsonrpc"=>"1.0", "id"=>"curltext", "method"=>"sendrawtransaction", "params"=>array($transaction_signed["result"]["hex"]));
	curl_setopt($coind, CURLOPT_POSTFIELDS, json_encode($postdata));
	$transaction_sended = json_decode(curl_exec($coind),true); //var_dump($transaction_sended);

//完了したらトランザクションIDを表示
	printf("\nTransaction ID: %s", $transaction_sended["result"]);

	curl_close($coind);
	exit();

//入力用トランザクション検索
//引数 なし
//戻り値 代表アドレス(釣銭用)、UTXO残高、UTXO(createrawtransaction用のJSON形式)
function get_input_tx(){
	global $coind;

	curl_setopt($coind, CURLOPT_POSTFIELDS, '{"jsonrpc":"1.0","id":"curltext","method":"listunspent","params":[]}');
	$result = curl_exec($coind);
	$arr = json_decode($result,true);
	printf("UTXOs:\n");
	foreach($arr["result"] as $value){
		printf($value["address"]."\t".$value["txid"]."\t".$value["vout"]."\t".$value["amount"]."\n");
	}
	printf("\n");
	return array("address"=>$value["address"],"amount"=>$value["amount"], "inputs"=>array(array("txid"=>$value["txid"],"vout"=>$value["vout"])));
}

?>
