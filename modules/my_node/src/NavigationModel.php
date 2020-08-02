<?php

namespace Drupal\my_node;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class NavigationModel {
    public function get_navigation($uid) {
        $query = db_select('user__field_user_navigation', 'n');
        $query->join('paragraph__field_user_menu', 'm', 'n.field_user_navigation_target_id = m.entity_id');
        $query->leftJoin('paragraph__field_user_menu_tag', 'mtg', 'n.field_user_navigation_target_id = mtg.entity_id');
        $query->leftJoin('paragraph_revision__field_user_menu_type', 'mtp', 'n.field_user_navigation_target_id = mtp.entity_id');
        $query->addField('n', 'entity_id', 'uid');
        $query->addField('m', 'field_user_menu_target_id', 'menu_id');
        $query->addField('mtg', 'field_user_menu_tag_target_id', 'tag_id');
        $query->addField('mtp', 'field_user_menu_type_value', 'type_id');
        $query->orderBy('n.delta');
        $result = $query->execute()->fetchAll();
        return $result;
    }
}