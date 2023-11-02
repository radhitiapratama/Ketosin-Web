<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\Kandidat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\PesertaImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class PesertaController extends Controller
{
    protected $tipeses = [
        '1' => "Siswa",
        '2' => "Guru",
        '3' => "Karyawan",
    ];

    protected $tingkatans = [
        '1' => "X",
        '2' => "XI",
        '3' => "XII",
    ];

    protected $statuses = [
        '1' => "Aktif",
        '0' => "Nonaktif",
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columnsSearch = ['p.nama_peserta'];

            $table = DB::table('peserta as p');

            if ($request->input("search.value")) {
                $table->where(function ($q) use ($columnsSearch, $request) {
                    foreach ($columnsSearch as $column) {
                        $q->orWhere($column, 'like', '%' . $request->input("search.value") . "%");
                    }
                });
            }

            $sql_peserta = $table
                ->select('p.*', 'k.nama_kelas')
                ->leftJoin('kelas as k', 'k.id_kelas', '=', 'p.id_kelas');

            if ($request->tipe != null) {
                $sql_peserta->where("p.tipe", $request->tipe);
            }

            if ($request->tingkatan != null) {
                $sql_peserta->where("p.tingkatan", $request->tingkatan);
            }

            if ($request->kelas != null) {
                $sql_peserta->where("p.id_kelas", $request->kelas);
            }

            if ($request->status != null) {
                $sql_peserta->where("p.status", $request->status);
            }

            $count = $sql_peserta->count();

            $result = $sql_peserta->offset($request->start)
                ->limit($request->length)
                ->orderBy("p.id_peserta", 'ASC')
                ->get();

            $data = [];
            if (!empty($result)) {
                $i = $request->start;
                foreach ($result as $row) {
                    $i++;

                    $tingkatan = $this->checkTingkatan($row->tingkatan);
                    $status =  $this->checkStatus($row->status);
                    $subData = [];
                    $subData['no'] = $i;
                    $subData['nama_peserta'] = $row->nama_peserta;
                    $subData['tipe'] = $this->checkTipe($row->tipe);
                    $subData['kelas'] = $tingkatan . " " . $row->nama_kelas;
                    $subData['status'] = '
                    <div class="text-center"> ' . $status . ' </div>
                    ';


                    $subData['action'] = '
                    <div class="d-flex justify-content-center gap-20 text-center">
                        <a href="/peserta/vote/' . $row->id_peserta . '" class="badge badge-info p-2">
                            <i class="ri-radio-button-line"></i>
                        </a>
                        <button type="button" class="badge badge-primary p-2 btn-detail-qr"
                            data-qr-value="' . $row->qr_code . '" data-toggle="modal" data-target="#modalQr">
                            <i class="ri-qr-code-line"></i>
                        </button>
                        <a href="/peserta/edit/' . $row->id_peserta . '" class="badge badge-warning p-2">
                            <i class="ri-pencil-line"></i>
                        </a>
                    </div>
                    ';

                    $data[] = $subData;
                }
            }

            return response()->json([
                'draw' => $request->draw,
                'recordsFiltered' => $count,
                'recordsTotal' => $count,
                'data' => $data,
            ]);
        }

        $sql_kelas = Kelas::where("status", 1)
            ->get();

        $dataToView = [
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans,
            'kelases' => $sql_kelas,
            'statuses' => $this->statuses,
        ];

        return view("peserta.index", $dataToView);
    }

    public function add()
    {
        $sql_kelas = Kelas::where("status", 1)->get();

        $dataToView = [
            'kelases' => $sql_kelas,
            'tipeses' => $this->tipeses,
            "tingkatans" => $this->tingkatans,
        ];

        return view("peserta.add", $dataToView);
    }

    public function store(Request $request)
    {
        $validator1  = Validator::make($request->all(), [
            'tipe' => "required",
        ]);

        if ($validator1->fails()) {
            return redirect()->back()->withInput()->withErrors($validator1);
        }

        $tipe = $request->tipe;

        if ($tipe == 1) {
            $validator = Validator::make($request->all(), [
                'nama_peserta' => "required|unique:peserta,nama_peserta",
                'tipe' => "required",
                'tingkatan' => "required",
                'kelas' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            Peserta::create([
                'nama_peserta' => $request->nama_peserta,
                'tipe' => $request->tipe,
                'qr_code' => Str::random(40),
                'tingkatan' => $request->tingkatan,
                'id_kelas' => $request->kelas,
            ]);
        }

        if ($tipe == 2 || $tipe == 3) {
            $validator = Validator::make($request->all(), [
                'nama_peserta' => "required|unique:peserta,nama_peserta",
                'tipe' => "required",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            Peserta::create([
                'nama_peserta' => $request->nama_peserta,
                'tipe' => $request->tipe,
                'qr_code' => Str::random(40),
                'tingkatan' => null,
                'id_kelas' => null,
            ]);
        }

        return redirect("/peserta")->with("successAdd", "successAdd");
    }

    public function edit($id_peserta)
    {
        if (empty($id_peserta)) {
            return redirect("peserta");
        }

        $sql_peserta = Peserta::where("id_peserta", $id_peserta)->first();

        if (empty($sql_peserta)) {
            return redirect("peserta");
        }

        $sql_kelas = Kelas::where("status", 1)->get();
        $sql_kandidat = Kandidat::where("id_ketua", $id_peserta)->orWhere("id_wakil", $id_peserta)->first();

        $dataToView = [
            'peserta' => $sql_peserta,
            'tipeses' => $this->tipeses,
            'tingkatans' => $this->tingkatans,
            'statuses' => $this->statuses,
            'kelases' => $sql_kelas,
            'isKandidat' => 0,
        ];

        if (!empty($sql_kandidat)) {
            $dataToView['isKandidat'] = 1;
        }

        return view("peserta.edit", $dataToView);
    }

    public function update(Request $request)
    {
        $validator1 = Validator::make($request->all(), [
            'isKandidat' => "required",
        ]);

        if ($validator1->fails()) {
            return redirect()->back()->withInput()->withErrors($validator1);
        }

        $isKandidat = $request->isKandidat;
        $tipe = $request->tipe;

        // check jika kandidat
        if ($isKandidat) {
            $validator = Validator::make($request->all(), [
                'nama_peserta' => "required",
                'tingkatan' => "required",
                'kelas' => "required",
                'status' => "required",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        // validasi jika tipenya siswa
        if ($tipe == 1) {
            $validator = Validator::make($request->all(), [
                'nama_peserta' => "required",
                'tipe' => "required",
                'tingkatan' => "required",
                'kelas' => "required",
                'status' => "required",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        // validasi jika tipe guru / karyawan
        if ($tipe == 2 || $tipe == 3) {
            $validator = Validator::make($request->all(), [
                'nama_peserta' => "required",
                'tipe' => "required",
                'status' => "required",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $id_peserta = $request->id_peserta;

        if (empty($id_peserta)) {
            return redirect()->back()->withInput();
        }

        $sql_peserta = Peserta::where("id_peserta", $id_peserta)->first();

        if (empty($sql_peserta)) {
            return redirect()->back()->withInput();
        }

        if ($sql_peserta->nama_peserta != $request->nama_peserta) {
            $sql_check = Peserta::where("nama_peserta", $request->nama_peserta)->first();
            if ($sql_check) {
                return redirect()->back()->with("duplicate", "duplicate")->withInput();
            }
            $dataUpdate['nama_peserta'] = $request->nama_peserta;
        }

        if ($sql_peserta->tipe != $request->tipe) {
            $dataUpdate['tipe'] = $request->tipe;
        }


        if ($sql_peserta->status != $request->status) {
            $dataUpdate['status'] = $request->status;
        }

        if ($tipe == 1) {
            if ($sql_peserta->tingkatan != $request->tingkatan) {
                $dataUpdate['tingkatan'] = $request->tingkatan;
            }

            if ($sql_peserta->kelas != $request->kelas) {
                $dataUpdate['id_kelas'] = $request->kelas;
            }
        } else {
            $dataUpdate['tingkatan'] = null;
            $dataUpdate['id_kelas'] = null;
        }

        if (!empty($dataUpdate)) {
            Peserta::where("id_peserta", $id_peserta)
                ->update($dataUpdate);
        }

        return redirect("/peserta")->with("successUpdate", "successUpdate");
    }

    public function import(Request $request)
    {

        $file = $request->file("file_excel");

        $importPeserta = new PesertaImport;
        $importPeserta->import($file);

        return redirect()->back()->with("success_import", "success_import");
    }

    public function checkTingkatan($tingkatan)
    {
        if ($tingkatan == 1) {
            return  "X";
        }

        if ($tingkatan == 2) {
            return  "XI";
        }

        if ($tingkatan == 3) {
            return  "XII";
        }

        return null;
    }

    public function checkTipe($tipe)
    {
        if ($tipe == 1) {
            return "Siswa";
        }

        if ($tipe == 2) {
            return "Guru";
        }

        if ($tipe == 3) {
            return "Karyawan";
        }

        return null;
    }

    public function checkStatus($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success p-2">Aktif</span>';
        }

        if ($status == 0) {
            return '<span class="badge badge-danger p-2">Nonaktif</span>';
        }

        return null;
    }

    public function vote($id_peserta)
    {
        if (empty($id_peserta)) {
            return redirect('peserta');
        }

        $sql_peserta = Peserta::where("id_peserta", $id_peserta)->first();

        if (empty($sql_peserta)) {
            return redirect('peserta');
        }

        $sql_check = DB::table("pemilihan")
            ->where("id_peserta", $id_peserta)
            ->first();

        $sql_checkKandidat = DB::table("kandidat")
            ->where("id_ketua", $id_peserta)
            ->orWhere("id_wakil", $id_peserta)
            ->first();

        $sql_kandidat = DB::table("kandidat as k")
            ->select(
                'k.*',
                'p1.nama_peserta as nama_ketua',
                'p2.nama_peserta as nama_wakil',
                'p1.tingkatan as tingkatan_ketua',
                'p2.tingkatan as tingkatan_wakil',
                'k1.nama_kelas as kelas_ketua',
                'k2.nama_kelas as kelas_wakil'
            )
            ->join("peserta as p1", 'p1.id_peserta', '=', 'k.id_ketua')
            ->join('peserta as p2', 'p2.id_peserta', '=', 'k.id_wakil')
            ->join('kelas as k1', 'k1.id_kelas', '=', 'p1.id_kelas')
            ->join('kelas as k2', 'k2.id_kelas', '=', 'p2.id_kelas')
            ->where("p1.status", 1)
            ->where("p2.status", 1)
            ->where("k1.status", 1)
            ->where("k2.status", 1)
            ->orderBy("k.id_kandidat", 'ASC')
            ->get();

        $dataToView = [
            'kandidats' => $sql_kandidat,
            'status_vote' => 0,
            'isKandidat' => 0,
            'id_peserta' => $id_peserta,
        ];

        if ($sql_check) {
            $dataToView['status_vote'] = 1;
        }

        if ($sql_checkKandidat) {
            $dataToView['isKandidat'] = 1;
        }

        // dd($dataToView);

        return view("peserta.vote", $dataToView);
    }

    public function doVote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kandidat' => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id_kandidat = $request->id_kandidat;
        $id_peserta = $request->id_peserta;
        $longtitude = null;
        $latitude = null;

        $sql_checkPeserta = DB::table("pemilihan")
            ->where("id_peserta", $id_peserta)
            ->first();

        $sql_waktu = DB::table('waktu')
            ->where("status", 1)
            ->first();

        //check peserta sudah pilih atau belum
        if ($sql_checkPeserta) {
            return redirect()->back()->withInput()->with("sudahVote", "sudahVote");
        }

        // cek apakah ada batas waktu
        if (!$sql_waktu) {
            return redirect()->back()->withInput()->with("batasWaktuNotFound", 'batasWaktuNotFound');
        }

        $waktuSaatIni = Carbon::now();

        // cek apabila waktu kurang
        if ($waktuSaatIni <= $sql_waktu->start) {
            return redirect()->back()->withInput()->with("belumDiMulai", "belumDiMulai");
        }

        // cek apabila waktu lebih
        if ($waktuSaatIni >= $sql_waktu->finish) {
            return redirect()->back()->withInput()->with("sudahSelesai", "sudahSelesai");
        }

        //lolos
        if ($waktuSaatIni >= $sql_waktu->start && $waktuSaatIni <= $sql_waktu->finish) {
            DB::table('pemilihan')
                ->insert([
                    'id_peserta' => $id_peserta,
                    'id_kandidat' => $id_kandidat,
                    'waktu' => Carbon::now(),
                    'longtitude' => $longtitude,
                    'latitude' => $latitude,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

            return redirect('peserta')->with("successVote", 'successVote');
        }
    }
}
