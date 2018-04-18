
<div class="row">
    <!-- 1st -->
    <div class="col-sm-6 border">
        <div class="row bg-primary text-white py-2 px-3">
            <div class="col-9">Activity Group</div>
            <div class="col-3">Count</div>
        </div>
        @php
            $i = 0;
            $activityTypeList = activityTypeList();
            $countData2 = [];
        @endphp
        @foreach($countData as $groupName => $count)
         
            @php
                $i++;
                if($i % 2 == 0){
                    $countData2[$groupName] = $count;
                    continue;
                } 
            @endphp
        <!-- collapse -->
        <div data-toggle="collapse" data-target="#section_1_{{ $i }}" class="cursor-pointer">
            <div class="row py-2 px-3">
                <div class="col-9"><strong>{{ $groupName }}</strong></div>
                <div class="col-3 text-center"><strong>{{ $count }}</strong></div>
            </div>
        </div>

        <!-- collapsible     -->
        <div id="section_1_{{ $i }}" class="collapse px-3 bg-gray">
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
    @if(!empty($countData2))
    <div class="col-sm-6 border">
        <div class="row bg-primary text-white py-2 px-3">
            <div class="col-9">Activity Group</div>
            <div class="col-3">Count</div>
        </div>
        @php
            $i = 1;
        @endphp
        @foreach($countData2 as $groupName => $count)
        <!-- collapse -->
        <div data-toggle="collapse" data-target="#section_2_{{ $i }}" class="cursor-pointer">
            <div class="row py-2 px-3">
                <div class="col-9"><strong>{{ $groupName }}</strong></div>
                <div class="col-3 text-center"><strong>{{ $count }}</strong></div>
            </div>
        </div>

        <!-- collapsible     -->
        <div id="section_2_{{ $i }}" class="collapse px-3 bg-gray" >
            @if(isset($groupActivityCount[$groupName]))                   
            @foreach($groupActivityCount[$groupName] as $activityName =>$activityCount)
            <div class="row py-2">
                <div class="col-9"><span class="filter-activity-name" activity-slug="{{ $activityName }}">{{ $activityTypeList[$activityName] }}</div>
                <div class="col-3 text-center">{{ $activityCount }}</div>
            </div>
            @endforeach                    
            @endif
        </div>
        @php
            $i++;
        @endphp 
        @endforeach
    </div>
    @endif
</div>