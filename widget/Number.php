<?php
/**
 * Created by PhpStorm.
 * User: wj008
 * Date: 2017/12/15
 * Time: 4:01
 */

namespace beacon\widget;


use beacon\Field;
use beacon\Validate;

class Number extends Hidden
{
    public function code(Field $field, $attr = [])
    {
        $attr['yee-module'] = 'number';
        $attr['type'] = 'text';
        $attr = WidgetHelper::mergeAttributes($field, $attr);
        return '<input ' . join(' ', $attr) . ' />';
    }

    public function assign(Field $field, array $input)
    {
        $field->varType = 'float';
        return parent::assign($field, $input);
    }

}