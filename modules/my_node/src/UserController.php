<?php

namespace Drupal\my_node;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hello!を表示するコントローラー
 */
class UserController extends ControllerBase {

  public function user_list($uid) {
    $userModel = new UserModel();
    if($uid == 'all') {
      $result = json_decode(json_encode($userModel->get_user_info()), true);
    } else if(is_numeric($tid)) {
      $result = json_decode(json_encode($userModel->get_user_info($uid)), true);
    }
    $list = [];
    foreach($result as $id => $data) {
      $list[$data["uid"]] = $data;
    }
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($list, true));
    exit(1);
  }
  
  public function user_login(Request $request) {
    $uid = \Drupal::service('user.auth')->authenticate($request->get('name'), $request->get('pass'));
    if(!$uid) {
        $result = ["result" => $uid];
    } else {
        $result = ["result" => true, "uid" => $uid];
        $user = \Drupal\user\Entity\User::load($uid);
        $user_data = ["uid" => $user->uid->value, "name" => $user->name->value, "user_name" => $user->field_user_name->value, "user_body" => $user->field_user_body->value];
        $result["user"] = $user_data;
        if(isset($user->user_picture->entity)) {
            $result["user"]["picture"] = file_create_url($user->user_picture->entity->getFileUri());
        }
        //Statusチェック
        if($user->status->value == 0) {
          $result = ["result" => 0];
        }
    }
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($result, true));
    exit(1);
  }
  
  public function user_sub_menu($uid) {
    $user = \Drupal\user\Entity\User::load($uid);
    $userModel = new UserModel();
    $result = $userModel->get_user_sub_menu_info($uid);
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($result, true));
    exit(1);
  }
}
