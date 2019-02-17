<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perhitungan;
use App\Desa;


class PerhitunganjemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role:Admin']);
    }

    public function index()
    {
        $desa = Desa::Dropdowndesa();
        return view('perhitunganjember.index', compact('desa'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $count = Perhitungan::where(['status' => 1, 'id_tps' => $request->id_desa])->count();

            if ($count == 0) {
                $perhitunganjember = new Perhitungan;
                $perhitunganjember->id_tps = $request->id_desa;
                if ($perhitunganjember->save()) {
                    return response()->json(['success' => '1']);
                }
                return response()->json(['errors' => '1', 'msg' => "Gagal Menambahkan Data Dapil VI(Jember)"]);
            } else {
                return response()->json(['errors' => '1', 'msg' => 'Data Tps Sudah Ada']);
            }

        } catch (Exception $e) {
            return response()->json(['errors' => '1']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Request $request)
    {
        try {
            $perhitungan = Perhitungan::find($request->id);
            $perhitungan->id_tps = $request->iddesa;

            if ($perhitungan->save()) {
                return response()->json(['success' => '1']);

            }

            return response()->json(['errors' => '1']);
        } catch (Exception $e) {
            return response()->json(['errors' => '1']);
        }
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
        try {
            $perhitungan = Perhitungan::find($request->id);
            $perhitungan->status = 0;
            $perhitungan->save();
            return response()->json(['success' => '1']);
        } catch (Exception $e) {
            return response()->json(['errors' => '1']);
        }
    }

    public function getPerhitunganjember()
    {
        $perhitungan = Perhitungan::Listperhitungan();

        return response()->json(array('data' => $perhitungan));
    }
}