@if($stepRequirement->requirementFaculties->where('current', 'Current')->count() == 0)
    <div class=" px-4 py-4 mb-1">
        <h4>{{ $stepRequirement->requirement }}</h4>
        <div class="d-flex">
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <a href="{{ route('requirementAdvisers.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Assign New Adviser</a>
                @if($stepRequirement->requirementFaculties->where('role', 'Adviser')->count() == 0)
                    @if(!$trackingStep->isDefault())
                        <span onclick="event.preventDefault();
                            if (confirm('Are you sure you want to delete {{ $stepRequirement->requirement }}? This action cannot be undone.')) {
                            document.getElementById('form-delete-adviserRequirement').submit()
                            }" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-adviserRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif

@foreach($stepRequirement->requirementFaculties->where('role', 'Adviser')->sortByDesc('created_at')->sortBy('current') as $key => $adviser)
    <div class=" px-4 py-4 mb-1 @if($adviser->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $adviser->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($adviser->isCurrent())
                        <div>
                            <span>
                                <a href="{{ route('requirementAdvisers.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $adviser->id]) }}" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to remove {{ $adviser->faculty->fullname }} as your current adviser?')) {
                                    document.getElementById('form-remove-adviser{{ $adviser->id }}').submit()
                                    }" class="btn btn-danger btn-sm">
                                Remove Adviser
                            </span>
                            <form style="display: none" id="form-remove-adviser{{ $adviser->id }}" action="{{ route('requirementAdvisers.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $adviser->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $adviser->faculty->fullname }} as your current adviser?')) {
                                document.getElementById('form-restore-adviser{{ $adviser->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore Adviser
                            </span>
                            <form style="display: none" id="form-restore-adviser{{ $adviser->id }}" action="{{ route('requirementAdvisers.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $adviser->id]) }}" method="POST">
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
                <td>Adviser:</td>
                <td>
                    <a href="{{ route('faculties.show', $adviser->faculty->id) }}"><strong>{{ $adviser->faculty->fullname }}</strong></a>
                </td>
            </tr>
            <tr>
                <td>Type:</td>
                <td><strong>{{ $adviser->faculty->institution->type }}</strong></td>
            </tr>
            @if($adviser->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($adviser->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted() and $adviser->isCurrent())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-adviserForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-adviserForm" action="{{ route('requirementAdvisers.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $adviser->id, $form->id]) }}" method="POST">
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
                <td>{{ $adviser->dateFormat($adviser->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $adviser->dateFormat($adviser->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $adviser->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
