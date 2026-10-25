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
echo $b->profil() . "\n";
?>