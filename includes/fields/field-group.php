<?php

if(!defined('ABSPATH'))
    exit;

add_action('acf/render_field_settings/type=group', 'acfe_field_group_settings');
function acfe_field_group_settings($field){
    
    acf_render_field_setting($field, array(
        'label'         => __('Edition modal'),
        'name'          => 'acfe_group_modal',
        'key'           => 'acfe_group_modal',
        'instructions'  => __('Edit fields in a modal'),
        'type'              => 'true_false',
        'message'           => '',
        'default_value'     => false,
        'ui'                => true,
        'conditional_logic' => array(
            array(
                array(
                    'field'     => 'display',
                    'operator'  => '==',
                    'value'     => 'group',
                ),
            )
        )
    ));
    
    acf_render_field_setting($field, array(
        'label'         => __('Edition modal button'),
        'name'          => 'acfe_group_modal_button',
        'key'           => 'acfe_group_modal_button',
        'instructions'  => __('Text displayed in the edition modal button'),
        'type'          => 'text',
        'placeholder'   => __('Edit', 'acf'),
        'conditional_logic' => array(
            array(
                array(
                    'field'     => 'display',
                    'operator'  => '==',
                    'value'     => 'group',
                ),
                array(
                    'field'     => 'acfe_group_modal',
                    'operator'  => '==',
                    'value'     => '1',
                ),
            )
        )
    ));
    
}

add_filter('acf/field_wrapper_attributes', 'acfe_field_group_wrapper', 10, 2);
function acfe_field_group_wrapper($wrapper, $field){
    
    if($field['type'] !== 'group')
        return $wrapper;
    
    if(isset($field['acfe_group_modal']) && !empty($field['acfe_group_modal'])){
        
        $wrapper['data-acfe-group-modal'] = 1;
        $wrapper['data-acfe-group-modal-button'] = __('Edit', 'acf');
        
        if(isset($field['acfe_group_modal_button']) && !empty($field['acfe_group_modal_button'])){
            
            $wrapper['data-acfe-group-modal-button'] = $field['acfe_group_modal_button'];
            
        }
        
    }
    
    return $wrapper;
    
}

add_filter('acf/prepare_field/type=group', 'acfe_field_group_type_class', 99);
function acfe_field_group_type_class($field){
    
    $field['wrapper']['class'] .= ' acfe-field-group-layout-' . $field['layout'];
    
    return $field;
    
}