# Monacoin-OP_RETURN-training (送信)
Monacoin Coreを操作してモナコインチェーンにテキストメッセージを送信する手順

## 注意事項
ブロックチェーンに書き込んだデータは全て公開され、絶対に削除も編集もできません。個人情報や、他人の著作物を絶対に書き込まないでください。何をどうしようとも絶対に削除できませんし、ハッキング等の考えは一切通用しません。それは暗号通貨の価格が示す通り、絶対的にどうにもなりません。下記の手順を参考に何をやらかしたとしても当方は一切関知しません。

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


