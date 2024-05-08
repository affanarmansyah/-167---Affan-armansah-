<div>
    <div class="mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User</th>
                    <th>Book</th>
                    <th>Rent Date</th>
                    <th>Return Date</th>
                    <th>Actual Return Date</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if ($rentlog->isEmpty())
                    <td colspan="7">Tidak ada peminjaman</td>
                </tr>
                    @else
                @foreach ($rentlog as $data)
                    <tr class="{{$data->actual_return_date == null ? '' : ($data->return_date < $data->actual_return_date ? 'text-bg-danger' : 'text-bg-success')}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->user->username}}</td>
                        <td>{{$data->book->title}}</td>
                        <td>{{$data->rent_date}}</td>
                        <td>{{$data->return_date}}</td>
                        <td>{{$data->actual_return_date}}</td>
                        <td>{{$data->actual_return_date == null ? 'not yet return' : ($data->return_date < $data->actual_return_date ? 'late time' : 'on time')}}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>