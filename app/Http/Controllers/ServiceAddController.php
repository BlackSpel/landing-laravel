<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Validator;

class ServiceAddController extends Controller
{
  public function execute(Request $request) {
    if(view()->exists('admin.service_add')) {
      if($request->isMethod('POST')) {
        $input = $request->except('_token');

        $massages = [
          'required'=>'Поле :attribute обязательно к заполнению',
        ];

        $validator = Validator::make($input, [
          'name'=>'required|max:255',
          'text'=>'required|max:255',
          'icon'=>'required|max:255',
        ], $massages);
        if($validator->fails()) {
          return redirect()->route('serviceAdd')->withErrors($validator)->withInput();
        }

        $service = new Service();
        if($request->user()->cannot('isAdmin',$service)) {
          return redirect()->route('services')->withErrors(['message'=>'У вас нет прав']);
        };

        $service = Service::create([
          'name'=>$input['name'],
          'text'=>$input['text'],
          'icon'=>$input['icon'],
        ]);
        if($service) return redirect('admin/services')->with('status','Страница добавлена');
      }

      $data = ['title'=>'Новый сервис'];

      return view('admin.service_add',$data);
    }
    return abort(404);
  }
}
