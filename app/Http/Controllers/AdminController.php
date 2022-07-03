<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\SysConfig;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiNotificationController;


class AdminController extends Controller
{



    public function bullTrigger()
    {

        $tables = \DB::select('SHOW TABLES');
        foreach ($tables as $table) {

            \DB::table($table->Tables_in_mange)->truncate();
        }

        return "Updated successfully";
    }


    public function dashboard()
    {




        // $clearconfig = \Artisan::call('config:cache');
        // $response = ApiNotificationController::cancel_nofitication("b98881cc-1e94-4366-bbd9-db8f3429292b");
        // dd($response); 
        // $response =  ApiNotificationController::sendNotifications("TEST NOTIFICATIONS","Team MangeKimambi App We love You",12);
        // dd($response);


        //  $details = [
        //          'title' => 'Mange kimambi App password recovery',
        //          'body' => 'Habari Mwaps Tumekutumia Link ya kubadili password yako. Email hii itakupa Access ya kuingia kwenye akaunti yako maramoja tu hivyo ukiingia badili password yako.',
        //          'url' => "john mwapinga"
        //      ];
        // $mail =   \Mail::to("johnmwapinga@gmail.com")->send(new \App\Mail\RecoveryPasswordEmail($details));

        //    dd($mail);

        return View('v3.backend.dashboard');
    }



    public function index()
    {
        //
        $vars['title'] = "Staffs";
        $vars['sub_title'] = "Add staffs";

        $vars['users'] = Admin::get();

        return View('v3.backend.admins.index', compact('vars'));
    }



    public function sys_configs(Request $request)
    {
        //
        $SysConfig = SysConfig::first();
        $SysConfig->update($request->all());

        // return response()->json('Done');
        return response()->json([
            'status' => true,
            'message' => 'Settings saved.',
            'redirect_to' => route('sys_configs.store')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email|unique:admins|max:255',
            'phone' => 'required|regex:/[0-9]{4}[0-9]{6}/|unique:admins|max:20',
            'password' => 'required',
        ]);

        $input = $request->all();


        $input['password'] = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 10]);
        $users = Admin::create($input);
        $users->setting()->create([]);
        // $setting = PersonalSetting::create([
        //         'user_id' => $users->id,
        //     ]);
        if ($request->ajax()) {
            $view = view('backend.admins._tr', ['row' => $users])->render();
            // return response()->json($view);
            return response()->json([
                'status' => true,
                'message' => 'New User is added successfully Use the latest Foru digits of phone number as password.',
                'redirect_to' => route('admins.index')
            ]);
        } else {
            return redirect()->back()
                ->withMessage($users->name . 'is added successfull Use the latest Foru digits of phone number as password')
                ->with('flash_type', 'danger')
                ->with('flash_icon', 'fa-check-square-o');
        }
    }



    public function update(Request $request, $id)
    {
        $input = $request->all();

        if (!isset($input['editRolesOrPermissions'])) {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'email|unique:admins,email,' . decrypt($id) . '|max:255',
                'phone' => 'required|regex:/[0-9]{4}[0-9]{6}/|unique:admins,phone,' . decrypt($id) . '|max:20',
            ]);
        }

        $user = Admin::find(decrypt($id));
        if (isset($input['type'])) {
            if ($input['type'] == "role_id") {
                $user->syncRoles($input['role_id']);
                return redirect()->back()->withMessage($user->name . ' Roles Asigned successfully')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
            }


            if ($input['type'] == "permission_id") {
                if (!isset($input['permission_id'])) {
                    $input['permission_id'] = [];
                }

                $user->syncPermissions($input['permission_id']);
                return redirect()->back()->withMessage($user->name . ' Permission Asigned successfully')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
            }


            // if ($input['type'] == "office_id"){
            //     if(!isset($input['office_id'])){
            //         $input['office_id'] = [];
            //     }
            //     $user->office()->sync($input['office_id']);
            //     return redirect()->back()->withMessage($user->name . ' Office Asigned successfully')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');

            // }
        }

        $route = route('admins.index');
        if ($input['editFrom'] == "show") {
            $route = route('admins.show', encrypt($user->id));
        }

        $user->update($request->all());
        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => $user->name . ' is Updated successful',
                'redirect_to' => $route
            ]);
        }
        return redirect()->back()->withMessage($user->name . ' is Updated successful')->with('flash_type', 'success')->with('flash_icon', 'fa-check-square-o');
    }

    public function edit($id)
    {
        $users = Admin::find(decrypt($id));
        return response()->json([
            'error' => false,
            'users' => $users,
        ], 200);
    }

    public function show($id)
    {
        $vars['title'] = "Staff Profile";
        $vars['user'] = Admin::find(decrypt($id));
        $vars['position'] = "Staff";
        $vars['roles'] = Role::all();
        $vars['permissions'] = Permission::get();

        return view('v3.backend.admins._view', compact('vars'));
    }




    public function destroy($id)
    {
        $users = Admin::find($id);
        // $users->delete();
        // return \Response::Json('Delete Success', 200);
        return response()->json([
            'status' => true,
            'message' => "Your Record has been Deleted!",
            'redirect_to' => route('admins.index'),
        ]);
    }
}