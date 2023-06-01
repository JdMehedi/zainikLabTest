<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminControllers extends Controller
{
    public function index()
    {
        $data['users'] = Customer::paginate(5);
        return view('users.index', $data);
    }

    public function destroy($id)
    {
        try {
            $user = Customer::find($id);
            if (!empty($user)) {
                Storage::delete($user->image);
                $user->delete();
                return redirect()->back()->with('success', 'user deleted successfully');
            }
        } catch (\Exception $er) {
            return redirect()->back()->with('error', 'user can not deleted', $er->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $user = Customer::find($id);
            if ($user->status == true) {
                $user->status = false;
            } else {
                $user->status = true;
            }
            if (!empty($user)) {
                $user->update();
                return redirect()->back()->with('success', 'user updated successfully');
            }
        } catch (\Exception $er) {
            return redirect()->back()->with('error', 'user can not deleted', $er->getMessage());
        }
    }
}
