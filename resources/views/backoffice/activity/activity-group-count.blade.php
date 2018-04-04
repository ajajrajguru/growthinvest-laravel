<table >
    <thead>
        <th>
        <td>Activity Group</td>
        <td>Count</td>
        <td>Activity Group</td>
        <td>Count</td>
        </th>
    </thead>
    <tbody>
        <tr>
        @php
        $i = 1;
        @endphp
        @foreach($activityCountSummary as $activityGroup)             
            <td>{{ $activityGroup['group_name'] }}</td>
            <td>{{ $activityGroup['count'] }}</td>  
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