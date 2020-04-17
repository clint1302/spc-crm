<?php

namespace App\Http\Controllers;
use App\QuickLink;
use App\AreaOfPractice;
use App\Team;
use App\WebClientList;
use App\Testimonial;
use Illuminate\Http\Request;

class WelcomeController extends Controller {
    public function index() {
            $quicklinks = QuickLink::all();
            // $areyaofpractices = AreaOfPractice::all();
            $teams = Team::where('check_to_home', 1)
                    ->get();
            $WebClientLists = WebClientList::where('check_to_home', 1)
                    ->get();
            $areyaofpractices = AreaOfPractice::where('check_to_home', 1)
                    ->get();
                    $testimonials= Testimonial::query()
                    ->orderBy('testimonials.id', 'DESC')
                    ->get(['testimonials.*'])
                    ->toArray();
        return view('frontEnd.home.homeContent', compact('quicklinks', 'areyaofpractices', 'teams', 'WebClientLists', 'testimonials'));
    }

}
