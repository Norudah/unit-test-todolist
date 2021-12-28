<?php

namespace App\Service;

use App\Entity\User;
use Exception;

class EmailSenderService {
  
  // TODO : Make a mock for testing this method in order to not crash the app.
  public function sendMail(User $user, $content) {
    throw new Exception("Email service not develped yet.");
  }
}