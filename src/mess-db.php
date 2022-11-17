<?php
include('connection.php');
class messModel
{
  public $message;
  public $sender;
  public $receiver;
  public $title;

  function __construct( $message, $sender,$receiver,$title)
  {
    $this->title = $title;
    $this->receiver = $receiver;
    $this->message = $message;
    $this->sender = $sender;
  }

  static function save($message, $sender,$receiver,$title)
  {
    $db = DB::getInstance();
    $query = $db->prepare("INSERT INTO messages (`message`, `sender`,`receiver`, `title`) VALUES (?,?,?,?)");
    $query->execute([$message, $sender,$receiver,$title]);
    $check = true;
    return $check;
  }
  static function get($username){
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare("SELECT * FROM messages WHERE receiver=?");
    $req->execute([$username]);
    foreach ($req->fetchAll() as $item) {
      array_push($list,$item);
    }
    return $list;
  }
  static function admin_get(){
    $list = [];
    $db = DB::getInstance();
    $req = $db->prepare("SELECT * FROM messages");
    $req->execute();
    foreach ($req->fetchAll() as $item) {
      array_push($list,$item);
    }
    return $list;
  }

  static function delete($id)
  {
    $db = DB::getInstance();
    $query = $db->prepare("DELETE FROM messages WHERE id = ? ");
    $query->execute([$id]);
    $check = true;
    return $check;
  }
}