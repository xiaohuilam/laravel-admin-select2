<?php
namespace LaravelAdminExt\Select2;

use Encore\Admin\Form as BaseForm;

class Form extends BaseForm
{
    /**
     * Register builtin fields.
     *
     * @return void
     */
    public static function registerBuiltinFields()
    {
        $map = [
            'button'         => \Encore\Admin\Form\Field\Button::class,
            'checkbox'       => \Encore\Admin\Form\Field\Checkbox::class,
            'color'          => \Encore\Admin\Form\Field\Color::class,
            'currency'       => \Encore\Admin\Form\Field\Currency::class,
            'date'           => \Encore\Admin\Form\Field\Date::class,
            'dateRange'      => \Encore\Admin\Form\Field\DateRange::class,
            'datetime'       => \Encore\Admin\Form\Field\Datetime::class,
            'dateTimeRange'  => \Encore\Admin\Form\Field\DatetimeRange::class,
            'datetimeRange'  => \Encore\Admin\Form\Field\DatetimeRange::class,
            'decimal'        => \Encore\Admin\Form\Field\Decimal::class,
            'display'        => \Encore\Admin\Form\Field\Display::class,
            'divider'        => \Encore\Admin\Form\Field\Divide::class,
            'divide'         => \Encore\Admin\Form\Field\Divide::class,
            'embeds'         => \Encore\Admin\Form\Field\Embeds::class,
            'editor'         => \Encore\Admin\Form\Field\Editor::class,
            'email'          => \Encore\Admin\Form\Field\Email::class,
            'file'           => \Encore\Admin\Form\Field\File::class,
            'hasMany'        => \Encore\Admin\Form\Field\HasMany::class,
            'hidden'         => \Encore\Admin\Form\Field\Hidden::class,
            'id'             => \Encore\Admin\Form\Field\Id::class,
            'image'          => \Encore\Admin\Form\Field\Image::class,
            'ip'             => \Encore\Admin\Form\Field\Ip::class,
            'map'            => \Encore\Admin\Form\Field\Map::class,
            'mobile'         => \Encore\Admin\Form\Field\Mobile::class,
            'month'          => \Encore\Admin\Form\Field\Month::class,
            'multipleSelect' => \LaravelAdminExt\Select2\Form\Field\MultipleSelect::class,
            'number'         => \Encore\Admin\Form\Field\Number::class,
            'password'       => \Encore\Admin\Form\Field\Password::class,
            'radio'          => \Encore\Admin\Form\Field\Radio::class,
            'rate'           => \Encore\Admin\Form\Field\Rate::class,
            'select'         => \LaravelAdminExt\Select2\Form\Field\Select::class,
            'slider'         => \Encore\Admin\Form\Field\Slider::class,
            'switch'         => \Encore\Admin\Form\Field\SwitchField::class,
            'text'           => \Encore\Admin\Form\Field\Text::class,
            'textarea'       => \Encore\Admin\Form\Field\Textarea::class,
            'time'           => \Encore\Admin\Form\Field\Time::class,
            'timeRange'      => \Encore\Admin\Form\Field\TimeRange::class,
            'url'            => \Encore\Admin\Form\Field\Url::class,
            'year'           => \Encore\Admin\Form\Field\Year::class,
            'html'           => \Encore\Admin\Form\Field\Html::class,
            'tags'           => \Encore\Admin\Form\Field\Tags::class,
            'icon'           => \Encore\Admin\Form\Field\Icon::class,
            'multipleFile'   => \Encore\Admin\Form\Field\MultipleFile::class,
            'multipleImage'  => \Encore\Admin\Form\Field\MultipleImage::class,
            'captcha'        => \Encore\Admin\Form\Field\Captcha::class,
            'listbox'        => \Encore\Admin\Form\Field\Listbox::class,
        ];

        foreach ($map as $abstract => $class) {
            static::extend($abstract, $class);
        }
    }
}
