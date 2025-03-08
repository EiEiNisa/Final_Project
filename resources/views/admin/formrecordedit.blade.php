@extends('layoutadmin') 

@section('content')
    <h2>Custom Fields</h2>
    <a href="{{ route('custom-fields.create') }}">Add New Field</a>
    <ul>
        @foreach ($fields as $field)
            <li>{{ $field->label }} ({{ $field->type }}) - {{ $field->value }}
                <a href="{{ route('custom-fields.edit', $field->id) }}">Edit</a>
                <form action="{{ route('custom-fields.destroy', $field->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
