<?php

namespace App\Helpers;

use App\Models\Attribute;
use Filament\Forms;

class FormHelper
{

    public static function createAllFilamentFormField($attr_list)
    {
        $filament_schema = [];
        foreach ($attr_list as $key => $options) {

            $options['key'] = $key;

            $filament_schema[] = self::createFilamentFormField($options);
        }

        return $filament_schema;
    }

    /**
     * @param  mixed  $attr
     * @return mixed
     */
    public static function createFilamentFormField(mixed $attr): mixed
    {
        $class_name = "\Filament\Forms\Components\\".$attr['type'];

        $field = $class_name::make($attr['key'])
            ->label($attr['label'])
            ->default($attr['default'] ?? null)
            ->placeholder($attr['placeholder'] ?? null);

        if (isset($attr['required']) && $attr['required']) {
            $field->required();
        }

        switch ($attr['type']) {
            case 'Select':
                if (isset($attr['options'])) {
                    $options = collect($attr['options'])->pluck('option_label', 'option_value');
                    $field->options($options)->searchable();
                }
                break;

            case 'Radio':
            case 'ToggleButtons':
                if (isset($attr['options'])) {
                    $options = collect($attr['options'])->pluck('option_label', 'option_value');
                    $field->options($options);
                }
                break;

            case 'Textarea':
                $field->rows(5);
                break;

            case 'DateTimePicker':
                $field->format('Y-m-d H:i');
                break;

            case 'DatePicker':
                $field->format('Y-m-d');
                break;

            case 'TimePicker':
                $field->format('H:i');
                break;

            case 'TagsInput':
                $field->allowCreate();
                break;

            case 'ColorPicker':
                break;

            case 'Hidden':
                $field->hidden();
                break;

            case 'TextInput':
                if (isset($attr['input_type'])) {
                    switch ($attr['input_type']) {
                        case 'email':
                            $field->email();
                            break;
                        case 'password':
                            $field->password();
                            break;
                        case 'numeric':
                            $field->numeric();
                            break;
                        case 'integer':
                            $field->numeric()->integer();
                            break;
                        case 'tel':
                            $field->tel();
                            break;
                        case 'url':
                            $field->url();
                            break;
                        default:
                            $field->text();
                            break;
                    }
                }
                break;

            default:
                $field->type('text');
                break;
        }
        return $field;
    }

    protected static function __attr_set__custom_fields(): array
    {
        return [
            Forms\Components\Select::make('selected_custom_attributes')
                ->multiple()
                //->relationship('attributes', 'label')
                ->options(Attribute::all()->pluck('label', '_id'))
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, $get) {
                    $selected_custom_attributes = $get('selected_custom_attributes');

                    if ($selected_custom_attributes) {

                        $set("custom_attributes", [
                            [
                                'type' => 'custom_attributes_block'
                            ]
                        ]);
                    }

                }),

            Forms\Components\Builder::make('custom_attributes')
                ->visible(function (Forms\Get $get) {
                    return $get('selected_custom_attributes') != null;
                })
                ->label('Custom Attributes')
                ->blocks(function (Forms\Get $get) {

                    $custom_attr = $get("selected_custom_attributes");

                    $attrs = [];
                    if ($custom_attr) {

                        $attr_list = Attribute::whereIn("_id", $custom_attr)->get()->toArray();

                        foreach ($attr_list as $attr) {

//                            $class_name = "\Filament\Forms\Components\\".$attr['type'];
//                            $field = $class_name::make($attr['key'])
//                                ->label($attr['label']);

                            $attrs[] = self::createFilamentFormField($attr);
                        }
                    }

                    return [
                        Forms\Components\Builder\Block::make("custom_attributes_block")
                            ->schema($attrs)
                            ->label("Attributes")

                    ];
                })
                ->deletable(false)
                ->addable(false)
                ->reorderable(false)
                ->columnSpan(2)

        ];
    }

    public static function global_common_fields($attributes_keys): array
    {
        $attr_array = [];
        foreach ($attributes_keys as $key) {
            $func_name = "__attr_set__".$key;

            if (method_exists(self::class, $func_name)) {
                $attr_array = array_merge($attr_array, self::$func_name());
            }

        }
        return $attr_array;

    }
}
