<?php

namespace Wave\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends \App\Http\Controllers\Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(setting('auth.dashboard_redirect', true) != "null"){
    		if(!\Auth::guest()){
    			return redirect('dashboard');
    		}
    	}

        $seo = [

            'title'         => setting('site.title', 'AMW'),
            'description'   => setting('site.description', ''),
            'image'         => url('/og_image.png'),
            'type'          => 'website'

        ];

        return view('theme::home', compact('seo'));
    }
}
