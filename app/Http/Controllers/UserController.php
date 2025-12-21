<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function users()
    {
        return view('pages.users');
    }
    // public function getUsers(Request $request)
    // {
    //     $users = User::select(['id', 'username', 'employee_id'])->with('employee')
    //     ->employeeActiveOrPending()
    //         ->get()
    //         ->map(function ($user) {
    //             $user->id_hashed = substr(hash('sha256', $user->id . env('APP_KEY')), 0, 8);
    //             $user->action = '
    //             <a href="' . route('editusers', $user->id_hashed) . '" class="mx-3" data-bs-toggle="tooltip" title="Edit User: ' . e($user->username) . '">
    //                 <i class="fas fa-user-edit text-secondary"></i>
    //             </a>';
    //             return $user;
    //         });
    //     return DataTables::of($users)
    //      ->addColumn('employee_name', fn($user) => optional($user->employee)->employee_name ?? 'Empty')
    //     ->addColumn('company_name', fn($user) => optional(optional($user->employee)->company)->name ?? 'Empty')
    //     ->addColumn('department_name', fn($user) => optional(optional($user->employee)->department)->department_name ?? 'Empty')
    //     ->addColumn('store_name', fn($user) => optional(optional($user->employee)->store)->name ?? 'Empty')
    //     ->addColumn('position_name', fn($user) => optional(optional($user->Employee)->position)->name ?? 'Empty')
    //         ->rawColumns(['action','employee_name','company_name','department_name','store_name','position_name'])
    //         ->make(true);
    // }
    public function getUsers(Request $request)
{
    // $query = User::select([
    //         'users.id',
    //         'users.username',
    //         'users.employee_id',
    //     ])
    //     ->with([
    //         'employee.company',
    //         'employee.department',
    //         'employee.store',
    //         'employee.position',
    //     ])
    //     ->employeeActiveOrPending();
    $query = User::query()
    ->select([
        'users.id',
        'users.username',
        'users.employee.employee_name',
        'employee.company.name as company_name',
        'employee.department.department_name',
        'employee.store.name as store_name',
        'employee.position.name as position_name',
    ])
    ->join('employees_tables', 'employee.id', '=', 'users.employee_id')
    // ->leftJoin('company_tables', 'company.id', '=', 'employee.company_id')
    // ->leftJoin('departments_tables', 'department.id', '=', 'employee.department_id')
    // ->leftJoin('stores_tables', 'store.id', '=', 'employee.store_id')
    // ->leftJoin('position_tables', 'position.id', '=', 'employee.position_id')
    ->employeeActiveOrPending();


    return DataTables::eloquent($query)
        ->addColumn('employee_name', function ($user) {
            return optional($user->employee)->employee_name ?? 'Empty';
        })
        // ->addColumn('company_name', function ($user) {
        //     return optional(optional($user->employee)->company)->name ?? 'Empty';
        // })
        // ->addColumn('department_name', function ($user) {
        //     return optional(optional($user->employee)->department)->department_name ?? 'Empty';
        // })
        // ->addColumn('store_name', function ($user) {
        //     return optional(optional($user->employee)->store)->name ?? 'Empty';
        // })
        // ->addColumn('position_name', function ($user) {
        //     return optional(optional($user->employee)->position)->name ?? 'Empty';
        // })
        ->addColumn('action', function ($user) {
            $idHashed = substr(hash('sha256', $user->id . env('APP_KEY')), 0, 8);

            return '
                <a href="' . route('editusers', $idHashed) . '" 
                   data-bs-toggle="tooltip" 
                   title="Edit User: ' . e($user->username) . '">
                    <i class="fas fa-user-edit text-secondary"></i>
                </a>';
        })
        ->rawColumns(['action'])
        ->make(true);
}
    public function edit($hashedId)
    {
        $user = User::get()->first(function ($u) use ($hashedId) {
            $expectedHash = substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8);
            return $expectedHash === $hashedId;
        });
        if (!$user) {
            abort(404, 'User not found.');
        }
        $userStatus = ['Active', 'Inactive'];
        $selectedStatus = old('status', $user->Employee->status ?? '');
        // $roles = Role::pluck('name', 'name')->all();
        // Change selectedRole to use name instead of id
        $selectedRole = old('role', optional($user->roles->first())->name ?? '');
        return view('pages.dashboardAdmin.edit', [
            'user' => $user,
            'hashedId' => $hashedId,
            'userStatus' => $userStatus,
            'selectedStatus' => $selectedStatus,
            // 'roles' => $roles,
            'selectedRole' => $selectedRole
        ]);
    }
    // public function edit($hashedId)
    // {
    //     $user = User::with('terms', 'roles.permissions', 'Employee')->get()->first(function ($u) use ($hashedId) {
    //         $expectedHash = substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8);
    //         return $expectedHash === $hashedId;
    //     });
    //     if (!$user) {
    //         abort(404, 'User not found.');
    //     }
    //     $userStatus = ['Active', 'Inactive'];
    //     $selectedStatus = old('status', $user->Employee->status ?? '');
    //     $roles = Role::pluck('name', 'name')->all();
    //     // Change selectedRole to use name instead of id
    //     $selectedRole = old('role', optional($user->roles->first())->name ?? '');
    //     return view('pages.dashboardAdmin.edit', [
    //         'user' => $user,
    //         'hashedId' => $hashedId,
    //         'userStatus' => $userStatus,
    //         'selectedStatus' => $selectedStatus,
    //         'roles' => $roles,
    //         'selectedRole' => $selectedRole
    //     ]);
    // }
}
 // ✅ Tambahkan kolom checkbox
        // ->addColumn('checkbox', function ($user) {
        //     return '<input type="checkbox" class="user-checkbox" value="' . e($user->id) . '">';
        // })
        // ->addColumn('roles', function ($user) {
        //     if (is_array($user->roles)) {
        //         return implode(', ', $user->roles);
        //     } elseif ($user->roles instanceof \Illuminate\Support\Collection) {
        //         return $user->roles->pluck('name')->implode(', ');
        //     }
        //     return 'Empty';
        // })
        // ->addColumn('device_lan_mac', fn($user) => optional($user->Terms)->device_lan_mac ?? 'Empty')
        // ->addColumn('employee_name', fn($user) => optional($user->Employee)->employee_name ?? 'Empty')
        // ->addColumn('store_name', fn($user) => optional(optional($user->Employee)->store)->name ?? 'Empty')
        // ->addColumn('position_name', fn($user) => optional(optional($user->Employee)->position)->name ?? 'Empty')
        // ->addColumn('pin', fn($user) => optional($user->Employee)->pin ?? 'Empty')
        // ->addColumn('device_wifi_mac', fn($user) => optional($user->Terms)->device_wifi_mac ?? 'Empty')
        // ->addColumn('status', fn($user) => optional($user->Employee)->status ?? 'Empty')