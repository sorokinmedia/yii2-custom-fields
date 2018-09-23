# yii2-custom-fields

***
Sorokin.Media repository
***

Компонент для работы с `custom_fields` внутри любой AR модели. Работа с json-полем в БД.

***
### Описание модели CustomFieldModel (кастомное поле)
атрибуты:
+ `id` - id, уникальный итератор - `integer`
+ `name` - название поля - `string(255)`
+ `value` - значение поля - `string`
+ `number` - порядковый номер для Drag'n'Drop - `integer`

### Общий принцип работы
В атрибут AR модели пишем массив объектов `CustomFieldModel`, в `json` формате. Вся работа с этим полем организована в `CustomFieldHelper`.

#### Описание хелпера CustomFieldHelper

Содержит ряд вспомогательных методов для работы с атрибутом `custom_fields`. Все методы в хелпере статические.

+ `public static function getMaxId(array $custom_fields = null) : int` - получает текущий максимальный `ID` в массиве полей. Если атрибут `custom_fields` пуст(`null`), вернет `0`.
+ `public static function addCustomFields(array $custom_fields_array, array $custom_fields = null) : array` - добавляет массив кастомных полей в атрибут `custom_fields`. Автоматически проставляет `id` внутри моделей `CustomFieldModel`. Первый параметр - массив полей, которые нужно добавить. Вторым параметров принимает уже существующие поля, к которым нужно добавить поля из первого параметра.
+ `public static function updateCustomField(array $custom_field_array, array $custom_fields) : array` - обновляет поле внутри массива полей `custom_fields`. Ищет по `id` элемента и заменяет. Первый параметр - новое поле, второй параметр - уже существующие поля.
+ `public static function deleteCustomField(int $id, array $custom_fields) : array` - удаляет модель `CustomFieldModel` внутри массива полей `custom_fields`. Ищет по `id`. Первый параметр - `id` элемента, который нужно удалить, второй параметр - уже существующие поля.