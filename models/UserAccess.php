<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_access".
 *
 * @property int $id
 * @property string $access_name
 * @property string $created_on
 * @property string $flags
 */
class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_name', 'created_on'], 'required'],
            [['created_on'], 'safe'],
            [['access_name'], 'string', 'max' => 20],
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
            'access_name' => 'Access Name',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
