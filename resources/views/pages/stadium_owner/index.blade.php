    @extends('layouts.app')

    @section('content')
        <x-table title="stadium owners table" createRoute="{{route('stadium-owner.create')}}">
            {{ $dataTable->table() }}
        </x-table>
    @endsection

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
