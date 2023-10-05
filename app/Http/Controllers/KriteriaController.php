<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\subKriteriaModel;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $data = KriteriaModel::all();
        // dd($data);
        return view('kriteria', [
            'kriteria' => $data
        ]);
    }

    public function indexModalNotes($id)
    {
        $data = KriteriaModel::all();

        $kriteria = KriteriaModel::where('kode_kriteria', $id)->first();

        return view('modalNotes', [
            'data' => $data,
            'kriteria' => $kriteria,
            'id' => $id
        ]);
    }

    public function home()
    {

        // dd($data);
        return view('home');
    }


    public function tambahKriteria(Request $request)
    {
        $x =  $request->kode_kriteria;
        // dd($x);
        $dataKriteria = KriteriaModel::all();
        $cekBatas = 0;
        foreach ($dataKriteria as $key) {
            $cekBatas = $cekBatas + $key->bobot;
        }
        $bobot = $request->bobot / 100;
        $cekBatas = $cekBatas + $bobot;
        // dd($cekBatas);
        if ($cekBatas > 1) {
            return redirect()->back()->withErrors(['message' => 'Bobot Sudah melebihi 100%']);
        }
        if ($request->keterangan == '--Pilih Item--') {
            return redirect()->back()->withErrors(['message' => 'Isi Kolom Keterangan terlebih dahulu']);
        }
        KriteriaModel::create([
            'kode_kriteria' => $x,
            'jenis_kriteria' => $request->jenis_kriteria,
            'bobot' => $request->bobot / 100,
            'keterangan' => $request->keterangan
        ]);
        return redirect("/kriteria");
    }

    public function indexSub()
    {
        $data = KriteriaModel::all();
        if ($data->first() == null) {
            return redirect()->back();
        } else {
            $dataCount = KriteriaModel::count();
            for ($i = 0; $i < $dataCount; $i++) {
                ${'data' . $i} = $data->get($i);
                $dataJenis[] =  ${'data' . $i}->jenis_kriteria;
            }
            $sub1 = subKriteriaModel::where('cat_kriteria', 'C1')->get();
            $sub2 = subKriteriaModel::where('cat_kriteria', 'C2')->get();
            $sub3 = subKriteriaModel::where('cat_kriteria', 'C3')->get();
            $sub4 = subKriteriaModel::where('cat_kriteria', 'C4')->get();
            $sub5 = subKriteriaModel::where('cat_kriteria', 'C5')->get();
            // dd($sub1);
            return view('subKriteria', [
                'jenisKriteria' => $dataJenis,
                'dataCount' =>  $dataCount,
                'sub1' => $sub1, 'sub2' => $sub2, 'sub3' => $sub3, 'sub4' => $sub4, 'sub5' => $sub5,
            ]);
        }
    }

    public function tambahSub(Request $request, $i)
    {
        subKriteriaModel::create([
            'cat_kriteria' => $request->{'cat_kriteria' . $i},
            'nilai' => $request->nilai,
            'range' => $request->range,
            'kategori' => $request->kategori
        ]);
        return redirect("/subKriteria");
    }

    public function editKriteria($kode)
    {
        $data = KriteriaModel::where('kode_kriteria', $kode)->first();
        return response()->json($data);
    }

    public function updateKriteria(Request $request)
    {
        // dd($request->bobot);
        $kriteria = $request->kode_kriteria;
        KriteriaModel::where('kode_kriteria', $kriteria)
            ->update([
                'jenis_kriteria' => $request->jenis_kriteria,
                'bobot' => $request->bobot / 100,
                'keterangan' => $request->keterangan
            ]);

        return Redirect("/kriteria");
    }

    public function saveNotes(Request $request, $id)
    {
        // dd($request->bobot);
        $kriteria = $id;
        KriteriaModel::where('kode_kriteria', $kriteria)
            ->update([
                'notes' => $request->notes,
            ]);

        return Redirect("/kriteria");
    }

    public function validasi($id)
    {
        // dd($request->bobot);
        $kriteria = $id;
        KriteriaModel::where('kode_kriteria', $kriteria)
            ->update([
                'status' => 'ACC'
            ]);

        // return Redirect("/kriteria");
    }



    public function destroy($kode)
    {
        $data = KriteriaModel::all();

        $delete = $data->where('kode_kriteria', $kode)->first();
        $delete->delete();

        return view('kriteria', [
            'kriteria' => $data
        ]);
    }

    public function editsubKriteria($id)
    {
        $data = subKriteriaModel::where('id', $id)->first();
        return response()->json($data);
    }

    public function updateSubKriteria(Request $request)
    {

        $id = $request->id;
        subKriteriaModel::where('id', $id)
            ->update([
                'nilai' => $request->nilai,
                'range' => $request->range,
                'kategori' => $request->kategori
            ]);
        return Redirect("/subKriteria");
    }

    public function destroySub($id)
    {
        $datasub = subKriteriaModel::all();
        $data = KriteriaModel::all();
        $id = intval($id);
        $dataCount = KriteriaModel::count();
        for ($i = 0; $i < $dataCount; $i++) {
            ${'data' . $i} = $data->get($i);
            $dataJenis[] =  ${'data' . $i}->jenis_kriteria;
        }
        $sub1 = subKriteriaModel::where('cat_kriteria', 'C1')->get();
        $sub2 = subKriteriaModel::where('cat_kriteria', 'C2')->get();
        $sub3 = subKriteriaModel::where('cat_kriteria', 'C3')->get();
        $sub4 = subKriteriaModel::where('cat_kriteria', 'C4')->get();
        $sub5 = subKriteriaModel::where('cat_kriteria', 'C5')->get();

        $delete = $datasub->where('id', $id)->first();
        // dd($id);
        $delete->delete();

        return view('subKriteria', [
            'jenisKriteria' => $dataJenis,
            'dataCount' =>  $dataCount,
            'sub1' => $sub1, 'sub2' => $sub2, 'sub3' => $sub3, 'sub4' => $sub4, 'sub5' => $sub5,
        ]);
    }
}
