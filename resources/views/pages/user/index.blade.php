@extends('layouts.app')

@section('content')
    <x-table title="users table" :createRoute="route('user.create')" >
        {{ $dataTable->table() }}
    </x-table>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
