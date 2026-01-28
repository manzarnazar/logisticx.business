<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Repositories\Profile\ProfileInterface;

class ProfileController extends Controller
{
    protected $repo;

    public function __construct(ProfileInterface $repo)
    {
        $this->repo = $repo;
    }

    public function profile()
    {
        $user = auth()->user();
        return view('backend.profile.profile', compact('user'));
    }

    public function profileEdit()
    {
        $user = auth()->user();
        return view('backend.profile.profile-update', compact('user'));
    }

    public function passwordEdit()
    {
        $user = auth()->user();
        return view('backend.profile.password-update', compact('user'));
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('profile')->with('success', $result['message']);
        }
        return  redirect()->route('profile.edit')->with('danger', $result['message'])->withInput();
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        $result = $this->repo->passwordUpdate($request);
        if ($result['status']) {
            return redirect()->route('profile')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }
}
