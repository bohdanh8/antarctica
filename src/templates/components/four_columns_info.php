<?php
$four_columns_info = get_sub_field('four_columns_info');
$columns = ! empty($four_columns_info['columns']) ? $four_columns_info['columns'] : '';
$text_area_under_columns = ! empty($four_columns_info['text_area_under_columns']) ? $four_columns_info['text_area_under_columns'] : '';
?>

<?php if ($columns || $text_area_under_columns): ?>
    <div class="container"></div>
<?php endif; ?>