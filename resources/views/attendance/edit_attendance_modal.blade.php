
<div class="modal fade" id="edit-student-attendance" tabindex="-1" role="dialog" aria-labelledby="editStudentAttendanceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentAttendanceLabel">Edit Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <input type="hidden" name="id" id="attendance-id">
                            <input type="hidden" name="routine_id" id="cls-routine-id">
                            <label class="form-control-label"><span class="text-danger">*</span>Attendance Status </label>
                            <select class="form-control m-input" name="attendance-status" id="attendance-status">
                                <option value="1">Present</option>
                                <option value="0">Absent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{--<button type="button" class="btn btn-primary" id="update-attendance-btn">Save & close</button>--}}
                <button type="button" class="btn btn-success" id="update-attendance-btn"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>

        $('#attendance-data').on('click', '.edit-attendance',function (e) {
            $('#attendance-id').val($(this).data('attendance-id'));
            $('#attendance-status').val($(this).data('attendance-status'));
            $('#cls-routine-id').val($(this).data('routine-id'));
            $('#edit-student-attendance').modal('show');
        });

        $('#update-attendance-btn').click(function (e) {
            e.preventDefault();

            var routineId = $('#cls-routine-id').val();

            $.ajax({
                type: 'PUT',
                url: baseUrl+ 'admin/attendance/'+$('#attendance-id').val(),
                data: {attendance: $('#attendance-status').val(), _token: "{{ csrf_token() }}",},
                success: function(response) {
                    if (response.status){
                        var table = $('#attendance-data').DataTable();
                        table.destroy();

                        var attendanceTableColumn = [
                            {"data":"student_id","name":"student_id"},
                            {"data":"subject_id","name":"subject_id"},
                            {"data":"attendance","name":"attendance"},
                            {"data":"action","name":"action"}
                        ];
                        //reload page after modal submit
                        location.reload();
                        generateDatatable('attendance-data', attendanceTableColumn, baseUrl+'admin/attendance/get-data/'+routineId, 1, 'asc');

                        $('#edit-student-attendance').modal('hide');

                    }
                }
            });
        })
    </script>
@endpush
