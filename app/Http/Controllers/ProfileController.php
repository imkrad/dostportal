<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\ActivityLog;
use App\Models\AuthenticationLog;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\AuthenticationResource;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index(Request $request){
        $options = $request->option;
        switch($options){
            case 'authentication-logs':
                return $this->authenticationLogs($request);
            break;
            case 'activity-logs':
                return $this->activityLogs($request);
            break;
            case 'statistics':
                return $this->statistics();
            break;
            case 'sessions':
                return $this->sessions($request);
            break;
              case 'sessions':
                return $this->sessions($request);
            break;
            default: 
            return inertia('Profile/Index');
        }
    }
   
    public function update(ProfileRequest $request){
        $data = UserProfile::where('id',\Auth::user()->id)->first();
        $data->firstname = $request->firstname;
        $data->middlename = $request->middlename;
        $data->lastname = $request->lastname;
        $data->save();
        
        return back()->with([
            'data' => $data,
            'message' => 'User update was successful!', 
            'info' => "You've successfully update user profile.",
            'status' => true
        ]);
    }

    public function authenticationLogs($request){
        $data = AuthenticationLog::with('user.profile')->where('user_id',\Auth::user()->id)->paginate($request->count);
        return AuthenticationResource::collection($data);
    }

    public function activityLogs($request){
        $data = ActivityLog::with('causer.profile')->orderBy('created_at','DESC')->paginate($request->count);
        return ActivityResource::collection($data);
    }

    public function sessions($request){
        // dd($request->session()->id);
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            \DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', \Auth::user()->id)
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request){
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function statistics(){
        return [
            [
                'name' => 'Successful Login',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => 'text-success',
                'total' => AuthenticationLog::where('user_id',\Auth::user()->id)->where('is_failed',0)->count()
            ],
            [
                'name' => 'Suspicious Login',
                'icon' => 'ri-error-warning-fill',
                'color' => 'text-warning',
                'total' =>  AuthenticationLog::where('user_id',\Auth::user()->id)->where('is_suspicious',1)->count()
            ],
            [
                'name' => 'Login Attempts',
                'icon' => 'ri-close-circle-fill',
                'color' => 'text-danger',
                'total' =>  AuthenticationLog::where('user_id',\Auth::user()->id)->where('is_failed',1)->count()
            ]
        ];
    }

    public function destroy(Request $request)
    {
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }
        // $guard->logoutOtherDevices($request->password);
        $this->deleteOtherSessionRecords($request);
        return back(303);
    }

    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }
        \DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }

    public function store(Request $request)
    {
        $user = User::findOrFail(\Auth::user()->id);
        $request->validate([
            'image' => 'required|image|max:2048' // Assuming maximum file size is 2MB
        ]);

        $user = \Auth::user();
        if ($user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        // Store the new profile picture
        $imagePath = $request->file('image')->store('profile-pictures', 'public');
        $user->profile->avatar = $imagePath;
        $user->profile->save();
    }
}
