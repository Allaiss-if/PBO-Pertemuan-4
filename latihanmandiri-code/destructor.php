<?php
class DemoSiklus {
    public function __construct() { 
        echo "Object dibuat <br>"; 
    }
    public function tampil(): void { 
        echo "Method dipanggil <br>"; 
    }
    public function __destruct() { 
        echo "Destructor berjalan <br>"; 
    }
}

echo "--- B1: dengan unset ---<br>";
$obj = new DemoSiklus(); 
$obj->tampil(); 
unset($obj);
echo "Program dilanjutkan <br>";

echo "--- B2: dengan alias ---<br>";
$obj = new DemoSiklus(); 
$alias = $obj;
unset($obj);    
echo "Setelah unset(\$obj) - object masih punya alias <br>";
unset($alias);  // Destructor akan berjalan tepat di baris ini
echo "Setelah unset(\$alias) <br>";

echo "--- B3: tanpa unset --- <br>";
$o3 = new DemoSiklus(); 
$o3->tampil();
echo "Akhir skrip\n";
// Destructor untuk $o3 otomatis berjalan setelah seluruh skrip PHP selesai

?>