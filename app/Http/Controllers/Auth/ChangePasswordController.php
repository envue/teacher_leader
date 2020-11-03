<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('auth.passwords.edit');
    }

    public function update(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('profile.password.edit')->with('message', __('global.change_password_success'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        /*abort_if(Gate::denies('google_calendar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');*/
        
        $user = auth()->user();

        $user->update($request->validated());

        return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    }

    public function updateGoogleCalendarId(Request $request)
    {
        
        $user = auth()->user();

        $google_calendar = $request->google_calendar;

        $user->update(['google_calendar'=>$google_calendar]);
        

        return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    }

    public function updateHiddenWorkTypes(Request $request)
    {
        $user = auth()->user();
        
        if ( !empty( $request->except('_token') ) ) {
            $hidden_work_types = $request->input('hidden_work_types');
            $user->hidden_work_types = implode(',', $hidden_work_types);
        } else {
            $user->hidden_work_types = null;
        }

        $user->save();

        return redirect()->route('admin.time-work-types.index')->with('message', __('Settings updated successfully'));
        
        
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }
}
