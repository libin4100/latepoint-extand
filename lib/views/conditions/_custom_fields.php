<div class="step-custom-fields-for-condition-w latepoint-step-content" data-step-name="custom_fields_for_booking">
    <div class="os-row">
    <?php 
if(isset($custom_fields_for_booking) && !empty($custom_fields_for_booking)) {
    foreach($custom_fields_for_booking as $custom_field){
        switch ($custom_field['type']) {
        case 'text':
            echo OsFormHelper::text_field('condition[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $condition['custom_fields'][$custom_field['id']], ['placeholder' => $custom_field['placeholder'], 'id' => $custom_field['id'] . $condition['id']], ['class' => $custom_field['width']]);
            break;
        case 'textarea':
            echo OsFormHelper::textarea_field('condition[custom_fields]['.$custom_field['id'].']', $custom_field['label'], $condition['custom_fields'][$custom_field['id']], ['placeholder' => $custom_field['placeholder'], 'id' => $custom_field['id'] . $condition['id']], ['class' => $custom_field['width']]);
            break;
        case 'select':
            echo OsFormHelper::select_field('condition[custom_fields]['.$custom_field['id'].']', $custom_field['label'], OsFormHelper::generate_select_options_from_custom_field($custom_field['options']), $condition['custom_fields'][$custom_field['id']], ['placeholder' => $custom_field['placeholder'], 'id' => $custom_field['id'] . $condition['id']], ['class' => $custom_field['width']]);
            break;
        case 'checkbox':
            echo OsFormHelper::checkbox_field('condition[custom_fields]['.$custom_field['id'].']', $custom_field['label'], 'on', ($condition['custom_fields'][$custom_field['id']] == 'on') , ['id' => $custom_field['id'] . $condition['id']], ['class' => $custom_field['width']]);
            break;
        }
    } 
}
    ?>
    </div>
</div>
