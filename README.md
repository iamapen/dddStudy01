# 概要
シンプルな「カートに商品を追加」をDDDで表現してみる

## 実行

1. `composer install`
2. [`unittest/fixtures/rdbSchema/createdb.sql`](unittest/fixtures/rdbSchema/createdb.sql) を参考にDBを用意する(MySQL)
3. [`phpunit.xml.template`](phpunit.xml.template) を参考に `phpunit.xml` を作り、DB関連の定数を正しく定義する
4. テストデータを投入する
```bash
php unittest/testRecordImport.php
```
5. シミュレーション実行する  
web-api は未作成なので、CLIからusecaseを実行するものを用意してある。
```bash
php testRun.php
```

## ディレクトリ構成

### プロダクトコード
```
Shop/
 |- Application/                Application層
 |   |- UseCases/                 usecase群
 |   |   |- AddItemToCart.php      「カートに入れる」usecase
 |- Domain/                     Domain層
 |   |- Exceptions/               例外群
 |   |- Models/                   ドメインモデル群
 |   |   |- Cart/                   カート系ドメインモデル群
 |   |   |- Item/                   商品系ドメインモデル群
 |- Infrastructure/             Infra層
 |   |- Repositories/             Repository群
 |   |   |- Domain/
testRun.php                     CLIからの実行用ランナ
```

### 非プロダクトコード
```
docs/                        documents
unittest/                    UT関連
  |- fixtures/                 テストデータ群
  |   |- rdbSchema/               MySQLのスキーマ定義DDL
  |   |- table/                   MySQLのテーブル用テストデータ
  |   |   |- *.tsv
  |   |- lib/                   UT用ライブラリ
  |   |- tests/                 phpunitテストケース群
  |   |- testRecordImport.php     テストデータ投入スクリプト
vendor/                      依存ライブラリ
phpunit.xml.template         phpunit.xml の雛型。copyして環境設定する。
```
