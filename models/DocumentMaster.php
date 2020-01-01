<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_master".
 *
 * @property int $id
 * @property int $owner_id
 * @property string $path
 * @property int $doc_type
 * @property string $created_on
 * @property string $flags
 */
class DocumentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id', 'path', 'doc_type', 'created_on'], 'required'],
            [['owner_id', 'doc_type'], 'integer'],
            [['created_on'], 'safe'],
            [['path'], 'string', 'max' => 100],
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
            'owner_id' => 'Owner ID',
            'path' => 'Path',
            'doc_type' => 'Doc Type',
            'created_on' => 'Created On',
            'flags' => 'Flags',
        ];
    }
}
