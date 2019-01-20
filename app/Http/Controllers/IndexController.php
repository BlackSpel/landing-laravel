<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Page,People,Portfolio,Service};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class IndexController extends Controller
{
    public function execute(Request $request) {
      if($request->isMethod('POST')) {
        $messages = [
          'required'=>'Поле :attribute обязательно к заполнению',
          'email'=>'Поле :attribute должно соответствовать email адресу',
        ];

        $this->validate($request, [
          'name'=>'required|max:255',
          'email'=>'required|email',
          'text'=>'required'
        ], $messages);

        return redirect()->route('main','#contact')->with('status', 'Письмо успешно отправлено!');
      }

      $pages = Page::all();
      $portfolios = Portfolio::all();
      $services = Service::all();
      $peoples = People::all();
      $tags = DB::table('portfolios')->distinct()->pluck('filter');
      $menu = [];

      foreach ($pages as $page){
        $item = ['title'=>$page->name,'alias'=>$page->alias];
        array_push($menu, $item);
      }

      $item = ['title'=>'Services','alias'=>'services'];
      array_push($menu, $item);
      $item = ['title'=>'Portfolio','alias'=>'portfolio'];
      array_push($menu, $item);
      $item = ['title'=>'Team','alias'=>'team'];
      array_push($menu, $item);
      $item = ['title'=>'Contact','alias'=>'contact'];
      array_push($menu, $item);

      if(!Auth::check()) {
        Auth::loginUsingId(1, true);
      }

      return view('site.index',['menu'=>$menu,'pages'=>$pages,'services'=>$services,'portfolios'=>$portfolios,'peoples'=>$peoples,'tags'=>$tags,'old'=>old()]);
    }
}