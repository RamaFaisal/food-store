<div>
    {{ $counter }}
    <button wire:click="increment">Tambah</button>
    <button wire:click="decrement">Kurang</button>
    <button wire:click="manipulate">Manipulasi</button>
    <input type="text" wire:model.live="counter">
    <button wire:click="update">update</button>

    <div>
        <h1>Celcius = {{ $celcius }}°</h1>
        <h1>Fahrenheit = {{ $fahrenheit }}°</h1>
        Masukkan Fahrenheit <input type="text" wire:model.live="fahrenheit">
        <button wire:click="upSuhu">Test</button>
    </div>

    @livewire('web.test.nilai')
</div>
