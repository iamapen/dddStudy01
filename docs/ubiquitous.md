# ユビキタス言語

## 商品系
- 商品: Item
  - 販売する商品
  - 商品ID、商品名、商品価格、在庫 を持つ
- 商品ID: ItemId
  - 商品を識別するコード
  - 商品ごとに一意
- 商品名: ItemName
  - 商品の名称
- 商品価格: ItemPrice
  - 商品の販売価格。0以上のｆｆ整数。
- 在庫: ItemStock
  - 商品の在庫数。0以上の整数。

## カート系
- カート: Cart
  - 購入する商品を一時格納する入れ物
  - カート要素を複数持つ
- カート要素: CartElement
  - カートに格納されている要素
  - 商品名と商品個数を属性に持つ
- 商品個数: ItemCount
  - 商品の個数。0以上の整数。
- カートに商品を入れる: AddItemToCart
  - カートに商品を入れること。
  - 商品と商品個数を与える。
  - 商品個数を商品在庫以下である必要がある。

