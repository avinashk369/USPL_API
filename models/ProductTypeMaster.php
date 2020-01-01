<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_type_master".
 *
 * @property int $id
 * @property string $name
 * @property string $created_on
 * @property string $flags
 */
class ProductTypeMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_on'], 'required'],
            [['created_on'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['flags'], 'string', 'max' => 5],
            [['name'], 'unique'],
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
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
