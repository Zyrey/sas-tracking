@if($stepRequirement->requirementResults->where('current', 'Current')->count() == 0)
    <div class=" px-4 py-4 mb-1">
        <h4>{{ $stepRequirement->requirement }}</h4>
        <div class="d-flex">
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <a href="{{ route('requirementResults.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Create</a>
                @if($stepRequirement->requirementResults->count() == 0)
                    @if(!$trackingStep->isDefault())
                        <span onclick="event.preventDefault();
                            if (confirm('Are you sure you want to delete {{ $stepRequirement->requirement }}? This action cannot be undone.')) {
                            document.getElementById('form-delete-resultRequirement').submit()
                            }" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-resultRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif

@foreach($stepRequirement->requirementResults->sortByDesc('created_at')->sortBy('current') as $key => $result)
    <div class=" px-4 py-4 mb-1 @if($result->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $result->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($result->isCurrent())
                        <div>
                            <span>
                                <a href="{{ route('requirementResults.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $result->id]) }}" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to remove {{ $result->title }} as your current result?')) {
                                document.getElementById('form-remove-result{{ $result->id }}').submit()
                                }" class="btn btn-danger btn-sm">
                                Remove Result
                            </span>
                            <form style="display: none" id="form-remove-result{{ $result->id }}" action="{{ route('requirementResults.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $result->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $result->title }} as your current result?')) {
                                document.getElementById('form-restore-result{{ $result->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore Result
                            </span>
                            <form style="display: none" id="form-restore-result{{ $result->id }}" action="{{ route('requirementResults.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $result->id]) }}" method="POST">
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
                <td>Result:</td>
                <td><strong>{{ $result->result }}</strong></td>
            </tr>
            @if($result->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($result->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted() and $result->isCurrent())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-resultForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-resultForm" action="{{ route('requirementResults.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $result->id, $form->id]) }}" method="POST">
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
                <td>{{ $result->dateFormat($result->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $result->dateFormat($result->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $result->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
