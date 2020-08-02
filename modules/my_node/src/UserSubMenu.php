<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserSubMenu {
    public function get_user_info($uid) {
        $query = db_select('users', 'u');
        $query->join('user__field_user_name', 'n', 'u.uid = n.entity_id');
        $query->join('user__field_user_body', 'b', 'u.uid = b.entity_id');
        $result = $query->execute()->fetchAll();
        return $result;
    }
}