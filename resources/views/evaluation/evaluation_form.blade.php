<div class="modal fade" id="store_evaluation_form" tabindex="-1" aria-labelledby="store_evaluation_formLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="store_evaluation_formLabel">Course Evaluation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body overflow-auto" style="max-height: 90vh;">
                <div class="p-4">
                    <form method="POST" action="{{ route('evaluation.student.store') }}"
                        id="store_evaluation_form_form">
                        @csrf
                        <input type="hidden" name="course_id" id="course_id">
                        <input type="hidden" name="department_id" id="department_id">
                        <input type="hidden" name="teacher_id" id="teacher_id">
                        <input type="hidden" name="student_id" id="student_id">
                        <input type="hidden" id="year_hidden" name="year">
                        <input type="hidden" id="batch_id_hidden" name="batch_id">
                        <div id="question_list">
                            @foreach ($questions as $question)
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">{{ $question->question }}</label>
                                    <div class="star-rating" data-question-id="{{ $question->id }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star star" data-value="{{ $i }}"
                                                id="star_{{ $question->id }}_{{ $i }}"
                                                style="cursor: pointer; font-size: 24px; color: gray;"></i>
                                        @endfor
                                        <input type="hidden" name="ratings[{{ $question->id }}]"
                                            id="rating_input_{{ $question->id }}" required>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="mb-4">
                            <label for="comment_data" class="form-label fw-semibold">Comment</label>
                            <textarea class="form-control" id="comment_data" name="comment_data" rows="4"
                                placeholder="Write your comment here..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit Evaluation</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
