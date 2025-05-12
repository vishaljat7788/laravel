<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

if (!function_exists('has_permissions')) {
     function has_permissions($route)
     {

          $result = DB::table('tbl_admin')->select('id', 'role', 'permissions')
               ->where('id', Auth::guard('admin')->id())->first();

          if ($result->role != 1) {
               $array = json_decode($result->permissions);

               foreach ($array as $value) {
                    if (strcmp($route, $value) == 0) {
                         return true;
                    }
               }
               return false;
          } else {
               return true;
          }
     }
}
