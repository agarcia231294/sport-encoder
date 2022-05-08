<?php

namespace App\Http\Controllers;

use App\Http\Share\JsonResponse;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    /**
     *
     * @return response()
     */
    public function home()
    {
        if (Auth::check()) {
            return view('pages.dashboard.home');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     *
     * @return response()
     */
    public function indexSessions()
    {
        if (Auth::check()) {
            $sessions = Session::where('user_id',Auth::id())->orderByDesc('created_at')->get();
            return view('pages.dashboard.sessions', ['sessions'=>$sessions]);
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     *
     * @return response()
     */
    public function showSession()
    {
        if (Auth::check()) {
            return view('pages.dashboard.home');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     *
     * @return response()
     */
    public function showGraph()
    {
        if (Auth::check()) {
            return view('pages.dashboard.graph');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    /**
     *
     * @return response()
     */
    public function apiKey()
    {
        if (Auth::check()) {
            return view('pages.dashboard.apikey');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     *
     * @return response()
     */
    public function apiKeyRegenerate()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->generateApiKey();
            return redirect(route("dashboard.apikey"));
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    /**
     *
     * @return response()
     */
    public function generateStadistics(int $session_id): HttpJsonResponse
    {
        if (!Auth::check()) {
            return JsonResponse::response(JsonResponse::STATUS_REFUSED,"login required",null,401);
        }
        $session = Session::where('id',$session_id)->where('user_id',Auth::id())->first();
        if(!$session){
            return JsonResponse::response(JsonResponse::STATUS_REFUSED,"session not allowed",null,401);
        }

        $this->calculateSpeed($session);
        //TODO calculate rest
        

        return JsonResponse::response(JsonResponse::STATUS_SUCCESS,"stadistics generated");
    }

    private function calculateSpeed(Session $session): void
    {
        $distances = $session->distances->sortBy('timestamp');
        
        $last_m = 0;
        $last_sec = 0;
        foreach ($distances as $distance) {
            $meters = $distance->cm / 100;
            $seconds = $distance->timestamp / 100; //TODO review this

            if($seconds-$last_sec==0){
                $speed = 0;
            }else{
                $speed = abs(($meters-$last_m) / ($seconds-$last_sec));
            }
            $last_m = $meters;
            $last_sec = $seconds;
            $distance->speed = $speed;
        }
    }

}
