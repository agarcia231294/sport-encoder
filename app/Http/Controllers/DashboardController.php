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
    public function showSession(Request $request, $id)
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
    public function showGraph(Request $request, $id)
    {
        if (Auth::check()) {
            $session = Session::where('id',$id)->where('user_id',Auth::id())->firstOrFail();
            $distances = $session->distances;

            $distances = $distances->sortBy('timestamp');

            $distances = $distances->map(function ($distance) {
                $distance->timestamp = round($distance->timestamp/1000,1).' s';
                return $distance;
            });
            $distances = $distances->unique('timestamp');
            
            
            // $distances = $distances->map(function ($distance) {
            //     $distance->speed = $distance->speed*3.6;
            //     return $distance;
            // });//     IN KM/H
            
            $distances = $distances->map(function ($distance) {
                $distance->m = $distance->cm/100;
                return $distance;
            });//     IN M


            $m = $distances->pluck('m')->toArray();
            $time = $distances->pluck('timestamp')->toArray();
            $speed =  $distances->pluck('speed')->toArray(); // in m/s

            $data = [
                'labels' => $time,
                'distances' => $m,
                'speed' => $speed,
                'id'=> $id
            ];
            return view('pages.dashboard.graph',$data);
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     *
     * @return response()
     */
    public function delete(Request $request, $id){
        if (Auth::check()) {

            $session = Session::findOrFail($id);
            $session->distances->each(function($distance){
                $distance->delete();
            });
            $session->delete();

            return redirect(route('dashboard.sessions'));
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
    public function generateStadistics(int $id)
    {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        $session = Session::where('id',$id)->where('user_id',Auth::id())->first();
        if(!$session){
            return redirect(route('dashboard.sessions'));
        }

        $this->calculateSpeed($session);
        $this->calculateSpeedStadistics($session);
        $this->calculateDistanceStadistics($session);
        //TODO calculate rest

        // acceleration = (V_final - V_inicail) / time
        // force = mass x acceleration
        // power = force x speed
        

        return redirect(route('dashboard.sessions'));
    }

    private function calculateSpeed(Session $session): void
    {
        $distances = $session->distances->sortBy('timestamp');
        
        $last_m = 0;
        $last_sec = 0;
        foreach ($distances as $distance) {
            $meters = $distance->cm / 100;
            $seconds = $distance->timestamp / 1000;

            if($seconds-$last_sec==0){
                $speed = 0;
            }else{
                $speed = abs(($meters-$last_m) / ($seconds-$last_sec));
            }
            $last_m = $meters;
            $last_sec = $seconds;
            $distance->speed = $speed;
            $distance->save();
        }
    }

    private function calculateDistanceStadistics(Session $session): void
    {
        $maxDistance = $session->distances->sortByDesc('cm')->first()->cm;
        $minDistance = $session->distances->sortBy('cm')->first()->cm;

        $session->max_distance = ($maxDistance-$minDistance);

        $distances = $session->distances->pluck('cm')->toArray();
        $session->average_distance = array_sum($distances)/count($distances);

        $session->save();
    }

    private function calculateSpeedStadistics(Session $session): void
    {
        $maxSpeed = $session->distances->sortByDesc('speed')->first()->speed;
        $minSpeed = $session->distances->sortBy('speed')->first()->speed;

        $session->max_speed = ($maxSpeed-$minSpeed);

        $speeds = $session->distances->pluck('speed')->toArray();
        $session->average_speed = array_sum($speeds)/count($speeds);

        $session->save();
    }




}
