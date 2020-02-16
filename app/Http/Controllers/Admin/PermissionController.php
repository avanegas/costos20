<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;
use Auth;

class PermissionController extends Controller {
    /*
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);     //middleware
    }
*/
    public function index()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return response()
            ->json(['permissions' => $permissions]);
    }

    public function create()
    {
        $roles = Role::get();

        return response()
            ->json([
                'roles' => $roles
            ]);
        //return view('admin.permissions.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with('info', 'Permission'. $permission->name.' added!');
    }

    public function show($id)
    {
        return redirect('permissions');
    }

    public function edit($id)
    {
        $form= Permission::findOrFail($id);

        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $input = $request->all();
        $permission->fill($input)->save();

        return response()
            ->json([
                'saved'   => true,
                'id'      => $permission->id,
                'message' => 'Permiso actualizado con éxito!'
            ]);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permissions.index')
                ->with('info', 'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('info', 'Permission deleted!');
    }
}
