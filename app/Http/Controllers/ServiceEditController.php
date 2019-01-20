<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Service;

class ServiceEditController extends Controller
{
  public function execute(Service $service,Request $request) {
    if($request->isMethod('DELETE')) {
      if($request->user()->cannot('isAdmin',$service)) {
        return redirect()->route('services')->withErrors(['message'=>'У вас нет прав']);
      };
      $service->delete();

      return redirect('admin/services')->with('status','Сервис удален');
    }

    if($request->isMethod('POST')) {
      $input = $request->except('_token');

      $validator = Validator::make($input,[
        'name'=>'required|max:255',
        'text'=>'required|max:255',
        'icon'=>'required',
      ]);
      if($validator->fails()) {
        return redirect()->route('serviceEdit',['service'=>$input['id']])->withErrors($validator)->withInput();
      }

      if($request->user()->cannot('isAdmin',$service)) {
        return redirect()->route('services')->withErrors(['message'=>'У вас нет прав']);
      };

      $service->name = $input['name'];
      $service->text = $input['text'];
      $service->icon = $input['icon'];
      if($service->update()) {
        return redirect('admin/services')->with('status','Сервис обновлен');
      }
    }

    $old = $service->toArray();

    if(view()->exists('admin.service_edit')) {
      $data = [
        'title'=>'Редактирование сервиса - '.$old['name'],
        'data'=>$old,
      ];

      return view('admin.service_edit',$data);
    }
    return abort(404);
  }
}
