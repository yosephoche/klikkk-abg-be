<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Polling;

class PollingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $polling = new Polling();
        if ($request->has('search')) {
            $polling = $polling->where('question', 'like','%'.$request->search.'%');
        }
        $polling = $polling->paginate(10);

        return dtcApiResponse(200,$polling);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $polling = new Polling();
        $polling->question = $request->question;
        $polling->save();

        return dtcApiResponse(200, $polling, 'Polling berhasi di simpan');
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
        $polling = Polling::findOrFail($id);

        return dtcApiResponse(200, $polling);
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
        $polling = Polling::findOrFail($id);
        $polling->question = $request->question;

        return dtcApiResponse(200, $polling, 'Polling berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $polling = Polling::findOrFail($id);
        $polling->delete();
        return dtcApiResponse(200, $polling, 'Polling berhasil di hapus');
    }
}
