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


            $m = $distances->pluck('m')->toArray(); // in meters
            $time = $distances->pluck('timestamp')->toArray(); // in seconds
            $speed =  $distances->pluck('speed')->toArray(); // in m/s
            $acceleration =  $distances->pluck('acceleration')->toArray(); // in m/s^2
            $force =  $distances->pluck('force')->toArray(); // in newtons
            $power =  $distances->pluck('power')->toArray(); // in watts

            $data = [
                'labels' => $time,
                'distances' => $m,
                'speed' => $speed,
                'id'=> $id,
                'acceleration' => $acceleration,
                'force' => $force,
                'power' => $power,
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
    public function generateStadistics(int $id, float $kg)
    {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        $session = Session::where('id',$id)->where('user_id',Auth::id())->first();
        if(!$session){
            return redirect(route('dashboard.sessions'));
        }
        if($kg>0){
            $session->kg = $kg;
            $session->save();
        }
        // TODO check exists distances
        $this->calculateDistanceMeasures($session);
        $this->calculateSpeedStadistics($session);
        $this->calculateDistanceStadistics($session);
        $this->calculateAccelerationStadistics($session);
        $this->calculateForceStadistics($session);
        $this->calculatePowerStadistics($session);
        
        return redirect(route('dashboard.sessions'));
    }

    private function calculateDistanceMeasures(Session $session): void
    {
        $distances = $session->distances->sortBy('timestamp');
        
        $last_m = 0;
        $last_sec = 0;
        $last_speed = 0;
        foreach ($distances as $distance) {
            $meters = $distance->cm / 100;
            $seconds = $distance->timestamp / 1000;

            if($seconds-$last_sec==0){
                $speed = 0;
            }else{
                // speed = distance / time
                $speed = ($meters-$last_m) / ($seconds-$last_sec); // m/s
            }
            $distance->speed = $speed;

            // acceleration = (Speed_finish - Speed_start) / time
            $acceleration = ($speed - $last_speed) / ($seconds-$last_sec); // m/s^2
            $distance->acceleration = $acceleration;
            
            $kg = $session->kg;
            if($kg){
                // force = mass x acceleration
                $force = $kg * $acceleration; // Newtons
                $distance->force = $force;

                // power = force x speed
                $power = $force * abs($speed); // Watts
                $distance->power = $power;
            }

            if(($seconds-$last_sec)>0.1){
                $last_m = $meters;
                $last_sec = $seconds;
                $last_speed = $speed;
            }
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

    private function calculateAccelerationStadistics(Session $session): void
    {
        $max_acceleration = $session->distances->sortByDesc('acceleration')->first()->acceleration;
        $min_acceleration = $session->distances->sortBy('acceleration')->first()->acceleration;

        $session->max_acceleration = ($max_acceleration-$min_acceleration);

        $accelerations = $session->distances->pluck('acceleration')->toArray();
        $session->avg_acceleration = array_sum($accelerations)/count($accelerations);

        $session->save();
    }
    private function calculateForceStadistics(Session $session): void
    {
        if(!$session->kg){
            return;
        }
        $max_force = $session->distances->sortByDesc('force')->first()->force;
        $min_force = $session->distances->sortBy('force')->first()->force;

        $session->max_force = ($max_force-$min_force);

        $forces = $session->distances->pluck('force')->toArray();
        $session->avg_force = array_sum($forces)/count($forces);

        $session->save();
    }
    private function calculatePowerStadistics(Session $session): void
    {
        if(!$session->kg){
            return;
        }
        $max_power = $session->distances->sortByDesc('power')->first()->power;
        $min_power = $session->distances->sortBy('power')->first()->power;

        $session->max_power = ($max_power-$min_power);

        $powers = $session->distances->pluck('power')->toArray();
        $session->avg_power = array_sum($powers)/count($powers);

        $session->save();
    }




}
