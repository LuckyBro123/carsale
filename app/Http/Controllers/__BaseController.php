<?php

namespace App\Http\Controllers;

use App\Services\CommonService;

class __BaseController extends Controller {
   public $service;

   public function __construct(CommonService $service) {
      $this->service = $service;
   }

}
