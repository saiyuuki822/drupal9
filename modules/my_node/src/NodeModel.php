<?php

namespace Drupal\my_node;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class NodeModel {
    public function get_node_list($id_type=null, $id = null, $offset = 0, $limit = 10, $tag_id = null) {
      \Drupal::logger('my_node')->error("tag_id:". $tag_id);
        $query = db_select('node', 'n');
        $query->join('node_field_data', 'f', 'n.nid = f.nid');
        $query->join('node__body', 'b', 'n.nid = b.entity_id');
        $query->join('users', 'u', 'f.uid = u.uid');
        $query->join('users_field_data', 'ud', 'u.uid = ud.uid');
        $query->join('user__field_user_name', 'm', 'f.uid = m.entity_id');
        $query->join('user__field_user_body', 'ub', 'f.uid = ub.entity_id');
        if(isset($tag_id)) {
          $query->join('my_node_tags', 'mt', 'n.nid = mt.nid');
        }
        //$query->join('node__field_page_menu', 'pm', 'n.nid = pm.entity_id');
        //$query->leftJoin('paragraphs_item_field_data', 'p', 'n.nid = p.parent_id');
        //$query->leftJoin('paragraph__field_image', 'pi', 'p.id = pi.entity_id');
        //$query->leftJoin('paragraph__field_caption', 'pc', 'p.id = pc.entity_id');
        $query->fields('n', array('nid'));
        $query->fields('f', array('title','uid','created'));
        $query->fields('b', array('body_value'));
        //$query->fields('u', array('name'));

        $query->addField('ud', 'name', 'name');
        $query->addField('m', 'field_user_name_value', 'user_name');
        $query->addField('ub', 'field_user_body_value', 'user_body');
        //$query->addField('pm', 'field_page_menu_target_id', 'page_menu');
        //$query->addField('pc', 'field_caption_value', 'caption');
        //$query->addField('pi', 'field_image_target_id', 'field_image');
        if(isset($tag_id)) {
          $query->condition('mt.tag_id', $tag_id, "=");
          \Drupal::logger('my_node')->error("tag_id:". $tag_id);
        }
        if(isset($id_type) && $id_type == 1 && isset($id)) {
          $query->condition('f.uid', $id, "=");
        } else if(isset($id_type) && $id_type == 2 && isset($id)) {
          $query->condition('pm.field_page_menu_target_id', $id, "=");
        } else if(isset($id_type) && $id_type == 3 && isset($id)) {
          $query->condition('n.nid', $id, "=");
        } 
        $query->condition('n.type', "article", "=");
        $query->orderBy('nid', 'desc');
        $query->range($offset, $limit);
        $result = $query->execute()->fetchAll();
        return $result;
    }
  
    public function get_node_search($id_type=null, $id = null, $word = null) {
        $database = \Drupal::database();
        $query = db_select('node', 'n');
        $query->join('node_field_data', 'f', 'n.nid = f.nid');
        $query->join('node__body', 'b', 'n.nid = b.entity_id');
        $query->join('users', 'u', 'f.uid = u.uid');
        $query->join('user__field_user_name', 'm', 'f.uid = m.entity_id');
        $query->join('user__field_user_body', 'ub', 'f.uid = ub.entity_id');
        //$query->join('node__field_page_menu', 'pm', 'n.nid = pm.entity_id');
        $query->fields('n',array('nid'));
        $query->fields('f', array('title','uid','created'));
        $query->fields('b', array('body_value'));
        $query->addField('m', 'field_user_name_value', 'user_name');
        $query->addField('ub', 'field_user_body_value', 'user_body');
        //$query->addField('pm', 'field_page_menu_target_id', 'page_menu');
//        $query->fields('u', array('name'));
        if(isset($id_type) && $id_type == 1 && isset($id)) {
          $query->condition('f.uid', $id, "=");
        } else if(isset($id_type) && $id_type == 2 && isset($id)) {
          $query->condition('pm.field_page_menu_target_id', $id, "=");
        } else if(isset($id_type) && $id_type == 3 && isset($id)) {
          $query->condition('n.nid', $id, "=");
        } 
        $query->condition('n.type', "article", "=");
        
        $likeGroup = $query->orConditionGroup()->condition('f.title', "%" . $database->escapeLike($word) . "%", 'LIKE');
        $likeGroup = $likeGroup->condition('b.body_value', "%" . $database->escapeLike($word) . "%", 'LIKE');
        $likeGroup = $likeGroup->condition('m.field_user_name_value', "%" . $database->escapeLike($word) . "%", 'LIKE');
        $likeGroup = $likeGroup->condition('ub.field_user_body_value', "%" . $database->escapeLike($word) . "%", 'LIKE');
        $query->condition($likeGroup);
        $query->orderBy('nid', 'asc');
        $result = $query->execute()->fetchAll();
        return $result;
    }
  
    public function get_image_caption($nid) {
      $query = db_select('paragraphs_item_field_data', 'f');
      $query->join('paragraph__field_image', 'pi', 'f.id = pi.entity_id');
      $query->join('paragraph__field_caption', 'pc', 'f.id = pc.entity_id');
      $query->condition('f.parent_id', $nid, "=");
      $query->orderBy('id', 'asc');
      $query->addField('f', 'id');
      $query->addField('pc', 'field_caption_value', 'caption');
      $query->addField('pi', 'field_image_target_id', 'field_image');
      $result = $query->execute()->fetchAll();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
      return $result;
    }
  
