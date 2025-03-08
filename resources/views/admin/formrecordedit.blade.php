@extends('layoutadmin')

@section('content')
    <h2>Manage Custom Fields</h2>

    <!-- Button to open Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFieldModal">
        Add New Field
    </button>

    <!-- Modal -->
    <div class="modal fade" id="createFieldModal" tabindex="-1" role="dialog" aria-labelledby="createFieldModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFieldModalLabel">Create New Custom Field</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to create new custom field -->
                    <form id="createFieldForm">
                        @csrf
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" name="label" id="label" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="select">Select</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="value">Value</label>
                            <textarea name="value" id="value" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Save Field</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table to show existing fields -->
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

@section('scripts')
    <!-- Include jQuery and Bootstrap JS for modal and ajax submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Handling the form submission with Ajax
        $('#createFieldForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Get form data

            $.ajax({
                url: '{{ route("custom-fields.store") }}', // Store route
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Close modal after success
                    $('#createFieldModal').modal('hide');
                    // Clear form
                    $('#createFieldForm')[0].reset();
                    // Reload the page to show the newly added field
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('Error: ' + error);
                }
            });
        });
    </script>
@endsection
