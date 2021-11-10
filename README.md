
# Monacoin-OP_RETURN-training
モナコインのOP_RETURNの送信手順

## 目的:
ブロックチェーンネットワークを活用したアプリケーションを作成するための練習。

仕組みや機能を理解する事による応用技術の妄想。

 - ブロックチェーンに書き込まれたデータは短時間で世界中のコンピュータに同期する。
 - データは時間軸で管理され、永久不滅、削除や改竄は不可能。
 - 誰が飽きても死んでも廃業しても興味を持つ者がいる限りブロックチェーンは止まらない。
 - それらは全自動で絶対的に保障される。

これらの特徴を活かしたサービスをいろいろ作って遊ぶ(目標)。

## 事前準備 - 1
Monacoin Projectからウォレットをインストールする。

https://monacoin.org/

Monacoin Coreが起動したら同期するまでしばらく待つ。

monacoin.conf に次の設定を入れて再起動する。
|monacoin.conf|説明|
|--|--|
|server=1             |JSON RPCサーバ機能有効|
|rpcuser=mona         |適当なユーザー名|
|rpcpassword=1234     |適当なパスワード
|rpcport=7985         |適当(未使用)なポート番号|
|rpcallowip=127.0.0.1 |アクセス許可IP|
MONAコインを掘るか買うかして若干入れる。

## 事前準備 - 2
PHPの実行環境をインストールする。

https://www.php.net/

インターネット利用者なら誰でもできて当然なので詳細は省く。

## OP_RETURN送受信の方法
readme_transmit.md と readme_recive.md を参照

