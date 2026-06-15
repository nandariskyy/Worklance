<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\Kategori;
use App\Models\Jasa;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dashboard()
    {
        $totalUser = User::count();
        $totalFreelancer = User::where('id_role', 3)->count();
        $totalBooking = Booking::count();
        $totalSelesai = Booking::where('status_booking', 'selesai')->count();

        // 3 Booking terbaru
        $bookingTerbaruQuery = Booking::with(['pengguna', 'layanan.jasa'])
            ->orderBy('id_booking', 'desc')
            ->take(3)
            ->get();
            
        $bookingTerbaru = [];
        foreach ($bookingTerbaruQuery as $b) {
            $bookingTerbaru[] = [
                'nama_client' => $b->pengguna ? $b->pengguna->nama_pengguna : '-',
                'nama_jasa' => $b->layanan && $b->layanan->jasa ? $b->layanan->jasa->nama_jasa : '-',
                'tanggal_booking' => $b->tanggal_booking,
                'status_booking' => $b->status_booking,
            ];
        }

        // Kategori Populer
        $kategoriPopulerQuery = DB::table('booking')
            ->join('layanan', 'booking.id_layanan', '=', 'layanan.id_layanan')
            ->join('jasa', 'layanan.id_jasa', '=', 'jasa.id_jasa')
            ->join('kategori', 'jasa.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', DB::raw('count(booking.id_booking) as total'))
            ->groupBy('kategori.nama_kategori', 'kategori.id_kategori')
            ->orderByDesc('total')
            ->take(3)
            ->get();
            
        $kategoriPopuler = json_decode(json_encode($kategoriPopulerQuery), true);

        // Pengajuan Freelancer
        $newPengajuanQuery = DB::table('pengajuan_freelancer')
            ->join('pengguna', 'pengajuan_freelancer.id_pengguna', '=', 'pengguna.id_pengguna')
            ->select('pengguna.nama_pengguna', 'pengajuan_freelancer.status')
            ->where('pengajuan_freelancer.status', 'MENUNGGU')
            ->orderBy('pengajuan_freelancer.tanggal_pengajuan', 'desc')
            ->take(5)
            ->get();
            
        $newPengajuan = json_decode(json_encode($newPengajuanQuery), true);

        // Booking Per Bulan
        $bookingPerBulanQuery = DB::table('booking')
            ->select(DB::raw('MONTH(tanggal_booking) as bulan'), DB::raw('count(*) as total'))
            ->whereYear('tanggal_booking', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal_booking)'))
            ->orderBy('bulan')
            ->get();

        $bookingPerBulan = array_fill(1, 12, 0);
        foreach($bookingPerBulanQuery as $b) {
            $bookingPerBulan[$b->bulan] = $b->total;
        }

        $data = [
            'currentPage' => 'dashboard',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'totalUser' => $totalUser,
            'totalFreelancer' => $totalFreelancer,
            'totalBooking' => $totalBooking,
            'totalSelesai' => $totalSelesai,
            'bookingTerbaru' => $bookingTerbaru,
            'kategoriPopuler' => $kategoriPopuler,
            'newPengajuan' => $newPengajuan,
            'bookingPerBulan' => array_values($bookingPerBulan),
            'maxKategori' => count($kategoriPopuler) > 0 ? max(array_column($kategoriPopuler, 'total')) : 0
        ];

        return view('admin.dashboard', $data);
    }

    public function pengguna(Request $request)
    {
        $query = DB::table('pengguna')
            ->leftJoin('role', 'pengguna.id_role', '=', 'role.id_role')
            ->select('pengguna.*', 'role.nama_role as role')
            ->where('pengguna.id_role', '!=', 1);

        if ($request->has('role')) {
            $query->where('role.nama_role', $request->role);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pengguna.nama_pengguna', 'like', "%$search%")
                  ->orWhere('pengguna.email', 'like', "%$search%")
                  ->orWhere('pengguna.username', 'like', "%$search%");
            });
        }
            
        $roleStats = DB::table('pengguna')
            ->join('role', 'pengguna.id_role', '=', 'role.id_role')
            ->select('role.nama_role', DB::raw('count(*) as total'))
            ->where('pengguna.id_role', '!=', 1)
            ->groupBy('role.nama_role')
            ->get();

        $kotaStatsQuery = DB::table('pengguna')
            ->join('kabupaten', 'pengguna.id_kabupaten', '=', 'kabupaten.id_kabupaten')
            ->select('kabupaten.nama_kabupaten as kabupaten', DB::raw('count(*) as total'))
            ->whereNotNull('pengguna.id_kabupaten')
            ->where('pengguna.id_role', '!=', 1)
            ->groupBy('kabupaten.nama_kabupaten', 'pengguna.id_kabupaten')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $data = [
            'currentPage' => 'pengguna',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'penggunaList' => json_decode(json_encode($query->get()), true),
            'activeRole' => $request->role ?? 'Semua',
            'chartData' => json_decode(json_encode($roleStats), true),
            'kotaChartData' => json_decode(json_encode($kotaStatsQuery), true)
        ];

        return view('admin.pengguna', $data);
    }

    public function freelancer(Request $request)
    {
        $query = DB::table('layanan')
            ->leftJoin('pengguna', 'layanan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->leftJoin('jasa', 'layanan.id_jasa', '=', 'jasa.id_jasa')
            ->leftJoin('kategori', 'jasa.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('satuan', 'layanan.id_satuan', '=', 'satuan.id_satuan')
            ->select(
                'layanan.*', 
                'pengguna.nama_pengguna', 
                'pengguna.email', 
                'pengguna.no_telp', 
                'kategori.nama_kategori as kategori',
                'jasa.nama_jasa as jasa',
                'satuan.nama_satuan as satuan'
            )
            ->where('pengguna.id_role', 3)
            ->orderBy('layanan.id_layanan', 'desc');

        if ($request->has('kategori')) {
            $query->where('kategori.id_kategori', $request->kategori);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pengguna.nama_pengguna', 'like', "%$search%")
                  ->orWhere('jasa.nama_jasa', 'like', "%$search%");
            });
        }

        $freelancerList = json_decode(json_encode($query->get()), true);
        foreach ($freelancerList as &$f) {
            $f['status'] = 'Aktif';
        }

        $kategoriList = Kategori::all();

        $freelancerStats = DB::table('layanan')
            ->join('pengguna', 'layanan.id_pengguna', '=', 'pengguna.id_pengguna')
            ->join('jasa', 'layanan.id_jasa', '=', 'jasa.id_jasa')
            ->join('kategori', 'jasa.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', DB::raw('count(distinct layanan.id_pengguna) as total'))
            ->where('pengguna.id_role', 3)
            ->groupBy('kategori.nama_kategori')
            ->get();

        $data = [
            'currentPage' => 'freelancer',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'freelancerList' => $freelancerList,
            'kategoriList' => $kategoriList,
            'activeKategori' => $request->kategori ?? 'Semua',
            'chartData' => json_decode(json_encode($freelancerStats), true)
        ];

        return view('admin.freelancer', $data);
    }

    public function booking(Request $request)
    {
        $query = Booking::with(['pengguna', 'layanan.pengguna', 'layanan.jasa'])->orderBy('id_booking', 'desc');
        
        if ($request->has('status')) {
            $query->where('status_booking', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_booking', 'like', "%$search%")
                  ->orWhereHas('pengguna', function($q2) use ($search) {
                      $q2->where('nama_pengguna', 'like', "%$search%");
                  });
            });
        }

        $bookingListQuery = $query->get();
        $bookingList = [];

        foreach ($bookingListQuery as $b) {
            $bookingList[] = [
                'raw_id' => $b->id_booking,
                'id_booking' => 'BK-' . str_pad($b->id_booking, 4, '0', STR_PAD_LEFT),
                'nama_client' => $b->pengguna ? $b->pengguna->nama_pengguna : '-',
                'nama_freelancer' => $b->layanan && $b->layanan->pengguna ? $b->layanan->pengguna->nama_pengguna : '-',
                'nama_jasa' => $b->layanan && $b->layanan->jasa ? $b->layanan->jasa->nama_jasa : '-',
                'tanggal_booking' => $b->tanggal_booking,
                'status_booking' => $b->status_booking,
            ];
        }

        // Stats real counts
        $stats = [
            'Semua' => Booking::count(),
            'Menunggu' => Booking::where('status_booking', 'MENUNGGU')->count(),
            'Diproses' => Booking::where('status_booking', 'DIPROSES')->count(),
            'Selesai' => Booking::where('status_booking', 'SELESAI')->count(),
            'Dibatalkan' => Booking::where('status_booking', 'DIBATALKAN')->count(),
        ];

        $data = [
            'currentPage' => 'booking',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'bookingList' => $bookingList,
            'stats' => $stats,
            'activeStatus' => $request->status ?? 'Semua'
        ];

        return view('admin.booking', $data);
    }

    public function pengajuan(Request $request)
    {
        $query = DB::table('pengajuan_freelancer')
            ->join('pengguna', 'pengajuan_freelancer.id_pengguna', '=', 'pengguna.id_pengguna')
            ->select('pengajuan_freelancer.*', 'pengguna.nama_pengguna', 'pengguna.email', 'pengguna.no_telp')
            ->orderBy('pengajuan_freelancer.tanggal_pengajuan', 'desc');

        if ($request->has('status')) {
            $query->where('pengajuan_freelancer.status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('pengguna.nama_pengguna', 'like', "%$search%");
        }

        $pengajuanListQuery = $query->get();
            
        $pengajuanList = json_decode(json_encode($pengajuanListQuery), true);
        foreach ($pengajuanList as &$p) {
            $p['kategori_diajukan'] = '-'; 
        }

        $pengajuanStats = DB::table('pengajuan_freelancer')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $data = [
            'currentPage' => 'pengajuan',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'pengajuanList' => $pengajuanList,
            'activeStatus' => $request->status ?? 'Semua',
            'chartData' => json_decode(json_encode($pengajuanStats), true)
        ];

        return view('admin.pengajuan', $data);
    }

    public function verifikasiPengajuan(Request $request)
    {
        $request->validate([
            'id_pengajuan' => 'required',
            'action' => 'required|in:approve,reject'
        ]);

        $pengajuan = DB::table('pengajuan_freelancer')->where('id_pengajuan', $request->id_pengajuan)->first();

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if ($request->action == 'approve') {
            // Update status pengajuan
            DB::table('pengajuan_freelancer')
                ->where('id_pengajuan', $request->id_pengajuan)
                ->update(['status' => 'DITERIMA']);

            // Update role pengguna menjadi Freelancer (3)
            DB::table('pengguna')
                ->where('id_pengguna', $pengajuan->id_pengguna)
                ->update(['id_role' => 3]);

            return redirect()->back()->with('success', 'Pengajuan berhasil disetujui. Pengguna kini menjadi freelancer.');
        } else {
            // Tolak pengajuan
            DB::table('pengajuan_freelancer')
                ->where('id_pengajuan', $request->id_pengajuan)
                ->update(['status' => 'DITOLAK']);

            return redirect()->back()->with('success', 'Pengajuan telah ditolak.');
        }
    }

    public function kelola()
    {
        $kategoriListQuery = Kategori::withCount('jasas')->get();
        $kategoriList = [];
        foreach ($kategoriListQuery as $kat) {
            $kategoriList[] = [
                'id_kategori' => $kat->id_kategori,
                'nama_kategori' => $kat->nama_kategori,
                'deskripsi' => $kat->deskripsi ?? '',
                'jumlah_jasa' => $kat->jasas_count
            ];
        }

        $jasaListQuery = Jasa::with('kategori')->get();
        $jasaList = [];
        foreach ($jasaListQuery as $j) {
            $jasaList[] = [
                'id_jasa' => $j->id_jasa,
                'nama_jasa' => $j->nama_jasa,
                'kategori' => $j->kategori ? $j->kategori->nama_kategori : '-',
                'id_kategori' => $j->id_kategori,
                'deskripsi' => $j->deskripsi ?? ''
            ];
        }

        $satuanList = \App\Models\Satuan::all()->toArray();

        $data = [
            'currentPage' => 'kelola',
            'adminNama' => 'Admin WorkLance',
            'adminInitials' => 'AW',
            'kategoriList' => $kategoriList,
            'jasaList' => $jasaList,
            'satuanList' => $satuanList
        ];

        return view('admin.kelola', $data);
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function storeJasa(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|integer',
            'nama_jasa' => 'required|string|max:100'
        ]);

        Jasa::create([
            'id_kategori' => $request->id_kategori,
            'nama_jasa' => $request->nama_jasa
        ]);

        return redirect()->back()->with('success', 'Jasa baru berhasil ditambahkan.');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyJasa($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();
        return redirect()->back()->with('success', 'Jasa berhasil dihapus.');
    }

    public function updateJasa(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);
        $request->validate([
            'id_kategori' => 'required|integer',
            'nama_jasa' => 'required|string|max:100'
        ]);

        $jasa->update([
            'id_kategori' => $request->id_kategori,
            'nama_jasa' => $request->nama_jasa
        ]);

        return redirect()->back()->with('success', 'Jasa berhasil diperbarui.');
    }

    public function storeSatuan(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:50'
        ]);

        \App\Models\Satuan::create([
            'nama_satuan' => $request->nama_satuan
        ]);

        return redirect()->back()->with('success', 'Satuan baru berhasil ditambahkan.');
    }

    public function destroySatuan($id)
    {
        $satuan = \App\Models\Satuan::findOrFail($id);
        $satuan->delete();
        return redirect()->back()->with('success', 'Satuan berhasil dihapus.');
    }

    public function updateSatuan(Request $request, $id)
    {
        $satuan = \App\Models\Satuan::findOrFail($id);
        $request->validate([
            'nama_satuan' => 'required|string|max:50'
        ]);

        $satuan->update([
            'nama_satuan' => $request->nama_satuan
        ]);

        return redirect()->back()->with('success', 'Satuan berhasil diperbarui.');
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pengguna,username',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:3',
            'id_role' => 'required|integer|in:1,2,3',
            'no_telp' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date'
        ]);

        User::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'id_role' => $request->id_role,
            'no_telp' => $request->no_telp,
            'tanggal_lahir' => $request->tanggal_lahir
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updatePengguna(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'id_role' => 'required|integer|in:1,2,3',
        ]);

        $pengguna->update([
            'id_role' => $request->id_role,
        ]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }

    public function destroyPengguna($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }
        
        $pengguna = User::findOrFail($id);
        Layanan::where('id_pengguna', $id)->delete();
        $pengguna->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus secara permanen.');
    }

    public function revokeFreelancer($id)
    {
        $pengguna = User::findOrFail($id);
        if ($pengguna->id_role == 3) {
            $pengguna->update(['id_role' => 2]);
            
            DB::table('pengajuan_freelancer')->where('id_pengguna', $id)->delete();
            return redirect()->back()->with('success', 'Akses freelancer berhasil dicabut. Role kembali menjadi Klien.');
        }
        return redirect()->back()->with('error', 'Pengguna ini bukan freelancer.');
    }

    public function export()
    {
        $fileName = 'laporan_booking_' . date('Ymd_His') . '.csv';
        $bookings = Booking::with(['pengguna', 'layanan.pengguna', 'layanan.jasa'])->orderBy('tanggal_booking', 'desc')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID Booking', 'Nama Klien', 'Nama Freelancer', 'Jasa', 'Tanggal Booking', 'Status');

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $b) {
                fputcsv($file, array(
                    'BK-' . str_pad($b->id_booking, 4, '0', STR_PAD_LEFT),
                    $b->pengguna ? $b->pengguna->nama_pengguna : '-',
                    $b->layanan && $b->layanan->pengguna ? $b->layanan->pengguna->nama_pengguna : '-',
                    $b->layanan && $b->layanan->jasa ? $b->layanan->jasa->nama_jasa : '-',
                    $b->tanggal_booking,
                    $b->status_booking
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
