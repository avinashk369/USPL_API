<?php

namespace app\models;

use Yii;
use app\models\StoreMaster;

/**
 * This is the model class for table "image_master".
 *
 * @property int $id
 * @property string $image_path
 * @property int $owner_id
 * @property int $user_access
 * @property int $store_id
 * @property string $created_on
 * @property string $flags
 */
class ImageMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path', 'owner_id', 'user_access', 'store_id', 'created_on'], 'required'],
            [['owner_id', 'user_access', 'store_id'], 'integer'],
            [['created_on'], 'safe'],
            [['image_path'], 'string', 'max' => 50],
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
            'image_path' => 'Image Path',
            'owner_id' => 'Owner ID',
            'user_access' => 'User Access',
            'store_id' => 'Store ID',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }

    public function getStore()
    {
        return $this->hasOne(StoreMaster::className(), ['id'=>'store_id']);
    }
}
