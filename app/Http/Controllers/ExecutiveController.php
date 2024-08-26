<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExecutiveRequest;
use App\Traits\HandlesTransaction;
use App\Services\Executive\ViewClass;
use App\Services\Executive\SaveClass;
use App\Services\Executive\UpdateClass;

class ExecutiveController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save, UpdateClass $update){
        $this->view = $view;
        $this->save = $save;
        $this->update = $update;
    }

    public function index(Request $request){
        switch($request->option){
            case 'users':
                return $this->view->users($request);
            break;
            case 'roles':
                return $this->view->roles($request);
            break;
            case 'menus':
                return $this->view->menus($request);
            break;
            case 'authentications':
                return $this->view->authentications($request);
            break;
            case 'activities':
                return $this->view->activities($request);
            break;
            case 'backups':
                return $this->view->backups($request);
            break;
            default:
                return inertia('Administrator/Dashboard/Index'); 
        }   
    }

    public function show($code){
        switch($code){
            case 'users':
                return inertia('Administrator/Users/Index');
            break;
            case 'roles':
                return inertia('Administrator/Roles/Index');
            break;
            case 'menus':
                return inertia('Administrator/Menus/Index');
            break;
            case 'authentications':
                return inertia('Administrator/Authentications/Index');
            break;
            case 'activities':
                return inertia('Administrator/Activities/Index');
            break;
            case 'backups':
                return inertia('Administrator/Backups/Index');
            break;
           default:
                return $this->view->backupdownload($code);
        }
    }

    public function store(ExecutiveRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'user':
                    return $this->save->user($request);
                break;
                case 'role':
                    return $this->save->role($request);
                break;
                case 'menu':
                    return $this->save->menu($request);
                break;
                case 'backup':
                    return $this->save->backup($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'user':
                    return $this->update->user($request);
                break;
                case 'role':
                    return $this->update->role($request);
                break;
                case 'menu':
                    return $this->update->menu($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
