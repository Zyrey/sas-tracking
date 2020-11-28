<div class=" px-4 py-4 mb-1">
    <h4>{{ $stepRequirement->requirement }}</h4>
    <div class="d-flex">
        @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
            <a href="{{ route('requirementPanels.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Assign New Panel</a>
            @if($stepRequirement->requirementFaculties->where('role', 'Panel')->count() == 0)
                @if(!$trackingStep->isDefault())
                    <span onclick="event.preventDefault();
                    if (confirm('Are you sure you want to delete this requirement? This action cannot be undone.')) {
                    document.getElementById('form-delete-panelRequirement').submit()
                    }" class="btn btn-danger btn-sm">
                    Delete
                </span>
                    <form style="display: none" id="form-delete-panelRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            @endif
        @endif
    </div>
</div>


@foreach($stepRequirement->requirementFaculties->where('role', 'Panel')->sortByDesc('created_at')->sortBy('current') as $key => $panel)
    <div class=" px-4 py-4 mb-1 @if($panel->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $panel->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($panel->isCurrent())
                        <div>
                            <span class="mb-2">
                                <a href="{{ route('requirementPanels.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $panel->id]) }}" class="btn btn-dark btn-sm">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to remove {{ $panel->faculty->fullname }} as your current panel?')) {
                                document.getElementById('form-remove-panel{{ $panel->id }}').submit()
                                }" class="btn btn-danger btn-sm">
                                    Remove Panel
                                </span>
                            <form style="display: none" id="form-remove-panel{{ $panel->id }}" action="{{ route('requirementPanels.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $panel->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $panel->faculty->fullname }} as your current panel?')) {
                                document.getElementById('form-restore-panel{{ $panel->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore Panel
                            </span>
                            <form style="display: none" id="form-restore-panel{{ $panel->id }}" action="{{ route('requirementPanels.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $panel->id]) }}" method="POST">
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
                <td>Panel:</td>
                <td>
                    <a href="{{ route('faculties.show', $panel->faculty->id) }}" target="_blank"><strong>{{ $panel->faculty->fullname }}</strong></a>
                </td>
            </tr>
            <tr>
                <td>Type:</td>
                <td><strong>{{ $panel->faculty->institution->type }}</strong></td>
            </tr>
            @if($panel->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($panel->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-panelForm{{ $form->id }}').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-panelForm{{ $form->id }}" action="{{ route('requirementPanels.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $panel->id, $form->id]) }}" method="POST">
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
                <td>{{ $panel->dateFormat($panel->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $panel->dateFormat($panel->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $panel->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>


@endforeach

