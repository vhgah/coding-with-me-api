<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;
use App\Models\UserActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;

class UserActivityLogController extends Controller
{
    public function store(Request $request)
    {
        $ipAddress = $request->ip();

        $geoData = GeoIP::getLocation($ipAddress);

        $agent = new Agent();

        $result = UserActivityLog::create([
            'user_agent' => $request->header('User-Agent'),
            'referral_url' => $request->headers->get('referer'),
            'ip_address' => $ipAddress,
            'country' => $geoData->country ?? null,
            'city' => $geoData->city ?? null,
            'state' => $geoData->state ?? null,
            'timezone' => $geoData->timezone ?? null,
            'browser' => $agent::browser(),
            'platform' => $agent::platform(),
            'device' => $agent::device(),
            'is_robot' => $agent::isRobot(),
            'languages' => $agent::languages(),
        ]);

        if (!$result) {
            Log::error('User activity log failed', ['ip' => $ipAddress]);
        }

        return response()->json([
            'message' => 'User activity logged successfully'
        ], 201);
    }
}
