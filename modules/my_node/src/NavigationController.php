<?php

namespace Drupal\my_node;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

/**
 * Hello!を表示するコントローラー
 */
class NavigationController  extends ControllerBase {
  public function navigation($uid) {
    $navigation = new NavigationModel();
    $result = $navigation->get_navigation($uid);
    
    $info = [];
    foreach($result as $id => $data) {
      $info[$id]["menu_id"] = $data->menu_id;
      $info[$id]["menu_name"] = taxonomy_term_load($info[$id]["menu_id"])->name->value;
      $info[$id]["tag_id"] = $data->tag_id;
      if(isset($info[$id]["tag_id"])) {
        $info[$id]["tag_name"] = taxonomy_term_load($info[$id]["tag_id"])->name->value;
      }
      $info[$id]["type"] = $data->type_id;
    }
    
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($info, true));
    exit(1);
  }
}