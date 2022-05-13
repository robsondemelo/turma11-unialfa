<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $series = Serie::get();
       $mensagem= $request->session()->get('mensagem');


       return view('series.index', compact('series','mensagem'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeriesFormRequest $request)
    {

        $serie = Serie::create(['name'=>$request->name]);

        $qtdTemporadas = $request->qtd_temporadas;
        for($i=1; $i<= $qtdTemporadas; $i++){
            $temporada =$serie->temporadas()->create(['numero'=> $i]);

            for($j=1; $j<= $request->ep_por_temporada; $j++){
                $temporada->episodios()->create(['numero'=>$j]);
            }
        }

        $request->session()->flash('mensagem',"Serie {$serie->id} e suas temporadas e episódios criados com sucesso {$serie->name}");

        return redirect('series');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        Serie::destroy($request->id);
       $request->session()->flash('mensagem',"Serie removida com sucesso.");

       return redirect('/series');

    }
}
