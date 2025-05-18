<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
class SheetController extends Controller
{

    public function sheets()
    {
      $sheets = Sheet::all()->groupBy('row');
      return view('movies.sheets', compact('sheets'));
    }
}