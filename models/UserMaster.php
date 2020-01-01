<?php

namespace app\models;

use Yii;
use app\models\StoreMaster;
use app\models\BrandMaster;
use app\models\UserAccess;
use app\models\RegionMaster;
/**
 * This is the model class for table "user_master".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $user_access
 * @property int $region_id
 * @property int $brand_id
 * @property int $store_id
 * @property string $created_on
 * @property string $flags
 */
class UserMaster extends \yii\db\ActiveRecord
{
    public $error;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'user_access', 'created_on'], 'required'],
            [['user_access', 'region_id', 'brand_id', 'store_id'], 'integer'],
            [['created_on'], 'safe'],
            [['email', 'password'], 'string', 'max' => 100],
            [['flags'], 'string', 'max' => 5],
            [['email'], 'unique','message' => '{attribute} is aleardy registered'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'user_access' => 'User Access',
            'region_id' => 'Region ID',
            'brand_id' => 'Brand ID',
            'store_id' => 'Store ID',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }

    public function getStore()
    {
        return $this->hasOne(StoreMaster::className(), ['id'=>'store_id']);
    }
    public function getBrand()
    {
        return $this->hasOne(BrandMaster::className(), ['id'=>'brand_id']);
    }

    public function getAccess()
    {
        return $this->hasOne(UserAccess::className(), ['id'=>'user_access']);
    }

    public function getRegion()
    {
        return $this->hasOne(RegionMaster::className(), ['id'=>'region_id']);
    }

}
