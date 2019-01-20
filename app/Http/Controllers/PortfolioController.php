<?php

namespace App\Http\Controllers;

use App\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
  public function execute() {
    if(view()->exists('admin.portfolios')) {
      $portfolios = Portfolio::all();
      $data = [
        'title'=>'Портфолио',
        'portfolios'=>$portfolios,
      ];

      return view('admin.portfolios',$data);
    }
    return abort(404);
  }
}
