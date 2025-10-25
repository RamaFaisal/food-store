<div>
    <div>
        <h1>Siswa {{ $nilaiAkhir }}</h1>
        <input type="text" wire:model.live="nilai">
        <button wire:click="penilaian">Cek</button>
    </div>

    <div>
        <h1>Konversi Rupiah</h1>
        {{ $jumlahRupiah }}
        ${{ $jumlahDolar }}
        <input type="number" wire:model.live="jumlahRupiah">
        <button wire:click="konversi">Konversi</button>
    </div>
</div>
