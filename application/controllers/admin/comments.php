<?php

class Comments_Controller extends Admin_Controller {

  public function index()
  {
    $total_comments = ORM::factory('comment')->count_all_unpublished();
    $safepag = new Safe_pagination((int) $this->input->get('page', 1),
				   Comment_Model::per_page,
				   $total_comments);

    $comments = ORM::factory('comment')
      ->with('article')
      ->limit($safepag->per_page, $safepag->offset)
      ->find_all_unpublished();
    $this->template->title = 'Комментарии, ожидающие публикации';
    $this->template->javascripts = View::factory('admin/comments/javascripts');
    $this->template->content = View::factory('admin/comments/index')
      ->bind('comments', $comments)
      ->bind('safepag', $safepag);
  }

  public function publish($comment_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_comment_or_404($comment_id);
      $this->comment->published = 1;
      $this->comment->save();
      echo json_encode(array("comment-actions-{$this->comment->id}" =>
			     View::factory('admin/comments/actions')
			     ->bind('comment', $this->comment)
			     ->render(FALSE)));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  public function delete($comment_id = NULL)
  {
    $this->auto_render = FALSE;
    if ((request::method() == 'post') && request::is_ajax()) {
      $this->load_comment_or_404($comment_id);
      $this->comment->delete();
      echo json_encode(array("comment-{$comment_id}" => ''));
    } else {
      print 'К этому адресу допускаются только XHR POST запросы.';
    }
  }

  private function load_comment_or_404($comment_id = NULL)
  {
    $this->comment = ORM::factory('comment', $comment_id);
    if (! $this->comment->loaded) {
      throw new Kohana_404_Exception;
    }
  }
}

?>