<?php

namespace App\Livewire\Web\Test;

use Livewire\Component;

class Nilai extends Component
{
    public $nilai;
    public $nilaiAkhir;
    public $jumlahRupiah;
    public $jumlahDolar;

    public function mount()
    {
        $this->nilai = 0;
        $this->nilaiAkhir = 'N/A';
        $this->jumlahRupiah = 100;
        $this->jumlahDolar = 0;
    }

    public function penilaian()
    {
        $nilaiInput = $this->nilai;

        if ($nilaiInput >= 60) {
            $this->nilaiAkhir = "Lulus";
        } else {
            $this->nilaiAkhir = "Gagal";
        }
    }

    public function konversi()
    {
        $konversi = $this->jumlahRupiah / 15000;
        $this->jumlahDolar = $konversi;
    }

    public function render()
    {
        return view('livewire.web.test.nilai');
    }
}
