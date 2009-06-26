<?php defined('SYSPATH') or die('No direct script access.');

class Safe_pagination {

  public function __construct($page, $per_page, $total_items)
  {
    $this->per_page = $per_page;
    $this->total_items = $total_items;

    $this->total_pages = ceil($total_items / $per_page);
    
    $this->page = ($page < 1 || $page > $this->total_pages) ? 1 : $page;

    $this->offset = ($this->page - 1) * $per_page;
  }
}

?>