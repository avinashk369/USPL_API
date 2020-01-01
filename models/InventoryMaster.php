<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_master".
 *
 * @property int $id
 * @property string $in_stock_date
 * @property string $product_type
 * @property int $quantity_available
 * @property int $quantity_required
 * @property int $quantity_short
 * @property int $quantity_excess
 * @property int $channel_name
 * @property int $store_name
 * @property int $owner_id
 * @property string $created_on
 * @property string $flags
 */
class InventoryMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['in_stock_date', 'quantity_available', 'quantity_required', 'quantity_short', 'quantity_excess', 'store_name', 'owner_id', 'created_on'], 'required'],
            [['in_stock_date', 'created_on'], 'safe'],
            [['quantity_available', 'quantity_required', 'quantity_short', 'quantity_excess', 'product_type', 'owner_id'], 'integer'],
            [['store_name'], 'string', 'max' => 100],
            [['flags'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'in_stock_date' => 'In Stock Date',
            'product_type' => 'Product Type',
            'quantity_available' => 'Quantity Available',
            'quantity_required' => 'Quantity Required',
            'quantity_short' => 'Quantity Short',
            'quantity_excess' => 'Quantity Excess',
            'store_name' => 'Store Name',
            'owner_id' => 'Owner ID',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
