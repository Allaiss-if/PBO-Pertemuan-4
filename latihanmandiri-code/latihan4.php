<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');

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

echo "\nAkhir skrip\n";
?>