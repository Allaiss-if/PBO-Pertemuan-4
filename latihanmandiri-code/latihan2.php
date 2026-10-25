<?php
declare(strict_types=1);
header('Content-Type: text/plain; charset=utf-8');

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

echo "\nAkhir skrip\n";
?>