<div class="px-4 py-4 mb-4">
    <h4>No Requirement</h4>
    @if($trackingStep->stepDefault)
        @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
            <div class="pb-2">
                <a href="{{ route('stepDefault.edit', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $trackingStep->stepDefault->id]) }}"
                   class="btn btn-dark btn-sm mr-2">Edit</a>
            </div>
        @endif
        <table class="table table-sm table-borderless">
            <tbody>
            @if($trackingStep->stepDefault->forms->count() > 0)
                <tr>
                    <td>Forms:</td>
                </tr>
                @foreach($trackingStep->stepDefault->forms as $key => $form)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $form->filename) }}" target="_blank">{{ $form->title }}</a>
                        </td>
                        <td>
                            @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
                                <span onclick="event.preventDefault();
                                    if (confirm('Are you sure you want to delete {{ $form->title }}? This action cannot be undone.')) {
                                    document.getElementById('form-delete-topicForm').submit()
                                    }" class="btn btn-danger btn-sm">
                                    Delete
                                </span>
                                <form style="display: none" id="form-delete-topicForm"
                                      action="{{ route('stepDefault.deleteForm', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id, $trackingStep->stepDefault->id, $form->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>Remarks:</td>
                    <td>{{ $trackingStep->stepDefault->remarks }}</td>
                </tr>
            @endif
            </tbody>
        </table>
    @else
        @if($enrolledCourse->semester->isCurrent() and $enrolledCourse->isEditable() and $tracking->isActive() and $trackingStep->isActive() and !$trackingStep->isCompleted())
            <div class="d-flex">
                <a href="{{ route('stepDefault.create', [$student->id_number, $enrollment->id, $enrolledCourse->id, $tracking->id, $trackingStep->id]) }}"
                   class="btn btn-dark btn-sm mr-2">Upload Form</a>
            </div>
        @endif
    @endif
</div>
