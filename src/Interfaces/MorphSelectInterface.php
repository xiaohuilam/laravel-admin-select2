<?php

namespace LaravelAdminExt\Select2\Interfaces;

/**
 * @method static string transformText($text) Transform the text
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
