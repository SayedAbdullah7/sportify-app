@extends('layouts.app')

@section('content')
    <x-table title="admin table" createRoute="{{route('facility.create')}}">
        {{ $dataTable->table() }}
    </x-table>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
