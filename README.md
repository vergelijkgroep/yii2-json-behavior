# Yii2 JSON attribute behavior

Automatically encode/decode attribute values in JSON via Yii2 Behavior.

## Install

Install via Composer:

```bash
composer require vergelijkgroep/yii2-json-behavior
```

or add

```bash
"vergelijkgroep/yii2-json-behavior" : "*"
```

to the `require` section of your `composer.json` file.

## Usage

### JsonBehavior

Configure your model:

```php
use vergelijkgroep\JsonBehavior\JsonBehavior;

class Item extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            [
                'class' => JsonBehavior::class,
                'attributes' => ['attribute1', 'attribute2'],
                'emptyValue' => 'empty_value', // optional
                'asArray' => true,  // optional
            ]
        ];
    }
}
```

The attributes will now automatically be encoded and decoded:

```php
$item = Item::findOne(1);
$item->attribute1['foo'] = 'bar';
$item->attribute2 = null;
$item->save(); // attribute1 will be encoded and saved as json

$item = Item::findOne(1);
echo $item->attribute1['foo']; // 'bar'
echo $item->attribute2; // 'empty_value' 
```


#### emptyValue

The `emptyValue` is the value of the attribute when its `null` after decoding from JSON. Default is `null`.

#### asArray

The `asArray` option defines the JSON decoding format, true for associative `array`, false for `object`. Default is false.


## License

[![MIT](https://img.shields.io/cocoapods/l/AFNetworking.svg?style=style&label=License&maxAge=2592000)](LICENSE)

This software is distributed under the MIT license.