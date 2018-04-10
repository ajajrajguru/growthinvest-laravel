<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
            <th>Activity Group</th>
            <th>Count</th>
            <th>Activity Group</th>
            <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            @php
            $i = 1;
            @endphp
            @foreach($countData as $groupName => $count)             
                <td>{{ $groupName }}</td>
                <td>{{ $count }} </td>  
                @if($i % 2 == 0) 
                    </tr>
                    <tr>
                @endif

                @php
                    $i++;
                @endphp      
            @endforeach
            </tr>
        </tbody>

    </table>
</div>