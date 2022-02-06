@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Planer procesów biznesowych') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Witam serdecznie w planerze procesów biznesowych w wersji Beta.<br>
                    W przypadku znalezienia jakichkolwiek problemów bardzo proszę o kontakt z administratorem serwisu.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
