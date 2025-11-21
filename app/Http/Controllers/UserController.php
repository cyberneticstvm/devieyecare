<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\UserDevice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    protected $branches, $devices, $roles;
    public function __construct()
    {
        $this->branches = Branch::pluck('name', 'id');
        $this->devices = Extra::where('category', 'device')->pluck('name', 'id');
        $this->roles = Role::where('team_id', teamId())->pluck('name', 'name')->all();
    }

    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-delete'), only: ['destroy']),
        ];
    }

    public function index()
    {
        $users = User::withTrashed()->orderBy('name')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roles;
        $branches = $this->branches;
        $devices = $this->devices;
        return view('admin.user.create', compact('roles', 'branches', 'devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'password' => 'required|min:6',
            'roles' => 'required',
            'branches' => 'required',
            'devices' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles', 'devices'));
            $input['password'] = Hash::make($input['password']);
            DB::transaction(function () use ($request, $input) {
                $user = User::create($input);
                $user->assignRole($request->input('roles'), teamId());
                $branches = [];
                $devices = [];
                foreach ($request->branches as $key => $br) :
                    $branches[] = [
                        'user_id' => $user->id,
                        'branch_id' => $br,
                    ];
                endforeach;
                foreach ($request->devices as $key => $device) :
                    $devices[] = [
                        'user_id' => $user->id,
                        'device_id' => $device,
                    ];
                endforeach;
                UserBranch::insert($branches);
                UserDevice::insert($devices);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.list')->with("success", "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail(decrypt($id));
        $roles = $this->roles;
        $userRole = $user->roles->pluck('name', 'name')->all();
        $branches = $this->branches;
        $devices = $this->devices;
        return view('admin.user.edit', compact('user', 'roles', 'userRole', 'branches', 'devices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'mobile' => 'nullable|numeric|digits:10|unique:users,mobile,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
            'branches' => 'required',
            'devices' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles', 'devices'));
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            DB::transaction(function () use ($request, $input, $id) {
                $user = User::findOrFail($id);
                $user->update($input);
                $branches = [];
                $devices = [];
                foreach ($request->branches as $key => $br) :
                    $branches[] = [
                        'user_id' => $user->id,
                        'branch_id' => $br,
                    ];
                endforeach;
                foreach ($request->devices as $key => $device) :
                    $devices[] = [
                        'user_id' => $user->id,
                        'device_id' => $device,
                    ];
                endforeach;
                DB::table('model_has_roles')->where('model_id', $id)->where('team_id', teamId())->delete();
                DB::table('user_branches')->where('user_id', $id)->delete();
                DB::table('user_devices')->where('user_id', $id)->delete();
                $user->assignRole($request->input('roles'), teamId());
                UserBranch::insert($branches);
                UserDevice::insert($devices);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.list')->with("success", "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail(decrypt($id))->delete();
        UserBranch::where('user_id', decrypt($id))->delete();
        UserDevice::where('user_id', decrypt($id))->delete();
        return redirect()->route('user.list')->with("success", "User deleted successfully");
    }
}
