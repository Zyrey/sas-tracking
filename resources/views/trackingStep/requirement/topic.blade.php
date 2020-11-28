@if($stepRequirement->requirementTopics->where('current', 'Current')->count() == 0)
    <div class=" px-4 py-4 mb-1">
        <h4>{{ $stepRequirement->requirement }}</h4>
        <div class="d-flex">
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <a href="{{ route('requirementTopics.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" class="btn btn-dark btn-sm mr-2">Create</a>
                @if($stepRequirement->requirementTopics->count() == 0)
                    @if(!$trackingStep->isDefault())
                        <span onclick="event.preventDefault();
                            if (confirm('Are you sure you want to delete {{ $stepRequirement->requirement }}? This action cannot be undone.')) {
                            document.getElementById('form-delete-topicRequirement').submit()
                            }" class="btn btn-danger btn-sm">
                            Delete
                        </span>
                        <form style="display: none" id="form-delete-topicRequirement" action="{{ route('stepRequirements.destroy', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif

@foreach($stepRequirement->requirementTopics->sortByDesc('created_at')->sortBy('current') as $key => $topic)
    <div class=" px-4 py-4 mb-1 @if($topic->current == 'Previous') table-danger @endif">
        <div class="d-flex justify-content-between border-bottom">
            <h4>{{ $topic->current }} {{ $stepRequirement->requirement }}</h4>
            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                <div class="d-flex">
                    @if($topic->isCurrent())
                        <div>
                            <span>
                                <a href="{{ route('requirementTopics.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $topic->id]) }}" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to remove {{ $topic->topic }} as your current topic?')) {
                                document.getElementById('form-remove-topic{{ $topic->id }}').submit()
                                }" class="btn btn-danger btn-sm">
                                Remove Topic
                            </span>
                            <form style="display: none" id="form-remove-topic{{ $topic->id }}" action="{{ route('requirementTopics.deactivate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $topic->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    @else
                        <div>
                            <span onclick="event.preventDefault();
                                if (confirm('Are you sure you want to restore {{ $topic->topic }} as your current topic?')) {
                                document.getElementById('form-restore-topic{{ $topic->id }}').submit()
                                }" class="btn btn-dark btn-sm">
                                Restore Topic
                            </span>
                            <form style="display: none" id="form-restore-topic{{ $topic->id }}" action="{{ route('requirementTopics.activate', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $topic->id]) }}" method="POST">
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
                <td>Topic:</td>
                <td><strong>{{ $topic->topic }}</strong></td>
            </tr>
            @if($topic->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($topic->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a></td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted() and $topic->isCurrent())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-topicForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-topicForm" action="{{ route('requirementTopics.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $stepRequirement->id, $topic->id, $form->id]) }}" method="POST">
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
                <td>{{ $topic->dateFormat($topic->created_at) }}</td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td>{{ $topic->dateFormat($topic->updated_at) }}</td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td>{{ $topic->remarks }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach
