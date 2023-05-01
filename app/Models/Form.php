<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model {
    const FIELDS = array (
        'data' =>
            array (
                'fields' =>
                    array (
                        0 =>
                            array (
                                'id' => 1,
                                'data_type' => 'integer',
                                'slug' => 'select',
                                'label' => 'Вид объявления',
                                'element' =>
                                    array (
                                        'type' => 'select',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 12,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите вид объявления',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                        0 =>
                                            array (
                                                'value' => 1,
                                                'label' => 'Продаю личный автомобиль',
                                            ),
                                        1 =>
                                            array (
                                                'value' => 2,
                                                'label' => 'Автомобиль приобретён на продажу',
                                            ),
                                    ),
                            ),
                        1 =>
                            array (
                                'id' => 2,
                                'data_type' => 'array',
                                'slug' => 'images',
                                'label' => 'Фотографии',
                                'element' =>
                                    array (
                                        'type' => 'image_uploader',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'min' => 1,
                                                'max' => 20,
                                                'max_file_size' => 26214400,
                                                'size' =>
                                                    array (
                                                        'height' => 480,
                                                        'width' => 640,
                                                    ),
                                                'multiple' => false,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Загрузите хотя бы 1 фотографию',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'rule' => 'max',
                                                'type' => 'error',
                                                'message' => 'Не более :max_value изображений',
                                                'params' =>
                                                    array (
                                                        'max_value' => 20,
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                        2 =>
                            array (
                                'id' => 3,
                                'data_type' => 'string',
                                'slug' => 'input',
                                'label' => 'VIN или номер кузова',
                                'regex' => 'VIN',
                                'element' =>
                                    array (
                                        'type' => 'input',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => 'По VIN мы проверяем историю автомобиля в сервисе «Автотека». Проверенные машины вызывают больше доверия у покупателей и продаются быстрее.',
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 6,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите VIN или номер кузова',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                        3 =>
                            array (
                                'id' => 4,
                                'data_type' => 'integer',
                                'slug' => 'input',
                                'label' => 'Пробег',
                                'element' =>
                                    array (
                                        'type' => 'input',
                                        'layout' => 'vertical',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'addon' => 'км',
                                        'params' =>
                                            array (
                                                'width' => 4,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите пробег',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'rule' => 'number',
                                                'type' => 'warning',
                                                'message' => 'Правильно укажите пробег',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                        4 =>
                            array (
                                'id' => 5,
                                'data_type' => 'integer',
                                'slug' => 'radio',
                                'label' => 'Состояние',
                                'element' =>
                                    array (
                                        'type' => 'radio',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => 'Автомобиль битый, если он сейчас не на ходу или требует восстановления после ДТП. К битым не относятся машины со сколами, царапинами и небольшими вмятинами.',
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 4,
                                                'multiple' => false,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите состояние',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                        0 =>
                                            array (
                                                'value' => 3,
                                                'label' => 'Не битый',
                                            ),
                                        1 =>
                                            array (
                                                'value' => 4,
                                                'label' => 'Битый',
                                            ),
                                    ),
                            ),
                        5 =>
                            array (
                                'id' => 6,
                                'data_type' => 'integer',
                                'slug' => 'select',
                                'label' => 'ПТС',
                                'element' =>
                                    array (
                                        'type' => 'select',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => 'Бумажный паспорт может быть оригинальным или дубликатом. В дубликате будет отметка об этом. Электронные ПТС получают все новые авто с ноября 2020 года.',
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 4,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                    ),
                                'values' =>
                                    array (
                                        0 =>
                                            array (
                                                'value' => 5,
                                                'label' => 'Электронный',
                                            ),
                                        1 =>
                                            array (
                                                'value' => 6,
                                                'label' => 'Оригинал',
                                            ),
                                        2 =>
                                            array (
                                                'value' => 7,
                                                'label' => 'Дубликат',
                                            ),
                                    ),
                            ),
                        6 =>
                            array (
                                'id' => 7,
                                'data_type' => 'integer',
                                'slug' => 'radio',
                                'label' => 'Владельцев по ПТС',
                                'element' =>
                                    array (
                                        'type' => 'radio',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 4,
                                                'multiple' => false,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите кол-во владельцев по ПТС',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                        0 =>
                                            array (
                                                'value' => 8,
                                                'label' => '1',
                                            ),
                                        1 =>
                                            array (
                                                'value' => 9,
                                                'label' => '2',
                                            ),
                                        2 =>
                                            array (
                                                'value' => 10,
                                                'label' => '3',
                                            ),
                                        3 =>
                                            array (
                                                'value' => 11,
                                                'label' => '4+',
                                            ),
                                    ),
                            ),
                        7 =>
                            array (
                                'id' => 8,
                                'data_type' => 'array',
                                'slug' => 'checkbox',
                                'label' => 'Данные о ТО',
                                'element' =>
                                    array (
                                        'type' => 'checkbox',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                                'width' => 4,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                    ),
                                'values' =>
                                    array (
                                        0 =>
                                            array (
                                                'value' => 12,
                                                'label' => 'Есть сервисная книжка',
                                            ),
                                        1 =>
                                            array (
                                                'value' => 13,
                                                'label' => 'Обслуживался у дилера',
                                            ),
                                        2 =>
                                            array (
                                                'value' => 14,
                                                'label' => 'На гарантии',
                                            ),
                                    ),
                            ),
                        8 =>
                            array (
                                'id' => 9,
                                'data_type' => 'string',
                                'slug' => 'textarea',
                                'label' => 'Описание',
                                'element' =>
                                    array (
                                        'type' => 'textarea',
                                        'layout' => 'vertical',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Пожалуйста, заполните описание',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                        9 =>
                            array (
                                'id' => 10,
                                'data_type' => 'array',
                                'slug' => 'location',
                                'label' => 'Место осмотра',
                                'element' =>
                                    array (
                                        'type' => 'location',
                                        'layout' => 'vertical',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'params' =>
                                            array (
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Пожалуйста, укажите место осмотра',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                        10 =>
                            array (
                                'id' => 11,
                                'data_type' => 'integer',
                                'slug' => 'input',
                                'label' => 'Цена',
                                'element' =>
                                    array (
                                        'type' => 'input',
                                        'layout' => 'vertical',
                                        'label' =>
                                            array (
                                                'help' =>
                                                    array (
                                                        'text' => NULL,
                                                    ),
                                            ),
                                        'help' => NULL,
                                        'addon' => '₽',
                                        'params' =>
                                            array (
                                                'width' => 8,
                                            ),
                                    ),
                                'validation' =>
                                    array (
                                        0 =>
                                            array (
                                                'rule' => 'required',
                                                'type' => 'error',
                                                'message' => 'Укажите стоимость',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                        1 =>
                                            array (
                                                'rule' => 'number',
                                                'type' => 'warning',
                                                'message' => 'Правильно укажите стоимость',
                                                'params' =>
                                                    array (
                                                    ),
                                            ),
                                    ),
                                'values' =>
                                    array (
                                    ),
                            ),
                    )
            ),
    );
}
