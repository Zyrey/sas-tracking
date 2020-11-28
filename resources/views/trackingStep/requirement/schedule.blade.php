@if($stepRequirement->requirementSchedules->where('current', 'Current')->count() == 0)
    <div class=" px-4 py-4 mb-1">
        <h4>{{ $stepRequirement->requirement }}</h4>
        <div class="d-flex">
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <a href="{{ route('requirementSchedules.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Create</a>
                @if($stepRequirement->requirementSchedules->count() == 0)
                    @if(!$trackingStep->isDefault())
                        <span onclick="event.preventDefault();
                            if (confirm('Are you sure you want to delete {{ $stepRequirement->requirement }}? This action cannot be undone.')) {
                            document.getElementById('form-delete-scheduleRequirement').submit()
                            }" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-scheduleRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif

@foreach($stepRequirement->requirementSchedules->sortByDesc('created_at')->sortBy('current') as $key => $schedule)
    <div class=" px-4 py-4 mb-1 @if($schedule->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $schedule->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($schedule->isCurrent())
                        <div>
                            <span>
                                <a href="{{ route('requirementSchedules.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $schedule->id]) }}" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to remove {{ $schedule->scheduleDateFormat($schedule->date) }} as your current schedule?')) {
                                document.getElementById('form-remove-schedule{{ $schedule->id }}').submit()
                                }" class="btn btn-danger btn-sm">
                                Remove Schedule
                            </span>
                            <form style="display: none" id="form-remove-schedule{{ $schedule->id }}" action="{{ route('requirementSchedules.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $schedule->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $schedule->scheduleDateFormat($schedule->date) }} as your current schedule?')) {
                                document.getElementById('form-restore-schedule{{ $schedule->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore Schedule
                            </span>
                            <form style="display: none" id="form-restore-schedule{{ $schedule->id }}" action="{{ route('requirementSchedules.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $schedule->id]) }}" method="POST">
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
                <td>Schedule:</td>
                <td><strong>{{ $schedule->scheduleDateFormat($schedule->date) }}; {{ $schedule->timeFormat($schedule->start_time) }} - {{ $schedule->timeFormat($schedule->end_time) }}</strong></td>
            </tr>
            @if($schedule->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($schedule->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted() and $schedule->isCurrent())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-scheduleForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-scheduleForm" action="{{ route('requirementSchedules.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $schedule->id, $form->id]) }}" method="POST">
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
                <td>{{ $schedule->dateFormat($schedule->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $schedule->dateFormat($schedule->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $schedule->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
