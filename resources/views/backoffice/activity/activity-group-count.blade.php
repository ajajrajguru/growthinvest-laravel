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