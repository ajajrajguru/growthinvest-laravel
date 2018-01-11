 
<ul class="fnb-breadcrums flex-row">
    @foreach($breadcrumbs as $position => $item)
    @if($loop->first)
    <li class="fnb-breadcrums__section">
        <a href="/" title="Home" target="_blank">
           <p class="fnb-breadcrums__title ellipsis-desk" title="{{$item['name']}}">{{$item['name']}}</p>
        </a>
    </li>
    @elseif($loop->last)
    <li class="fnb-breadcrums__section ellipsis-desk">
            <p class="fnb-breadcrums__title ellipsis-desk" title="{{$item['name']}}">{{$item['name']}}</p>
    </li>
    @else
    <li class="fnb-breadcrums__section ellipsis-desk">
        <a href="{{$item['url']}}" title="{{$item['name']}}" target="_blank" class="breadcrum-link">
            <p class="fnb-breadcrums__title ellipsis-desk" title="{{$item['name']}}">{{$item['name']}}</p>
        </a>
    </li>
    @endif

    @if(!$loop->last)
    <li class="fnb-breadcrums__section">
        <!-- <a href="#"> -->
            <p class="fnb-breadcrums__title">/</p>
        <!-- </a> -->
    </li>
    @endif
    @endforeach
    
</ul>