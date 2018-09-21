<?php
namespace sorokinmedia\custom_fields;

use yii\base\Model;

/**
 * Class CustomFieldModel
 * @package sorokinmedia\custom_fields
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $number
 *
 * модель для работы с кастомным полем
 * валидация и название атрибутов
 */
class CustomFieldModel extends Model
{
    public $id;
    public $name;
    public $value;
    public $number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['value'], 'string'],
            [['id', 'number'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Название поля'),
            'value' => \Yii::t('app', 'Значение поля'),
            'number' => \Yii::t('app', 'Порядок'),
        ];
    }
}