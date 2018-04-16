
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            
<tr>
               <td>
                   <table class="table">
                       <tr>
                           <th width="80%">Activity Group</th>
                           <th width="20%">Count</th>
                       </tr>
                   </table>
               </td>
               <td>
                   <table class="table">
                       <tr>
                           <th width="80%">Activity Group</th>
                           <th width="20%">Count</th>
                       </tr>
                   </table>
               </td>
           </tr>
        </thead>
        <tbody>
            <tr>
            @php
            $i = 1;
            $activityTypeList = activityTypeList();
            @endphp
            @foreach($countData as $groupName => $count)  
                <td>
                    <table class="table">
                        <tr style="font-weight: bold;">
                            <td width="80%">{{ $groupName }}</td>
                            <td width="20%">{{ $count }} </td> 
                        </tr>
                       
                            @if(isset($groupActivityCount[$groupName]))
                               
                                @foreach($groupActivityCount[$groupName] as $activityName =>$activityCount)
                                    <tr >
                                        <td width="80%"><span class="filter-activity-name" activity-slug="{{ $activityName }}">{{ $activityTypeList[$activityName] }}</td>
                                        <td width="20%">{{ $activityCount }} </td> 
                                    </tr>
                                @endforeach
                                
                           @endif 

                        
                    </table>  
                </td>         
                 
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