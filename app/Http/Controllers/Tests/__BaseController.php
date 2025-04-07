<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Services\TestService;

class __BaseController extends Controller {
   public $service;

   public function __construct(TestService $service) {
      $this->service = $service;
   }

}
