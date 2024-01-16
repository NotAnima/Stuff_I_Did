<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Chatbot extends BaseController {
  public function index(){
    $data = [
      'title' => 'Chatbot',
    ];

    return view('templates/header', $data)
      . view('chatbot/index')
      . view ('templates/footer');
  }
}
?>