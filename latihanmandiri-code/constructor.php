<?php
declare(strict_types=1);

class Mahasiswa {
    public function __construct(
        public string $nim,
        public string $nama,
        public int $semester = 1
    ) {}
    public function profil(): string {
        return "$this->nim - $this->nama (Semester $this->semester)";
    }
}

$mhs  = new Mahasiswa('231001', 'Kaza', 3);
echo $mhs->profil() . "<br>";
$mhs2 = new Mahasiswa('231002', 'Alya');      // semester memakai default
echo $mhs2->profil() . "<br>";

try { new Mahasiswa('231003', 'Citra', '4'); }  // string, bukan int
catch (TypeError $e) { echo get_class($e) . ': ' . $e->getMessage() . "<br>"; }
try { new Mahasiswa('231004'); }                // argumen kurang
catch (ArgumentCountError $e) { echo get_class($e) . ': ' . $e->getMessage() . "<br>"; }


?>