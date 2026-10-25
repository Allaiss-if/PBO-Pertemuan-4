<?php
declare(strict_types=1);
class MahasiswaDinamis {
    private array $atributTambahan = [];
    public function __construct(public string $nim, public string $nama) {}

    public function __set(string $key, mixed $value): void {
        $diizinkan = ['hobi', 'asalSekolah', 'agama'];
        if (!in_array($key, $diizinkan, true)) {
            throw new InvalidArgumentException('Atribut tidak diizinkan');
        }
        $this->atributTambahan[$key] = $value;
    }
    public function __get(string $key): mixed {
        if (!array_key_exists($key, $this->atributTambahan)) {
            throw new OutOfBoundsException('Atribut tidak ditemukan');
        }
        return $this->atributTambahan[$key];
    }
    public function __isset(string $key): bool { return isset($this->atributTambahan[$key]); }
    public function __unset(string $key): void { unset($this->atributTambahan[$key]); }
}

$mhs = new MahasiswaDinamis('231001', 'Alya');

// 1. Set dan Get atribut yang diizinkan
$mhs->hobi = 'Membaca';
echo htmlspecialchars($mhs->hobi, ENT_QUOTES, 'UTF-8') . "<br>";

// 2. Isset sebelum unset
echo "isset hobi: " . (isset($mhs->hobi) ? 'true' : 'false') . "<br>";

// 3. Unset dan cek kembali
unset($mhs->hobi);
echo "isset hobi setelah unset: " . (isset($mhs->hobi) ? 'true' : 'false') . "<br>";



// 4. Menangkap error saat mengisi atribut yang tidak diizinkan (memicu InvalidArgumentException)
try {
$mhs->alamat = 'X';
} catch (InvalidArgumentException $e) {
echo "InvalidArgumentException: " . $e->getMessage() . "<br>";
}

// 5. Menangkap error saat membaca atribut yang sudah di-unset atau tidak ada (memicu OutOfBoundsException)
try {
echo $mhs->hobi;
} catch (OutOfBoundsException $e) {
echo "OutOfBoundsException: " . $e->getMessage() . "<br>";
}

//Tes exception OutOfBoundsException - fatal eror menghentikan eksekusi di sini
$mhs->hobi;

//Tes exception InvalidArgumentException ini gak akan muncul 
//karena fatal error sudah terjadi di atas dan code dibawah tidak akan pernah dijalankan
$mhs->alamat = "X";



// CATATAN PENGUJIAN ERROR:
//Jika exception (seperti OutOfBoundsException) tidak dibungkus dalam blok try...catch, 
// PHP akan menghasilkan Fatal Error dan langsung menghentikan eksekusi skrip sepenuhnya. 
// Akibatnya, baris pengujian di bawahnya (seperti $mhs->alamat = "X") tidak akan pernah dieksekusi. 
// Untuk menguji beberapa skenario error dalam satu file secara berurutan, 
//setiap kasus pengujian wajib diisolasi di dalam blok try...catch masing-masing.

?>