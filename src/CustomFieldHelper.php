<?php
namespace sorokinmedia\custom_fields;

use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Class CustomFieldHelper
 * @package sorokinmedia\custom_fields
 *
 * хелпер для работы с кастомными полями
 */
class CustomFieldHelper
{
    /**
     * получить значение текущего максимального id в массиве
     * @param array|null $custom_fields
     * @return int
     */
    public static function getMaxId(array $custom_fields = null) : int
    {
        if (is_null($custom_fields)){
            return 0;
        }
        $array = json_decode(json_encode($custom_fields), true);
        if (empty($array)){
            return 0;
        }
        $max = max(ArrayHelper::getColumn($array, 'id'));
        return $max;
    }

    /**
     * добавить кастомные поля
     * если полей нет, просто добавляет
     * если поля есть, мерджит с теми что были + проставляет итерируемые id
     * @param array $custom_fields_array
     * @param array|null $custom_fields
     * @return array
     * @throws Exception
     */
    public static function addCustomFields(array $custom_fields_array, array $custom_fields = null) : array
    {
        $nextId = static::getMaxId($custom_fields); // получим значение текущего максимального id
        foreach ($custom_fields_array as $key => $item){ // переберем массив новых полей и сформируем модели + проставим ID
            $custom_fields_array[$key] = new CustomFieldModel([
                'id' => $key + 1 + $nextId,
                'name' => $item['name'],
                'value' => $item['value'],
                'number' => $item['number']
            ]);
            if (!$custom_fields_array[$key]->validate()){
                throw new Exception(\Yii::t('app', 'Поле не прошло валидацию'));
            }
        }
        if ($nextId > 0){ // если поля уже были, то смерджим с ними
            $custom_fields_array = array_merge($custom_fields, $custom_fields_array);
        }
        return $custom_fields_array;
    }

    /**
     * находит нужное поле и обновляет его в массиве кастомных полей
     * @param array $custom_field_array
     * @param array $custom_fields
     * @return array
     * @throws Exception
     */
    public static function updateCustomField(array $custom_field_array, array $custom_fields) : array
    {
        // найдем элемент по ключу, который нужно обновить
        $key = array_search($custom_field_array['id'], array_column($custom_fields, 'id'));
        $custom_fields[$key] = new CustomFieldModel($custom_field_array);
        if (!$custom_fields[$key]->validate()){
            throw new Exception(\Yii::t('app', 'Поле не прошло валидацию'));
        }
        return $custom_fields;
    }

    /**
     * находит нужное поле и удаляет его по значению id
     * @param int $id
     * @param array $custom_fields
     * @return array
     */
    public static function deleteCustomField(int $id, array $custom_fields) : array
    {
        // найдем элемент по ключу, который нужно удалить
        $key = array_search($id, array_column($custom_fields, 'id'));
        unset($custom_fields[$key]); // удаление элемента
        return array_values($custom_fields); // возвращаем без обновления ключей внутри основного массива
    }
}