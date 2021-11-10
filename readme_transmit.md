# Monacoin-OP_RETURN-training (送信)
Monacoin Coreを操作してモナコインチェーンにテキストメッセージを送信する手順

## 概略
仕様

- 送信できるデータは80byteまでのバイナリ
- テキストエンコーディングはUTF-8(JSONの仕様による)
- SEGWITを使うとより大きなデータを一括で送れるらしいが難しいので一旦後回し

手順

 1. データをHEX文字列に変換する。16進数をテキスト表記した形式。
 1. listunspentでMonacoin Core内の未使用トランザクション(UTXO)を検索。
 1. マイニング手数料と送金額を計算する。
 1. createrawtransactionに、送金元UTXO、送金先アドレス、送信データを入れる。
 1. 得られたデータをsignrawtransactionwithwalletに入れるとMonacoin Core内で署名を追加してくれる。
 1. 署名されたデータをsendrawtransactionでネットワークに放流する。
 1. マイニングされるまで待つ。
 1. 完了

## 送信データの準備

## createrawtransaction

## signrawtransactionwithwallet

## sendrawtransaction


