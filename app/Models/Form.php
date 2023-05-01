<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    public static function getForm1()
    {
        $path = base_path('resources/json/form1.json');
        $json = file_get_contents($path);
        $form = json_decode($json, true);
        $formMetaData = [];
        foreach($form['fieldsets'] as $fieldset){
            foreach($fieldset['fields'] as $field){
                array_push($formMetaData,$field['id']);
            }
        }
        return $formMetaData;
    }
    public static function getForm2()
    {
        $path = base_path('resources/json/form2.json');
        $json = file_get_contents($path);
        $form = json_decode($json, true);
        $formMetaData = [];
        foreach($form['fieldsets'] as $fieldset){
            foreach($fieldset['fields'] as $field){
                array_push($formMetaData,$field['id']);
            }
        }
        return $formMetaData;
    }
    const FIELDS = [
        'data' =>
            [
                'fields' =>
                    [
                        0  =>
                            [
                                'id'         => 1,
                                'data_type'  => 'integer',
                                'slug'       => 'select',
                                'label'      => 'Вид объявления',
                                'element'    =>
                                    [
                                        'type'   => 'select',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width' => 12,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите вид объявления',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                        0 =>
                                            [
                                                'value' => 1,
                                                'label' => 'Продаю личный автомобиль',
                                            ],
                                        1 =>
                                            [
                                                'value' => 2,
                                                'label' => 'Автомобиль приобретён на продажу',
                                            ],
                                    ],
                            ],
                        1  =>
                            [
                                'id'         => 2,
                                'data_type'  => 'array',
                                'slug'       => 'images',
                                'label'      => 'Фотографии',
                                'element'    =>
                                    [
                                        'type'   => 'image_uploader',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'min'           => 1,
                                                'max'           => 20,
                                                'max_file_size' => 26214400,
                                                'size'          =>
                                                    [
                                                        'height' => 480,
                                                        'width'  => 640,
                                                    ],
                                                'multiple'      => false,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Загрузите хотя бы 1 фотографию',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                        1 =>
                                            [
                                                'rule'    => 'max',
                                                'type'    => 'error',
                                                'message' => 'Не более :max_value изображений',
                                                'params'  =>
                                                    [
                                                        'max_value' => 20,
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                        2  =>
                            [
                                'id'         => 3,
                                'data_type'  => 'string',
                                'slug'       => 'input',
                                'label'      => 'VIN или номер кузова',
                                'regex'      => 'VIN',
                                'element'    =>
                                    [
                                        'type'   => 'input',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => 'По VIN мы проверяем историю автомобиля в сервисе «Автотека». Проверенные машины вызывают больше доверия у покупателей и продаются быстрее.',
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width' => 6,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите VIN или номер кузова',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                        3  =>
                            [
                                'id'         => 4,
                                'data_type'  => 'integer',
                                'slug'       => 'input',
                                'label'      => 'Пробег',
                                'element'    =>
                                    [
                                        'type'   => 'input',
                                        'layout' => 'vertical',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'addon'  => 'км',
                                        'params' =>
                                            [
                                                'width' => 4,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите пробег',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                        1 =>
                                            [
                                                'rule'    => 'number',
                                                'type'    => 'warning',
                                                'message' => 'Правильно укажите пробег',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                        4  =>
                            [
                                'id'         => 5,
                                'data_type'  => 'integer',
                                'slug'       => 'radio',
                                'label'      => 'Состояние',
                                'element'    =>
                                    [
                                        'type'   => 'radio',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => 'Автомобиль битый, если он сейчас не на ходу или требует восстановления после ДТП. К битым не относятся машины со сколами, царапинами и небольшими вмятинами.',
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width'    => 4,
                                                'multiple' => false,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите состояние',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                        0 =>
                                            [
                                                'value' => 3,
                                                'label' => 'Не битый',
                                            ],
                                        1 =>
                                            [
                                                'value' => 4,
                                                'label' => 'Битый',
                                            ],
                                    ],
                            ],
                        5  =>
                            [
                                'id'         => 6,
                                'data_type'  => 'integer',
                                'slug'       => 'select',
                                'label'      => 'ПТС',
                                'element'    =>
                                    [
                                        'type'   => 'select',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => 'Бумажный паспорт может быть оригинальным или дубликатом. В дубликате будет отметка об этом. Электронные ПТС получают все новые авто с ноября 2020 года.',
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width' => 4,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                    ],
                                'values'     =>
                                    [
                                        0 =>
                                            [
                                                'value' => 5,
                                                'label' => 'Электронный',
                                            ],
                                        1 =>
                                            [
                                                'value' => 6,
                                                'label' => 'Оригинал',
                                            ],
                                        2 =>
                                            [
                                                'value' => 7,
                                                'label' => 'Дубликат',
                                            ],
                                    ],
                            ],
                        6  =>
                            [
                                'id'         => 7,
                                'data_type'  => 'integer',
                                'slug'       => 'radio',
                                'label'      => 'Владельцев по ПТС',
                                'element'    =>
                                    [
                                        'type'   => 'radio',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width'    => 4,
                                                'multiple' => false,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите кол-во владельцев по ПТС',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                        0 =>
                                            [
                                                'value' => 8,
                                                'label' => '1',
                                            ],
                                        1 =>
                                            [
                                                'value' => 9,
                                                'label' => '2',
                                            ],
                                        2 =>
                                            [
                                                'value' => 10,
                                                'label' => '3',
                                            ],
                                        3 =>
                                            [
                                                'value' => 11,
                                                'label' => '4+',
                                            ],
                                    ],
                            ],
                        7  =>
                            [
                                'id'         => 8,
                                'data_type'  => 'array',
                                'slug'       => 'checkbox',
                                'label'      => 'Данные о ТО',
                                'element'    =>
                                    [
                                        'type'   => 'checkbox',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                                'width' => 4,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                    ],
                                'values'     =>
                                    [
                                        0 =>
                                            [
                                                'value' => 12,
                                                'label' => 'Есть сервисная книжка',
                                            ],
                                        1 =>
                                            [
                                                'value' => 13,
                                                'label' => 'Обслуживался у дилера',
                                            ],
                                        2 =>
                                            [
                                                'value' => 14,
                                                'label' => 'На гарантии',
                                            ],
                                    ],
                            ],
                        8  =>
                            [
                                'id'         => 9,
                                'data_type'  => 'string',
                                'slug'       => 'textarea',
                                'label'      => 'Описание',
                                'element'    =>
                                    [
                                        'type'   => 'textarea',
                                        'layout' => 'vertical',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Пожалуйста, заполните описание',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                        9  =>
                            [
                                'id'         => 10,
                                'data_type'  => 'array',
                                'slug'       => 'location',
                                'label'      => 'Место осмотра',
                                'element'    =>
                                    [
                                        'type'   => 'location',
                                        'layout' => 'vertical',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'params' =>
                                            [
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Пожалуйста, укажите место осмотра',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                        10 =>
                            [
                                'id'         => 11,
                                'data_type'  => 'integer',
                                'slug'       => 'input',
                                'label'      => 'Цена',
                                'element'    =>
                                    [
                                        'type'   => 'input',
                                        'layout' => 'vertical',
                                        'label'  =>
                                            [
                                                'help' =>
                                                    [
                                                        'text' => null,
                                                    ],
                                            ],
                                        'help'   => null,
                                        'addon'  => '₽',
                                        'params' =>
                                            [
                                                'width' => 8,
                                            ],
                                    ],
                                'validation' =>
                                    [
                                        0 =>
                                            [
                                                'rule'    => 'required',
                                                'type'    => 'error',
                                                'message' => 'Укажите стоимость',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                        1 =>
                                            [
                                                'rule'    => 'number',
                                                'type'    => 'warning',
                                                'message' => 'Правильно укажите стоимость',
                                                'params'  =>
                                                    [
                                                    ],
                                            ],
                                    ],
                                'values'     =>
                                    [
                                    ],
                            ],
                    ],
            ],
    ];
}
