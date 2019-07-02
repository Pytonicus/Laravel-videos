<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
// Cargamos la entidad video que tiene el modelo:
use App\Video;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   // Cambiamos el middelware auth por web para no tener que autenticarse obligatoriamente:
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->paginate(5); 
        return view('home', array(
            'videos' => $videos
        ));
    }
}
