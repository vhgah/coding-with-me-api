<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;

        $userActivityLogs = UserActivityLog::paginate($limit);

        return response()->json($userActivityLogs);
    }
}
