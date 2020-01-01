<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand_master".
 *
 * @property int $id
 * @property string $brand_name
 * @property string $created_on
 * @property string $flags
 */
class BrandMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_name', 'created_on'], 'required'],
            [['created_on'], 'safe'],
            [['brand_name'], 'string', 'max' => 50],
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
            'brand_name' => 'Brand Name',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
