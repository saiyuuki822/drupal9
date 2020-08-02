<?php

namespace Drupal\my_node;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\node\Entity\Node;
use Drupal\comment\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Hello!を表示するコントローラー
 */
class MyNodeController  extends ControllerBase {
  public function node_list(Request $request, $type, $entity_id) {
    $nodeModel = new NodeModel();
    $offset = $request->query->get('offset');
    $limit = $request->query->get('limit');
    $tag_id = $request->query->get('tag_id');

    if($type == 'all') {
      $result = json_decode(json_encode($nodeModel->get_node_list(null, null, $offset, $limit, $tag_id)), true);
    } else if($type == 'taxonomy') {
      $result = json_decode(json_encode($nodeModel->get_node_list(2, $entity_id, $offset, $limit, $tag_id)), true);
    } else if($type == 'user') {
      $result = json_decode(json_encode($nodeModel->get_node_list(1, $entity_id, $offset, $limit, $tag_id)), true);
    } else if($type == 'node') {
      $result = json_decode(json_encode($nodeModel->get_node_list(3, $entity_id, $offset, $limit, $tag_id)), true);
    }

    foreach($result as $id => $data) {
      $node = node_load($data["nid"]);
      $user = user_load($data["uid"]);
      if(isset($user->user_picture->entity)) {
        $result[$id]["picture"] = file_create_url($user->user_picture->entity->getFileUri());
      }
      if(isset($node->field_image)) {
        foreach($node->field_image as $image) {
          if($image->entity) {
            $result[$id]["image"][] = $image->entity->url();
          }
        }
      }
      if(isset($node->field_public_scope)) {
        $result[$id]["public_scope"] = $node->field_public_scope->value;
      }
      $body_value = strip_tags($result[$id]["body_value"]);
      if(mb_strlen($body_value) >= 300) {
        $body_value = mb_substr($body_value, 0, 300). "...";
      }
      $result[$id]["body_value"] = $body_value;
      $result[$id]["created"] = $result[$id]["created"];



      $image_caption = $nodeModel->get_image_caption($data["nid"]);
      $comment = $nodeModel->get_comment_list($data["nid"]);
      //foreach($comment as $key => $value2) {
        //$comment[$key]["created2"] = 123456789;
        //$comment[$key]["picture"] = file_create_url(file_load($value["picture"])->uri);
      $result[$id]["image_caption"] = $image_caption;
      $result[$id]["comment"] = $comment;
      foreach($result[$id]["comment"] as $key => $value2) {
        $result[$id]["comment"][$key] = $value2;
        //$result[$id]["comment"][$key]["created"] = "aaa";
      }
    }
    $list = [];
    foreach($result as $id => $data) {
      $list[$data["nid"]] = $data;
    }
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($result, true));
    exit(1);
  }

  public function node_search($type, $entity_id, $word) {
    $nodeModel = new NodeModel();
    if($type == 'all') {
      $result = json_decode(json_encode($nodeModel->get_node_search(null, null, $word)), true);
    } else if($type == 'taxonomy') {
      $result = json_decode(json_encode($nodeModel->get_node_search(2, $entity_id)), true);
    } else if($type == 'user') {
      $result = json_decode(json_encode($nodeModel->get_node_search(1, $entity_id)), true);
    }

    foreach($result as $id => $data) {
      $node = node_load($data["nid"]);
      $user = user_load($data["uid"]);
      if(isset($user->user_picture->entity)) {
        $result[$id]["picture"] = file_create_url($user->user_picture->entity->getFileUri());
      }
      if(isset($node->field_image)) {
        foreach($node->field_image as $image) {
          if($image->entity) {
            $result[$id]["image"][] = $image->entity->url();
          }
        }
      }
      if(isset($node->field_public_scope)) {
        $result[$id]["public_scope"] = $node->field_public_scope->value;
      }
      $body_value = strip_tags($result[$id]["body_value"]);
      if(mb_strlen($body_value) >= 300) {
        $body_value = mb_substr($body_value, 0, 300). "...";
      }
      $result[$id]["body_value"] = $body_value;
      $result[$id]["created"] = $result[$id]["created"];
      $comment = $nodeModel->get_comment_list($data["nid"]);
      //foreach($comment as $key => $value2) {
      //$comment[$key]["created2"] = 123456789;
      //$comment[$key]["picture"] = file_create_url(file_load($value["picture"])->uri);
      $image_caption = $nodeModel->get_image_caption($data["nid"]);
      $result[$id]["comment"] = $comment;
      $result[$id]["image_caption"] = $image_caption;
      foreach($result[$id]["comment"] as $key => $value2) {
        $result[$id]["comment"][$key] = $value2;
        //$result[$id]["comment"][$key]["created"] = "aaa";
      }
    }
    $list = [];
    foreach($result as $id => $data) {
      $list[$data["nid"]] = $data;
    }
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($result, true));
    exit(1);
  }



  public function node_data($nid) {
    $nodeModel = new NodeModel();
    $result = json_decode(json_encode($nodeModel->get_node_list(3, $nid)), true);
    foreach($result as $id => $data) {
        $node = node_load($data["nid"]);
        $user = user_load($data["uid"]);
        if(isset($user->user_picture->entity)) {
            $result[$id]["picture"] = file_create_url($user->user_picture->entity->getFileUri());
        }
        if(isset($node->field_image)) {
            foreach($node->field_image as $image) {
                if($image->entity) {
                    $result[$id]["image"][] = $image->entity->url();
                }
            }
        }
        $image_caption = $nodeModel->get_image_caption($data["nid"]);
        $result[$id]["image_caption"] = $image_caption;
    }
    header("Content-Type: application/json; charset=utf-8");
    if(isset($nid)) {
      echo (json_encode($result, true));
    } else {
      echo (json_encode($result[0], true));
    }
    exit(1);
  }

  public function page($tid) {
    $node = new NodeModel();
    $result = json_decode(json_encode($node->get_page_data($tid)), true);
    header("Content-Type: application/json; charset=utf-8");
    echo (json_encode($result, true));
    exit(1);
  }

  public function mail(Request $request) {
    $uid = $request->query->get('uid');
    $user = user_load($uid);
    $to = $user->mail->value;
    $name = $request->query->get('name');
    $contact = $request->query->get('contact');
    $type = $request->query->get('type');
    $body = $request->query->get('body');
    $params['name'] = $name;
    $params['contact'] = $contact;
    $params['message'] = 'メッセージが来ました  W(`0`)W';
    $params['body'] = $body;
    $params['type'] = $type;
    $message = \Drupal::service('plugin.manager.mail')->mail('my_node', 'notice', $to, 'ja', $params, FALSE);
    echo (json_encode($params, true));
    exit(1);
  }

  public function file() {
    $query = db_select('file_managed', 'f');
    $query->fields('f',array('fid', 'uri'));
    $query->orderBy('f.fid', 'ASC');
    $result = $query->execute()->fetchAll();
    $list = [];
    foreach($result as $data) {
      $list[$data->fid] = file_create_url($data->uri);
    }
    echo (json_encode($list, true));
    exit(1);
  }

  public function node_post(Request $request) {
    $uid = $request->query->get('uid');
    $user = user_load($uid);
    $to = $user->mail->value;
    $title = $request->query->get('title');
    $body = $request->query->get('body');
    $type = $request->query->get('type');
    $navigation = $request->query->get('navigation');
    $public_scope = $request->query->get('public_scope');
    $image = $request->query->get('image');
    $image_data = file_get_contents($image);
    $file = file_save_data($image_data, "public://". basename($image).".jpg", FILE_EXISTS_REPLACE);
    $node = Node::create(array(
        'type' => 'article',
        'title' => $title,
        'body'  =>  $body,
        'field_public_scope' => $public_scope,
        'field_page_menu' => $navigation,
        'field_image' => [
          'target_id' => $file->id(),
          'alt' => 'Image',
          'title' => 'Image File'
        ],
        'langcode' => 'ja',
        'uid' => $uid,
        'status' => 1,
    ));

    $node->save();
    $params["nid"] = $node->nid->value;

    //画像と文章のセットの保存
    $field_image = $request->query->get('field_image1');
    $caption = $request->query->get('caption1');
    $i = 1;
    while(isset($caption) && $i <= 8) {
      $node = entity_load('node', $node->nid->value);
      $paragraph = Paragraph::create(['type' => 'image_and_caption',]);
      $paragraph->set('field_caption', $caption);
      $image_data = file_get_contents($field_image);
      $file = file_save_data($image_data, "public://". basename($field_image).".jpg", FILE_EXISTS_REPLACE);
      if ($file->id()) {
        $file = file_load($file->id());
        $paragraph->set('field_image', $file);
      }
      $paragraph->isNew();
      $paragraph->save();

      $current = $node->get('field_image_and_caption')->getValue();
      $current[] = array(
        'target_id' => $paragraph->id(),
        'target_revision_id' => $paragraph->getRevisionId(),
      );
      $node->set('field_image_and_caption', $current);
      $node->save();
      $i++;
      $caption = $request->query->get('caption'.$i);
      $field_image = $request->query->get('field_image'.$i);
    }
    echo (json_encode($params, true));
    exit(1);
  }

  public function node_delete(Request $request) {
    $nid = $request->query->get('nid');
    $node = node_load($nid);
    $node->delete();
    echo (json_encode(array($nid), true));
    exit(1);
  }

  public function upload_file(Request $request) {
    $image = $request->query->get('image');
    $image_data = file_get_contents($image);
    $file = file_save_data($image_data, "public://". basename($image).".jpg", FILE_EXISTS_REPLACE);
    $file_url = file_create_url("public://". basename($image).".jpg");
    echo (json_encode(array('file_url' => $file_url, 'fid' => $file->id()), true));
    exit(1);
  }

  public function post_edit(Request $request) {
    \Drupal::logger('my_node')->error(print_r($_POST, true));
    $nid = $_POST["edit_nid"];
    $node = node_load($nid);
    $node->title = $_POST['post_title'];
    $node->body = $_POST['post_body'];
    $node->field_public_scope = $_POST["public_scope"];
    $image = $_FILES['post_file']['tmp_name'];
    if(isset($image) && strlen($image)) {
      $image_data = file_get_contents($image);
      $file = file_save_data($image_data, "public://". basename($image).".jpg", FILE_EXISTS_REPLACE);
      $node->field_image = $file->id();
    }
    $node->field_image_and_caption = [];
    $result = $node->save();
    $nodeModel = new NodeModel();
    if(isset($_POST["tags"]) && is_numeric($_POST["tags"])) {
      $nodeModel->save_my_tags($nid, $_POST["tags"]);
    }
    $nodeModel->delete_image_caption($nid);
    $field_image = $_FILES['field_image1']['tmp_name'];
    $caption = $_POST['caption1'];
    $i = 1;
    $current = [];

    while(isset($caption) && $i <= 8) {
      \Drupal::logger('my_node')->error("image_caption_idx:".$i);
      $image_caption = $nodeModel->get_entity('field_image_and_caption', 'node', $nid, ($i-1));
      if($image_caption !== false && isset($image_caption[0])) {
        $nodeModel->delete_image_caption($image_caption[0]->field_image_and_caption_target_id);
        $image_data = file_get_contents($field_image);
        if(isset($image_data) && strlen($image_data) >= 1) {
          $paragraph = Paragraph::create(['type' => 'image_and_caption']);
          $file = file_save_data($image_data, "public://". basename($field_image).".jpg", FILE_EXISTS_REPLACE);
          if($file->id()) {
            $paragraph->set('field_image', $file->id());
            \Drupal::logger('my_node')->error("fid:".$file->id());
          }
        } else {
          //$image_caption = $nodeModel->get_entity('field_image_and_caption', 'node', $nid, ($i-1));
          //$paragraph = Paragraph::load($image_caption[0]->field_image_and_caption_target_id);
          //\Drupal::logger('my_node')->error("paragraph_id:".$image_caption[0]->field_image_and_caption_target_id);
          $paragraph = Paragraph::create(['type' => 'image_and_caption']);
          $fid = $_POST["fid".$i];
          $paragraph->set('field_image', $fid);
        }
        $paragraph->set('field_caption', $caption);
        $paragraph->isNew();
        $paragraph->save();
        $current[$i-1] = array(
          'target_id' => $paragraph->id(),
          'target_revision_id' => $paragraph->getRevisionId(),
        );

        if(isset($_POST['caption'.$i+1]) && isset($_FILES['field_image'.$i+1]) && strlen($_POST['caption'.$i+1]) >= 1 && strlen($_FILES['field_image'.$i+1]) >= 1) {
          $caption = $_POST['caption'.$i+1];
          if(isset($_FILES['field_image'.$i+1]["tmp_name"])) {
            $field_image = $_FILES['field_image'.$i+1]["tmp_name"];
          } else {
            $field_image = null;
          }
        } else {
          $caption = null;
          $field_image = null;
        }
      }
      $i = $i+1;
    }
    \Drupal::logger('my_node')->error(print_r($current, true));
    $node->set('field_image_and_caption', $current);
    $node->field_image_and_caption = $current;
    $node->save();
    \Drupal::logger('my_node')->error("55555");
    echo (json_encode(array('result' => $result, 'nid' => $nid), true));
    exit(1);
  }

  public function node_edit(Request $request) {
    $nid = $request->query->get('nid');
    $node = node_load($nid);
    $node->title = $request->query->get('title');
    $node->body = $request->query->get('body');
    $node->field_public_scope = $request->query->get('public_scope');
    $image = $request->query->get('image');
    if(isset($image) && strlen($image)) {
      $image_data = file_get_contents($image);
      $file = file_save_data($image_data, "public://". basename($image).".jpg", FILE_EXISTS_REPLACE);
      $node->field_image = $file->id();
    }
    $result = $node->save();
    //画像と文章のセットの保存
    $field_image = $request->query->get('field_image1');
    $caption = $request->query->get('caption1');
    $i = 1;
    $current = [];
    $nodeModel = new NodeModel();
    \Drupal::logger('my_node')->error("00000");
    while(isset($caption) && $i <= 8) {
      $image_data = file_get_contents($field_image);
      \Drupal::logger('my_node')->error("11111");
      if(isset($image_data) && strlen($image_data) >= 1) {
        $paragraph = Paragraph::create(['type' => 'image_and_caption']);
        $file = file_save_data($image_data, "public://". basename($field_image).".jpg", FILE_EXISTS_REPLACE);
        if($file->id()) {
          $paragraph->set('field_image', $file->id());
        }
        \Drupal::logger('my_node')->error("22222");
      } else {
        \Drupal::logger('my_node')->error("33333");
        $image_caption = $nodeModel->get_entity('field_image_and_caption', 'node', $nid, ($i-1));
        \Drupal::logger('my_node')->error("paragraph_id:". $image_caption[0]->field_image_and_caption_target_id);
        $paragraph = Paragraph::load($image_caption[0]->field_image_and_caption_target_id);
      }
      $paragraph->set('field_caption', $caption);
      $paragraph->isNew();
      $paragraph->save();
      $current[] = array(
        'target_id' => $paragraph->id(),
        'target_revision_id' => $paragraph->getRevisionId(),
      );
      $i++;
      $caption = $request->query->get('caption'.$i);
      $field_image = $request->query->get('field_image'.$i);
      \Drupal::logger('my_node')->error("44444");
    }
    \Drupal::logger('my_node')->error(print_r($current, true));
    $node->set('field_image_and_caption', $current);
    $node->field_image_and_caption = $current;
    $node->save();
    \Drupal::logger('my_node')->error("55555");
    echo (json_encode(array('result' => $result, 'nid' => $nid), true));
    exit(1);
  }

  public function post_comment(Request $request) {
    $nid = $request->query->get('nid');
    $uid = $request->query->get('uid');
    $comment = $request->query->get('comment');
    $values = [

      // These values are for the entity that you're creating the comment for, not the comment itself.
      'entity_type' => 'node',            // required.
      'entity_id'   => $nid,                // required.
      'field_name'  => 'comment',         // required.

      // The user id of the comment's 'author'. Use 0 for the anonymous user.
      'uid' => $uid,                         // required.

      // These values are for the comment itself.
      'comment_type' => 'comment',        // required.
      'subject' => $comment,  // required.
      'comment_body' => $comment,            // optional.

      // Whether the comment is 'approved' or not.
      'status' => 1,                      // optional. Defaults to 0.
    ];

    // This will create an actual comment entity out of our field values.
    $comment = Comment::create($values);

    // Last, we actually need to save the comment to the database.
    $result = $comment->save();
    echo (json_encode(array('cid' => $comment->cid->value), true));
    exit(1);
  }

  public function user_post(Request $request) {
    $uid = $request->query->get('uid');

    $values = array(
      'field_user_name' => $request->query->get('user_name'),
      'field_user_body' => $request->query->get('user_body'),
      'name' => $request->query->get('name'),
      'mail' => $request->query->get('mail'),
      'roles' => array(),
      'pass' => $request->query->get('password'),
      'status' => 0,
    );
    if(!isset($uid) || $uid == "") {
      $picture = $request->query->get('picture');
      $values = array(
        'field_user_name' => $request->query->get('user_name'),
        'field_user_body' => $request->query->get('user_body'),
        'name' => $request->query->get('name'),
        'mail' => $request->query->get('mail'),
        'roles' => array(),
        'pass' => $request->query->get('password'),
        'status' => 0,
      );
      if(isset($picture)) {
        $image_data = file_get_contents($picture);
        $file = file_save_data($image_data, "public://". basename($picture).".jpg", FILE_EXISTS_REPLACE);
        $values['user_picture'] = array('target_id' => $file->id());
      }
      $account = entity_create('user', $values);

      try {
        $result = $account->save();

        $uid = $account->uid->value;
      } catch (Exception $e) {
        $result = false;
        \Drupal::logger('type')->error($e->getMessage());
      }
      if(!$result) {
        $values = $result;
      }
    } else {
      $user = \Drupal\user\Entity\User::load($uid);
      if(isset($values['password']) && strlen($values['password']) >= 1) {
        $user->setPassword($values['password']);
      }
      $user->setEmail($values['mail']);
      $user->set('field_user_name', $values['field_user_name']);
      $user->set('field_user_body', $values['field_user_body']);
      $user->save();
      $uid = $user->uid->value;
    }
    echo (json_encode(array('result' => ["uid" => $uid]), true));
    exit(1);
  }

  public function test(Request $request) {
    $node = node_load(305);
    $node->field_image_and_caption = [];
    $node->save();

    $nodeModel = new NodeModel();
    $nodeModel->delete_image_caption(305);
//    $image_caption = $nodeModel->get_entity('field_image_and_caption', 'node', 235, 0);
//    $nodeModel->update_paragraph__field_value("field_caption", 751, "中田佳奈♪");
//    var_dump($image_caption);
    exit(1);
  }



  public function hello(Request $requeuhjnhhhst) {
    var_dump("hello");
    exit(1);
  }
}
