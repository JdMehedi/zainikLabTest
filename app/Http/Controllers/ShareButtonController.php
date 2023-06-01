<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ShortLink;
use Jorenvh\Share\ShareFacade;

class ShareButtonController extends Controller
{

    public function share()
    {
        $data = Customer::where('id', Auth()->user()->id)->first();
        $find = ShortLink::where('code', Auth()->user()->username)->first();
        $id = $data->id;

        $id = $data->id;
        $shareButton = ShareFacade::page($find->link . '/' . $id)
            ->facebook()
            ->twitter()
            ->whatsapp();
        return view('share', compact('data', 'shareButton'));
    }
}
