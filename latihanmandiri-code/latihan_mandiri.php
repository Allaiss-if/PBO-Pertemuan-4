<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');

// Latihan 1: constructor dengan parameter fakultas (nilai default)
class MahasiswaLatihan {
    public function __construct(
        public string $nim,
        public string $nama,
        public int $semester = 1,
        public string $fakultas = 'Belum diisi'
    ) {}
    public function profil(): string {
        return "$this->nim - $this->nama (Semester $this->semester) | Fakultas: $this->fakultas";
    }
}

echo "LATIHAN 1: Constructor dengan nilai default\n";
$a = new MahasiswaLatihan('231001', 'Alya', 3);
$b = new MahasiswaLatihan('231002', 'Budi', 3, 'Sains dan Teknologi');
echo $a->profil() . "\n";
echo $b->profil() . "\n\n";



// Latihan 2: class Buku dengan constructor dan destructor
class Buku {
    public function __construct(
        public string $judul,
        public string $penulis,
        public int $tahun
    ) {}
    public function tampilInfo(): string {
        return "$this->judul - $this->penulis ($this->tahun)";
    }
    public function __destruct() {
        echo "[Destructor] Buku '{$this->judul}' dihancurkan\n";
    }
}

echo "LATIHAN 2: Tiga objek Buku\n";
$b1 = new Buku('Holy Mother', 'Akiyoshi Rikako', 2015);
$b2 = new Buku('Atomic Habits', 'James Clear', 2018);
$b3 = new Buku('Negeri Para Bedebah', 'Tere Liye', 2012);
foreach ([$b1, $b2, $b3] as $buku) echo $buku->tampilInfo() . "\n";

echo "\nAkhir skrip\n\n";


// Latihan 3: unset dan alias pada objek Buku

// Skenario A: unset TANPA alias
echo "Latihan 3: unset dan alias pada objek Buku\n\n";
echo "--- Skenario A: unset tanpa alias ---\n";
$bukuA = new Buku('Atomic Habits', 'James Clear', 2018);
unset($bukuA);
echo "Setelah unset(\$bukuA) -> destructor langsung berjalan (sudah tampil di atas)\n\n";


// Skenario B: unset DENGAN alias
echo "--- Skenario B: unset dengan alias ---\n";
$bukuB = new Buku('Holy Mother', 'Akiyoshi Rikako', 2015);
$alias = $bukuB;                 // objek kini punya 2 referensi
unset($bukuB);                   // hanya menghapus 1 referensi (variabel $bukuB)

echo "Setelah unset(\$bukuB) -> destructor BELUM berjalan, objek masih bisa diakses lewat alias:\n";
echo "Info dari alias: " . $alias->tampilInfo() . "\n";

unset($alias);                   // referensi terakhir (variabel $alias) dihapus
echo "Setelah unset(\$alias) -> destructor berjalan (sudah tampil di atas)\n\n";


// Skenario C: tanpa unset -> destructor jalan di akhir skrip
echo "--- Skenario C: tanpa unset ---\n";
$bukuC = new Buku('Negeri Para Bedebah', 'Tere Liye', 2012);
echo "Akhir skrip... destructor Buku C akan otomatis berjalan setelah baris ini.\n\n";


// Latihan 4: atribut dinamis hobi dengan __set, __get, __isset, __unset
class MahasiswaDinamis {
    private array $atributTambahan = [];
    
    public function __construct(public string $nim, public string $nama) {}
    
    public function __set(string $key, mixed $value): void {
        if ($key !== 'hobi') {
            throw new InvalidArgumentException('Atribut tidak diizinkan: ' . $key);
        }
        echo "[Magic Method: __set] Menyimpan atribut dinamis '$key' = '$value'\n";
        $this->atributTambahan[$key] = $value;
    }
    
    public function __get(string $key): mixed { 
        echo "[Magic Method: __get] Membaca atribut dinamis '$key'\n";
        return $this->atributTambahan[$key] ?? null; 
    }
    
