<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Roll No</th>
        <th>Name</th>
        @foreach ($examTypes as $examType)
            @foreach ($examType->examSubTypes as $examSubType)
                @php
                    $subTypeId = $examSubType->id;
                    $subTypeTitle = $examSubType->title;
                @endphp
                @foreach ($examSubType->examSubjectMark as $examSubjectMark)
                    @php
                        $subTypeMark = $examSubjectMark->total_marks;
                    @endphp
                    <th>
                        {{ $examSubjectMark->id }}-{{ $examType->title }}_{{$subTypeTitle}}({{$subTypeMark}})
                    </th>
                @endforeach
            @endforeach
        @endforeach
        <th>Comment</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->roll_no }}</td>
            <td>{{ $student->full_name_en }}</td>
            @foreach ($examTypes as $examType)
                @foreach ($examType->examSubTypes as $examSubType)
                    <td></td>
                @endforeach
            @endforeach
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
