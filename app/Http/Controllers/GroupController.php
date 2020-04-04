<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Group;

class GroupController extends Controller
{

    public function index()
    {
        $groups = Group::orderBy('updated_at', 'desc')->get();

        return response()
            ->json([
                'groups' => $groups
            ]);
    }

    public function create()
    {
        $form = Group::form();

        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(GroupStoreRequest $request)
    {
        $name = $request['name'];
        $group = new Group();
        $group->name = $name;
        $group->save();

        return response()
            ->jason([
                'saved'     => true,
                'id'        => $group->id,
                'message'   => 'Ha ingresado correctamente el grupo de actividades!'
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request,$id)
    {
        $form = Group::findOrFail($id);

        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update(GroupUpdateRequest $request, $id)
    {
        $group = Group::find($id);
        $group->fill($request->all())->save();

        return response()
            ->json([
                'saved'     => true,
                'form'      => $group,
                'message'   => 'Ha actualizado correctamente el grupo de actividades!'
            ]);
    }

    public function destroy(Request $request, $id)
    {
        $group = Group::find($id)->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
