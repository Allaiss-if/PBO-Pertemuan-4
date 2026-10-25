<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');

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