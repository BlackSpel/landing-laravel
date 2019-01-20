<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Portfolio;

class PortfolioEditController extends Controller
{
  public function execute(Portfolio $portfolio,Request $request) {
    if($request->isMethod('DELETE')) {
      if($request->user()->cannot('isAdmin',$portfolio)) {
        return redirect()->route('portfolios')->withErrors(['message'=>'У вас нет прав']);
      };
      $portfolio->delete();

      return redirect('admin/portfolios')->with('status','Портфолио удалено');
    }

    if($request->isMethod('POST')) {
      $input = $request->except('_token');

      $validator = Validator::make($input,[
        'name'=>'required|max:255',
        'filter'=>'required|max:255'
      ]);
      if($validator->fails()) {
        return redirect()->route('portfolioEdit',['portfolio'=>$input['id']])->withErrors($validator)->withInput();
      }

      if($request->user()->cannot('isAdmin',$portfolio)) {
        return redirect()->route('portfolios')->withErrors(['message'=>'У вас нет прав']);
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

      $portfolio->name = $input['name'];
      $portfolio->filter = $input['filter'];
      $portfolio->images = $input['images'];
      if($portfolio->update()) {
        return redirect('admin/portfolios')->with('status','Портфолио обновлено');
      }
    }
    $old = $portfolio->toArray();

    if(view()->exists('admin.portfolio_edit')) {
      $data = [
        'title'=>'Редактирование портфолио - '.$old['name'],
        'data'=>$old,
      ];

      return view('admin.portfolio_edit',$data);
    }
    return abort(404);
  }
}
