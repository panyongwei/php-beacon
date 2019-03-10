<?php
/**
 * Created by PhpStorm.
 * User: wj008
 * Date: 18-12-3
 * Time: 下午1:42
 */

namespace beacon\widget;


use beacon\Field;
use beacon\Request;
use beacon\Validate;

class Datetime extends Hidden
{
    public function code(Field $field, $attr = [])
    {
        $attr['yee-module'] = 'picker';
        $attr['data-use-time'] = true;
        $attr['type'] = 'text';
        $attr = WidgetHelper::mergeAttributes($field, $attr);
        return '<input ' . join(' ', $attr) . ' />';
    }

    public function assign(Field $field, array $input)
    {
        $val = Request::input($input, $field->boxName . ':s', '');
        if (!Validate::test_date($val)) {
            $field->value = null;
        }
        $field->value = $val;
    }

    public function fill(Field $field, array &$values)
    {
        if ($field->varType == 'int' || $field->varType == 'integer') {
            $values[$field->name] = strtotime($field->value);
            return;
        }
        if (empty($field->value)) {
            $values[$field->name] = null;
        } else {
            $values[$field->name] = $field->value;
        }
    }

    public function init(Field $field, array $values)
    {
        if ($field->varType == 'int' || $field->varType == 'integer') {
            $time = isset($values[$field->name]) ? $values[$field->name] : 0;
            $field->value = date('Y-m-d H:i:s', $time);
            return;
        }
        $field->value = isset($values[$field->name]) ? $values[$field->name] : null;
    }
}