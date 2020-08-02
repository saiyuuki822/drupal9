<?php

namespace Drupal\my_node;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserModel {
    public function get_user_info($uid = null) {
        $query = db_select('users', 'u');
        $query->join('user__field_user_name', 'n', 'u.uid = n.entity_id');
        $query->join('user__field_user_body', 'b', 'u.uid = b.entity_id');
        $query->join('user__user_picture', 'p', 'u.uid = p.entity_id');
        $query->fields('u',array('uid'));
        $query->addField('n', 'field_user_name_value', 'user_name');
        $query->addField('b', 'field_user_body_value', 'user_body');
        $query->addField('p', 'user_picture_target_id', 'picture');
        if(isset($uid)) {
          $query->condition('u.uid', $uid, "=");
        }
        $result = $query->execute()->fetchAll();
        return $result;
    }
    public function get_user_sub_menu_info($uid) {
        $query = db_select('users', 'u');
        $query->join('user__field_user_sub_menu', 's', 'u.uid = s.entity_id');
        $query->join('paragraph__field_sub_menu_name', 'n', 's.field_user_sub_menu_target_id = n.entity_id');
        $query->join('paragraph__field_sub_menu_link', 'l', 's.field_user_sub_menu_target_id = l.entity_id');
        $query->join('paragraph__field_link_name', 'ln', 'l.field_sub_menu_link_target_id = ln.entity_id');
        $query->join('paragraph__field_link_url', 'lu', 'l.field_sub_menu_link_target_id = lu.entity_id');
        $query->fields('u',array('uid'));
        $query->addField('s', 'field_user_sub_menu_target_id', 'sub_menu_id');
        $query->addField('n', 'field_sub_menu_name_value', 'name');
        $query->addField('ln', 'field_link_name_value', 'link_name');
        $query->addField('lu', 'field_link_url_value', 'link_url');
        $query->orderBy('s.delta', 'ASC');
        $result = $query->execute()->fetchAll();

        $info = [];
        $idx = 0;
        $link_idx = 0;
        $sub_menu_id = '';
        foreach($result as $data) {
          if($link_idx != 0 && $sub_menu_id != $data->sub_menu_id) {
            $idx++;
            $link_idx = 0;
            $info[$idx]['link'] = [];
          }
          $sub_menu_id = $data->sub_menu_id;
          $info[$idx]['name'] = $data->name;
          $info[$idx]['link'][$link_idx]['link_name'] = $data->link_name;
          $info[$idx]['link'][$link_idx]['link_url'] = $data->link_url;
          $link_idx++;
        }
        return $info;
    }
  
}