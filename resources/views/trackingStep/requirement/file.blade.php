@if($stepRequirement->requirementFiles->where('current', 'Current')->count() == 0)
    <div class=" px-4 py-4 mb-1">
        <h4>{{ $stepRequirement->requirement }}</h4>
        <div class="d-flex">
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <a href="{{ route('requirementFiles.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Upload New File</a>
                @if($stepRequirement->requirementFiles->count() == 0)
                    @if(!$trackingStep->isDefault())
                        <span onclick="event.preventDefault();
                            if (confirm('Are you sure you want to delete {{ $stepRequirement->requirement }}? This action cannot be undone.')) {
                            document.getElementById('form-delete-fileRequirement').submit()
                            }" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-fileRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif

@foreach($stepRequirement->requirementFiles->sortByDesc('created_at')->sortBy('current') as $key => $file)
    <div class=" px-4 py-4 mb-1 @if($file->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $file->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($file->isCurrent())
                        <div>
                            <span>
                                <a href="{{ route('requirementFiles.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $file->id]) }}" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to remove {{ $file->title }} as your current file?')) {
                                document.getElementById('form-remove-file{{ $file->id }}').submit()
                                }" class="btn btn-danger btn-sm">
                                Remove File
                            </span>
                            <form style="display: none" id="form-remove-file{{ $file->id }}" action="{{ route('requirementFiles.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $file->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $file->title }} as your current file?')) {
                                document.getElementById('form-restore-file{{ $file->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore File
                            </span>
                            <form style="display: none" id="form-restore-file{{ $file->id }}" action="{{ route('requirementFiles.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $file->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <table class="table table-sm table-borderless">
            <tbody>
            <tr>
                <td>File:</td>
                <td>
                    <a href="{{ asset('storage/' . $file->filename) }}" target="_blank"><strong>{{ $file->title }}</strong></a>
                </td>
            </tr>
            @if($file->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($file->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted() and $file->isCurrent())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-fileForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-fileForm" action="{{ route('requirementFiles.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $file->id, $form->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td>Date Created:</td>
                <td>{{ $file->dateFormat($file->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $file->dateFormat($file->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $file->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
