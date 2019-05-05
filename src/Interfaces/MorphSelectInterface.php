<?php

namespace LaravelAdminExt\Select2\Interfaces;

/**
 * @method static string transformText($text) Transform the text
 * @method \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method string getKeyName()
 * @method mixed select($param)
 */
interface MorphSelectInterface
{
    /**
     * Get text column name which select2 ajax wants.
     *
     * @return string
     */
    public static function getTextColumn();
}
