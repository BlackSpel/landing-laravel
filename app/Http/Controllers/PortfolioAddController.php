<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use Validator;

class PortfolioAddController extends Controller
{
  public function execute(Request $request) {
    if(view()->exists('admin.portfolio_add')) {
      if($request->isMethod('POST')) {
        $input = $request->except('_token');

        $massages = [
          'required'=>'Поле :attribute обязательно к заполнению',
        ];

        $validator = Validator::make($input, [
          'name'=>'required|max:255',
          'filter'=>'required|max:255',
        ], $massages);
        if($validator->fails()) {
          return redirect()->route('portfolioAdd')->withErrors($validator)->withInput();
        }

        $portfolio = new Portfolio();
        if($request->user()->cannot('isAdmin',$portfolio)) {
          return redirect()->route('portfolios')->withErrors(['message'=>'У вас нет прав']);
        };

        if($request->hasFile('images')) {
          $file = $request->file('images');
          $input['images'] = $file->getClientOriginalName();
          $file->move(public_path().'/assets/img',$input['images']);
        }

        $portfolio = Portfolio::create([
          'name'=>$input['name'],
          'filter'=>$input['filter'],
          'images'=>$input['images'],
        ]);
        if($portfolio) return redirect('admin/portfolios')->with('status','Портфолио добавлено');
      }

      $data = ['title'=>'Новое портфоло'];

      return view('admin.portfolio_add',$data);
    }
    return abort(404);
  }
}
