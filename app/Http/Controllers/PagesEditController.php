<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class PagesEditController extends Controller
{
  public function execute(Page $page,Request $request) {
    if($request->isMethod('DELETE')) {
      if($request->user()->cannot('isAdmin',$page)) {
        return redirect()->route('pages')->withErrors(['message'=>'У вас нет прав']);
      };
      $page->delete();

      return redirect('admin/pages')->with('status','Страница удалена');
    }

    if($request->isMethod('POST')) {
      $input = $request->except('_token');

      $validator = Validator::make($input,[
        'name'=>'required|max:255',
        'alias'=>['required','max:255',Rule::unique('pages')->ignore($input['id'])],
        'text'=>'required'
      ]);
      if($validator->fails()) {
        return redirect()->route('pagesEdit',['page'=>$input['id']])->withErrors($validator)->withInput();
      }

      if($request->user()->cannot('isAdmin',$page)) {
        return redirect()->route('pages')->withErrors(['message'=>'У вас нет прав']);
      };

      if($request->hasFile('images')) {
        $file = $request->file('images');
        $input['images'] = $file->getClientOriginalName();
        $file->move(public_path().'/assets/img',$input['images']);
      }
      else {
        $input['images'] = $input['old_images'];
      }

      unset($input['old_images']);

      $page->name = $input['name'];
      $page->alias = $input['alias'];
      $page->text = $input['text'];
      $page->images = $input['images'];
      if($page->update()) {
        return redirect('admin/pages')->with('status','Страница обновлена');
      }
    }

    $old = $page->toArray();

    if(view()->exists('admin.pages_edit')) {
      $data = [
        'title'=>'Редактирование страницы - '.$old['name'],
        'data'=>$old,
      ];

      return view('admin.pages_edit',$data);
    }
    return abort(404);
  }
}