  public function delete_image_caption($nid) {
    $query = db_select('paragraphs_item_field_data', 'f')->fields('f');
    $query->condition('parent_id', $nid);
    $result = $query->execute()->fetchAll();
    foreach($result as $data) {
      $query = \Drupal::database()->delete('paragraph__field_image');
      $query->condition('entity_id', $data->id);
      $query->execute();
      $query = \Drupal::database()->delete('paragraph__field_caption');
      $query->condition('entity_id', $data->id);
      $query->execute();      
    }
  }
  
    public function get_entity($field_name, $entity_type, $nid, $delta) {
      $query = db_select($entity_type.'__'.$field_name, 'ic');
      $query->condition('ic.entity_id', $nid, "=");
      $query->condition('ic.delta', $delta, "=");
      $query->addField('ic', $field_name.'_target_id');
      $result = $query->execute()->fetchAll();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
      error_log(print_r($result, true), 3, '/home/saiyuuki-syokudo/www/drupal/modules/my_node/src/error.log');
      if(count($result) >= 1) {
        return $result;
      } else {
        return false;
      }
      return $result;
    } 
  
    public function get_paragraph__field($field_name, $entity_id, $delta=0) {
      $query = db_select('paragraph__'.$field_name, 'p');
      $query->fields('p');
      $query->condition('p.entity_id', $entity_id, "=");
      $query->condition('p.delta', $delta, "=");
      $result = $query->execute()->fetchAll();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
      if(count($result) >= 1) {
        return $result;
      } else {
        return false;
      }
    }
  
    public function update_paragraph__field_value($field_name, $entity_id, $value) {
      $query = \Drupal::database()->update('paragraph__'.$field_name);
      $query->fields([$field_name.'_value' => $value]);
      $query->condition('entity_id', $entity_id, "=");
      $result = $query->execute();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
    }
  
    public function update_paragraph__field_entity($field_name, $entity_id, $value) {
      $query = \Drupal::database()->update('paragraph__'.$field_name);
      $query->fields([$field_name.'_target_id' => $value]);
      $query->condition('entity_id', $entity_id, "=");
      $result = $query->execute();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
    }
  
    public function insert_paragraph__field_image($field_name, $bundle, $entity_id, $delta, $value) {
      $query = $Data = db_insert('paragraph__'.$field_name)->fields(
        array(
          'bundle' => $bundle,
          'deleted' => 0,
          'delta' => 0,
          'entity_id' => time(),
          'field_image_alt' => 'Image',
          'field_image_height' => 400,
          'field_image_target_id' => $value,
          'field_image_title' => 'Image File',
          'field_image_width' => '400',
          'langcode' => 'ja',
          'revision_id' => 0
        ))->execute();
      \Drupal::logger('my_node')->error(strtr((string) $query, $query->arguments()));
    }
  
    public function get_comment_list($nid) {
    //$sql = 'SELECT comment.cid,comment.entity_id AS nid, comment.uid, body.comment_body_value AS body, user_name.field_user_name_value AS user_name, picture.user_picture_target_id AS picture FROM `comment_field_data` AS comment';
    //$sql .= ' INNER JOIN comment__comment_body body ON comment.cid = body.entity_id';
    //$sql .= ' INNER JOIN user__field_user_name user_name ON comment.uid = user_name.entity_id';
    //$sql .= ' INNER JOIN user__user_picture picture ON comment.uid = picture.entity_id';
    //$sql .= ' ORDER BY comment.cid ASC';
      $query = db_select('comment_field_data', 'c');
      $query->join('comment__comment_body', 'b', 'c.cid = b.entity_id');
      $query->join('user__field_user_name', 'n', 'c.uid = n.entity_id');
      $query->join('user__field_user_body', 'ub', 'c.uid = ub.entity_id');
      $query->join('user__user_picture', 'p', 'c.uid = p.entity_id');
      $query->fields('c',array('cid'));
      $query->addField('c', 'uid');
      $query->addField('c', 'entity_id', 'nid');
      $query->addField('c', 'created');
      $query->addField('b', 'comment_body_value', 'body');
      $query->addField('n', 'field_user_name_value', 'user_name');
      $query->addField('ub', 'field_user_body_value', 'user_body');
      $query->addField('p', 'user_picture_target_id', 'picture');
      $query->condition('c.entity_id', $nid, "=");
      $query->orderBy('c.created');
      $result = $query->execute()->fetchAll();
      foreach($result as $id => $value) {
        $result[$id]->created = date('Y/m/d h:i', $value->created);
      }
      
      return $result;
    }
  
    public function get_page_data($tid) {
        $query = db_select('node', 'n');
        $query->join('node_field_data', 'f', 'n.nid = f.nid');
        $query->join('node__body', 'b', 'n.nid = b.entity_id');
        $query->join('users', 'u', 'f.uid = u.uid');
        $query->join('user__field_user_name', 'm', 'f.uid = m.entity_id');
        $query->join('node__field_page_menu', 'mn', 'n.nid = mn.entity_id');
        $query->fields('n',array('nid'));
        $query->fields('f', array('title','uid'));
        $query->fields('b', array('body_value'));
        $query->fields('m', array('field_user_name_value'));
        $query->condition('n.type', "page", "=");
        $query->condition('mn.field_page_menu_target_id', $tid, "=");
        $query->orderBy('nid');
        $result = $query->execute()->fetchAll();
        return $result;
    }
  
    public function save_my_tags($nid, $tag_id) {
      $query = \Drupal::database()->delete('my_node_tags');
      $query->condition('nid', $nid);
      $query->execute();
      $query = db_insert('my_node_tags')->fields(['nid' => $nid, 'tag_id' => $tag_id])->execute();
    }
}

