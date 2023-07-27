<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Facade;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Facade::paginateVillages($numRows = 15), 200);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "code" => 'required',
            "district_code" => 'required',
            "name" => 'required',
        ]);   

        try {
            $id = DB::table('indonesia_villages')->insertGetId(["code" => $data['code'], "district_code" => $data['district_code'], "name" => $data['name']]);

            return response()->json([
                "message" => "ok",
                "id" => $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], $th->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        return response()->json(Facade::findVillage($id), 200);;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "district_code" => 'required',
            "name" => 'required',
        ]);   

        try {
            DB::update('update indonesia_villages set name = ?, district_code = ? where id = ?', [$id, $data['district_code'], $data['name']]);
        
            return response()->json([
                "message" => "ok",
                "id" => $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::delete('delete from indonesia_villages where id = ?', [$id]);  

            return response()->json("ok", 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
