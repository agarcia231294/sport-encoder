<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    /**
     * Write code on Method
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
     * Write code on Method
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
     * Write code on Method
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
     * Write code on Method
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
     * Write code on Method
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

}
