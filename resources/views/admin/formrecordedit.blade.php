@extends('layoutadmin')

@section('content')
    <h2>Manage Custom Fields</h2>
    
    <a href="{{ route('custom-fields.create') }}" class="btn btn-primary">Add New Field</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Label</th>
                <th>Type</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fields as $field)
                <tr>
                    <td>{{ $field->label }}</td>
                    <td>{{ $field->type }}</td>
                    <td>{{ $field->value }}</td>
                    <td>
                        <a href="{{ route('custom-fields.edit', $field->id) }}" class="btn btn-warning">Edit</a>
                        
                        <form action="{{ route('custom-fields.destroy', $field->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
