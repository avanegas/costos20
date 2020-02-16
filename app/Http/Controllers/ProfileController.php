<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Str;

use App\Profile;
use App\Group;
use App\User;


class ProfileController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $form = Profile::form();

        return response()
            ->json([
                'form' => $form
            ]);

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->with([ 'user', 'location', 'user.groups', 'user.image'])->first();

        return response()
            ->json(['profile' => $profile
            ]);
    }

    public function edit(Request $request, $id)
    {
        $form = Profile::where('user_id', $id)->with(['user', 'location'])->first();
        $groups = Group::get();
        $assignedGroups = $form->user->groups->pluck('id')->toArray();
        //$this->authorize('pass', $post);

        return response()
            ->json([
                'form'           => $form,
                'groups'         => $groups,
                'assignedGroups' => $assignedGroups
            ]);
    }

    public function update(ProfileUpdateRequest $request, $id)
    {
        //dd($request->all());
        $profile = Profile::where('user_id', $id)->first();
        $profile->fill($request->all())->save();

        //IMAGE
        if($request->file('url')){
            $path = $this->getFileName($request->url);
            $request->url->move(base_path('public/images'), $path);
            $profile->user->image->fill(['url' => $path])->save();
        }

        //LOCATION
        $profile->location->fill(['country' => $request->country])->save();

        //GROUPS
        $profile->user->groups()->sync($request->get('groups'));


    }

    private function getFileName($file)
    {
        return Str::random(32).'.'.$file->extension();
    }
}
