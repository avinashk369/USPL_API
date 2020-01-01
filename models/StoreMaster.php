<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store_master".
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 * @property int $brand_id
 * @property string $wrogn
 * @property string $imara
 * @property string $ms_taken
 * @property string $created_on
 * @property string $flags
 */
class StoreMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'region_id', 'brand_id', 'wrogn', 'imara', 'ms_taken', 'created_on'], 'required'],
            [['region_id', 'brand_id'], 'integer'],
            [['created_on'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['wrogn', 'imara', 'ms_taken'], 'string', 'max' => 10],
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
            'name' => 'Name',
            'region_id' => 'Region ID',
            'brand_id' => 'Brand ID',
            'wrogn' => 'Wrogn',
            'imara' => 'Imara',
            'ms_taken' => 'Ms Taken',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