    public function __isset(string $key): bool { 
        echo "[Magic Method: __isset] Mengecek apakah atribut '$key' ada\n";
        return isset($this->atributTambahan[$key]); 
    }
    
    public function __unset(string $key): void { 
        echo "[Magic Method: __unset] Menghapus atribut dinamis '$key'\n";
        unset($this->atributTambahan[$key]); 
    }
}

echo "=== LATIHAN 4: Akses Atribut Dinamis ===\n\n";

echo "--- Langkah 1: Inisialisasi Objek ---\n";
$m = new MahasiswaDinamis('231001', 'Alya');
echo "Objek Mahasiswa (231001 - Alya) berhasil dibuat.\n\n";

echo "--- Langkah 2: Mengisi Atribut Dinamis ---\n";
// Baris ini akan otomatis memanggil __set()
$m->hobi = 'Membaca';
echo "\n";

echo "--- Langkah 3: Membaca Atribut Dinamis ---\n";
// Baris ini akan otomatis memanggil __get()
echo "Hasil baca: " . $m->hobi . "\n\n";

echo "--- Langkah 4: Mengecek Keberadaan Atribut (isset) ---\n";
// Baris ini akan otomatis memanggil __isset()
echo "Apakah hobi ada? " . (isset($m->hobi) ? 'Ya (true)' : 'Tidak (false)') . "\n\n";

echo "--- Langkah 5: Menghapus Atribut Dinamis (unset) ---\n";
// Baris ini akan otomatis memanggil __unset()
unset($m->hobi);
echo "Apakah hobi masih ada setelah unset? " . (isset($m->hobi) ? 'Ya (true)' : 'Tidak (false)') . "\n\n";

echo "--- Langkah 6: Menguji Atribut yang Ditolak ---\n";
try {
    echo "Mencoba mengisi: \$m->alamat = 'Sukabumi'\n";
    // Baris ini memanggil __set(), lalu ditolak karena bukan 'hobi'
    $m->alamat = 'Sukabumi';
} catch (InvalidArgumentException $e) {
    echo "(InvalidArgumentException): " . $e->getMessage() . "\n";
}

echo "\nAkhir skrip\n\n";


// Latihan 5: overloading method dengan __call
class Laporan {
    public function __construct(private string $nama) {
        echo "[Constructor] Objek Laporan untuk '$this->nama' dibuat.\n";
    }
    
    public function __call(string $method, array $args): mixed {
        // Indikator visual bahwa __call sedang bekerja
        echo "[Magic Method: __call] Menangkap panggilan ke method yang tidak ada: '$method()'\n";
        
        if ($method === 'cetakRingkas' && count($args) === 0) {
            echo "[Logika __call] Method '$method' dikenali. Mengembalikan teks ringkasan...\n";
            return 'Mahasiswa: ' . $this->nama;
        }
        
        echo "[Logika __call] Method '$method' DITOLAK!\n";
        throw new BadMethodCallException('Method tidak tersedia: ' . $method);
    }
}

echo "=== LATIHAN 5: Overloading Method dengan __call ===\n\n";

echo "--- Langkah 1: Inisialisasi Objek ---\n";
$l = new Laporan('Alya');
echo "\n";

echo "--- Langkah 2: Memanggil Method Dinamis yang Diizinkan ---\n";
echo "Instruksi: \$l->cetakRingkas()\n";
// Karena cetakRingkas() tidak dideklarasikan di class, PHP otomatis melemparnya ke __call
$hasil = $l->cetakRingkas();
echo "Output akhir : ". "\n". $hasil . "\n\n";

echo "--- Langkah 3: Memanggil Method yang Ditolak ---\n";
try {
    echo "Instruksi: \$l->hapusSemua()\n";
    // hapusSemua() juga tidak ada, masuk ke __call, lalu memicu exception
    $l->hapusSemua();
} catch (BadMethodCallException $e) {
    echo "Error berhasil ditangkap \n(BadMethodCallException): " . $e->getMessage() . "\n";
}

echo "\nAkhir skrip\n";

?>
