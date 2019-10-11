<?php

namespace vergelijkgroep\JsonBehavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @property ActiveRecord $owner
 */
class JsonBehavior extends Behavior
{
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var null|mixed
     */
    public $emptyValue = null;

    /**
     * @var bool
     */
    public $asArray = false;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => function () {
                $this->decode();
            },
            ActiveRecord::EVENT_BEFORE_INSERT => function () {
                $this->encode();
            },
            ActiveRecord::EVENT_BEFORE_UPDATE => function () {
                $this->encode();
            },
            ActiveRecord::EVENT_AFTER_INSERT => function () {
                $this->decode();
            },
            ActiveRecord::EVENT_AFTER_UPDATE => function () {
                $this->decode();
            },
        ];
    }

    /**
     * Decode all $attributes. If an attribute is null after decoding, set it to $emptyValue instead.
     */
    protected function decode()
    {
        foreach ($this->attributes as $attribute) {
            $value = $this->owner->getAttribute($attribute);
            $this->owner->setAttribute($attribute, json_decode($value, $this->asArray) ?: $this->emptyValue);
        }
    }

    /**
     * Encode all $attributes.
     */
    protected function encode()
    {
        foreach ($this->attributes as $attribute) {
            $field = $this->owner->getAttribute($attribute);
            $this->owner->setAttribute($attribute, json_encode($field));
        }
    }
}
