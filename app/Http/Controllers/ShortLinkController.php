<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;


class ShortLinkController extends Controller
{
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortLink', compact('shortLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url'
        ]);

        $input['link'] = $request->link;
        $input['code'] = Auth::user()->username;

        ShortLink::create($input);

        return redirect('gen-short-link')
            ->with('success', 'Shorten Link Generated Successfully!');
    }

    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();
        return redirect($find->link);
    }
}
