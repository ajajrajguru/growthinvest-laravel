
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

<div class="row">
    <!-- 1st -->
    <div class="col-sm-6 border">
        <div class="row bg-primary text-white py-2 px-3">
            <div class="col-9">Activity Group</div>
            <div class="col-3">Count</div>
        </div>
        
        @foreach($countData as $groupName => $count)
        <!-- collapse -->
        <div data-toggle="collapse" data-target="#demo" class="cursor-pointer">
            <div class="row py-2 px-3">
                <div class="col-9"><strong>{{ $groupName }}</strong></div>
                <div class="col-3 text-center"><strong>{{ $count }}</strong></div>
            </div>
        </div>

        <!-- collapsible     -->
        <div id="demo" class="collapse px-3 bg-gray">
            @if(isset($groupActivityCount[$groupName]))                   
            @foreach($groupActivityCount[$groupName] as $activityName =>$activityCount)
            <div class="row py-2">
                <div class="col-9"><span class="filter-activity-name" activity-slug="{{ $activityName }}">{{ $activityTypeList[$activityName] }}</div>
                <div class="col-3 text-center">{{ $activityCount }}</div>
            </div>
            @endforeach                    
            @endif 
        </div>
        @endforeach
    </div>

    <!-- 2nd -->
    <div class="col-sm-6 border">
        <div class="row bg-primary text-white py-2 px-3">
            <div class="col-9">Activity Group</div>
            <div class="col-3">Count</div>
        </div>
        
        @foreach($countData as $groupName => $count)
        <!-- collapse -->
        <div data-toggle="collapse" data-target="#demo2" class="cursor-pointer">
            <div class="row py-2 px-3">
                <div class="col-9"><strong>{{ $groupName }}</strong></div>
                <div class="col-3 text-center"><strong>{{ $count }}</strong></div>
            </div>
        </div>

        <!-- collapsible     -->
        <div id="demo2" class="collapse px-3 bg-gray" >
            @if(isset($groupActivityCount[$groupName]))                   
            @foreach($groupActivityCount[$groupName] as $activityName =>$activityCount)
            <div class="row py-2">
                <div class="col-9"><span class="filter-activity-name" activity-slug="{{ $activityName }}">{{ $activityTypeList[$activityName] }}</div>
                <div class="col-3 text-center">{{ $activityCount }}</div>
            </div>
            @endforeach                    
            @endif
        </div>
        @endforeach
    </div>
</div>