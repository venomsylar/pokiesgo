<?php
$args = isset($args) ? $args : null;
$single = get_data_from_template('single', $args);
$id = get_data_from_template('id', $args);
$list = [];
$index = 1;
if ($single) {
    $list = get_data_from_template('list', $args);
    $casino_id = get_data_from_template('casino_id', $args);
    if (count($list) > 0) { ?>
        <div class="casino_bonuses_list full">
            <div class="container_second">
                <?php foreach($list as $item):
                    get_template_part('template-parts/global/constructor/constructor-parts/bonus/bonus-card', 'bonus-card', [
                        'item' => $item,
                        'casino_id' => $casino_id,
                        'index' => $index++,
                        'id' => $id
                    ]);
                endforeach; ?>
            </div>
        </div>
    <?php }
} else {
    $bonus_type = get_data_from_template('bonus_type', $args);
    $casinos_table = get_field('all_casinos_table', 'option');
    if (count($casinos_table) > 0) { ?>
        <div class="casino_bonuses_list">
            <div class="container_second">
                <?php foreach ($casinos_table as $casino) {
                    $bonus_list = get_field('bonuses_list', $casino);
                    if (count($bonus_list) > 0) {
                        foreach($bonus_list as $item):
                            if ($bonus_type === $item['bonus_type']) {
                                get_template_part('template-parts/global/constructor/constructor-parts/bonus/bonus-card', 'bonus-card', [
                                    'item' => $item,
                                    'casino_id' => $casino,
                                    'index' => $index++,
                                    'id' => $id
                                ]);
                            }
                        endforeach;
                    }
                } ?>
            </div>
        </div>
    <?php }
}