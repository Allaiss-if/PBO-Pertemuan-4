<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');

// Latihan 3: unset dan alias pada objek Buku
class Buku {
    public function __construct(
        public string $judul,
        public string $penulis,
        public int $tahun
    ) {
        echo "[Constructor] Buku '$this->judul' dibuat\n";
    }
    
    public function tampilInfo(): string {
        return "Judul: $this->judul | Penulis: $this->penulis | Tahun: $this->tahun";
    }
    
    public function __destruct() {
        echo "[Destructor] Buku '$this->judul' dihancurkan\n";
    }
}

// Skenario A: unset TANPA alias
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
echo "Akhir skrip... destructor Buku C akan otomatis berjalan setelah baris ini.\n";

?>