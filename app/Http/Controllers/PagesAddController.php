<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesAddController extends Controller
{
  public function execute(Request $request) {
    if(view()->exists('admin.pages_add')) {
      if($request->isMethod('POST')) {
        $input = $request->except('_token');

        $massages = [
          'required'=>'Поле :attribute обязательно к заполнению',
          'unique'=>'Поле :attribute должно быть уникальным',
        ];

        $validator = Validator::make($input, [
          'name'=>'required|max:255',
          'alias'=>'required|unique:pages|max:255',
          'text'=>'required',
        ], $massages);
        if($validator->fails()) {
          return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
        }

        $page = new Page();
        if($request->user()->cannot('isAdmin',$page)) {
          return redirect()->route('pages')->withErrors(['message'=>'У вас нет прав']);
        };

        if($request->hasFile('images')) {
          $file = $request->file('images');
          $input['images'] = $file->getClientOriginalName();
          $file->move(public_path().'/assets/img',$input['images']);
        }

        $page = Page::create(['name'=>$input['name'],
          'alias'=>$input['alias'],
          'text'=>$input['text'],
          'images'=>$input['images'],
        ]);
        if($page) return redirect('admin/pages')->with('status','Страница добавлена');
      }

      $data = ['title'=>'Новая страница'];

      return view('admin.pages_add',$data);
    }
    return abort(404);
  }
}
