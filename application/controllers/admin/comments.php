<?php

class Comments_Controller extends Admin_Controller {

  public function index()
  {
    $comments = ORM::factory('comment')
      ->with('article')
      ->find_all_unpublished();
    $this->template->title = 'Комментарии, ожидающие публикации';
    $this->template->content = View::factory('admin/comments/index')
      ->bind('comments', $comments);
  }
}

?>