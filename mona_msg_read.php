<?php
//受信準備
	$coind = curl_init("http://mona:1234@127.0.0.1:7985");	//coindへの接続設定
	curl_setopt($coind, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($coind, CURLOPT_RETURNTRANSFER, true);

	$block_number = 2491380;	//開始ブロック番号
	$block_number = 2493000;

while(1){

//ブロックハッシュ値読み取り、なかったらポーリング
	while(1){
		$postdata = array("jsonrpc"=>"1.0", "id"=>"curltext", "method"=>"getblockhash", "params"=>array($block_number));
		curl_setopt($coind, CURLOPT_POSTFIELDS, json_encode($postdata));
		$result = curl_exec($coind);
		$block_hash = json_decode($result,true); //var_dump($block_hash);
		if($block_hash["error"] == null){ break; }
		sleep(5);
	}
//	printf("%08d %s\n",$block_number, $block_hash["result"]);

//ブロックデータ読み取り
	$postdata = array("jsonrpc"=>"1.0", "id"=>"curltext", "method"=>"getblock", "params"=>array($block_hash["result"], 2));
	curl_setopt($coind, CURLOPT_POSTFIELDS, json_encode($postdata));
	$result = curl_exec($coind);
	$block_data = json_decode($result,true); //var_dump($block_data);
	
	printf("\n%s\tBlock:%08d\t%s\t\n", date("Y/m/d H:i:s",$block_data["result"]["time"]), $block_number, $block_hash["result"]);
	printf("\n");
	foreach($block_data["result"]["tx"] as $tx_data){
		foreach($tx_data["vout"] as $vout_data){
			if(preg_match("/^OP_RETURN /", $vout_data["scriptPubKey"]["asm"])){
				preg_match('/(?<=^OP_RETURN ).\S*/', $vout_data["scriptPubKey"]["asm"], $msg_text);	//データ抽出
				$msg_text = hex2bin($msg_text[0]);	//テキスト復元
				$msg_checkbin = "TXT";
				if(preg_match('/[\x00-\x1F\x7F]/', $msg_text)) $msg_checkbin = "BIN";	//バイナリ判定(データが短いので誤判定多い)
				$msg_text = preg_replace('/[\x00-\x1F\x7F]/','', $msg_text);	//バイナリが来るので制御コードの無害化
				printf("\t%s  %s  %s\n", $tx_data["txid"], $msg_checkbin, $msg_text);
			}
		}
	}
	$block_number++;
}

?>
