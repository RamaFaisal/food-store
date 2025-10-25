@section('title')
Checkout - Eat Your Favorite Foods
@stop

@section('keywords')
Food Store, Eat Your Favorite Foods
@stop

@section('description')
Checkout - Food Store - Eat Your Favorite Foods
@stop

@section('image')
{{ asset('images/logo.png') }}
@stop

<div>
    <div class="container">

        <div class="row justify-content-center mt-0" style="margin-bottom: 320px;">
            <div class="col-md-6">

                <div class="bg-white rounded-bottom-custom shadow-sm p-3 sticky-top mb-3">
                    <div class="d-flex justify-content-start">
                        <div>
                            <x-buttons.back />
                        </div>
                    </div>
                </div>

                <div class="card rounded shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt mb-1" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                            Shipping Information
                        </h6>
                        <hr />

                        <select class="form-select rounded mb-3" wire:model.live="provience_id">
                            <option value="">-- Select Province --</option>
                            @foreach ($proviences as $province)
                            <option value="{{ $province->id }}">
                                {{ $province->name }}
                            </option>
                            @endforeach
                        </select>

                        <select class="form-select rounded mb-3" wire:model.live="city_id" wire:key="{{ $provience_id }}">
                            <option value="">-- Select City --</option>
                            @foreach (\App\Models\City::where('provience_id', $provience_id)->get() as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>

                        <select class="form-select rounded mb-3" wire:model.live="district_id" wire:key="{{ $city_id }}">
                            <option value="">-- Select District --</option>
                            @foreach (\App\Models\District::where('city_id', $city_id)->get() as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>

                        <div class="mb-3">
                            <textarea class="form-control rounded" wire:model.live="address" rows="3" placeholder="Address:  Jl. Kebon Jeruk No. 1, Jakarta Barat"></textarea>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    

</div>