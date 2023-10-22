@extends('layouts.app')

@section('content')
    <x-table title="users table" >
        {{ $dataTable->table() }}
    </x-table>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
