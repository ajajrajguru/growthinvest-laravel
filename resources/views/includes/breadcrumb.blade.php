 
<nav class="mt-4">
    <ol class="breadcrumb">
    @foreach($breadcrumbs as $position => $item)
    @if($loop->first)
    <li class="breadcrumb-item"><a href="{{$item['url']}}" title="{{$item['name']}}" >{{$item['name']}}</a></li>
    @elseif($loop->last)
    <li class="breadcrumb-item active">{{$item['name']}}</li>
    @else
    <li class="breadcrumb-item">
        <a href="{{$item['url']}}" title="{{$item['name']}}"  class="breadcrum-link">{{$item['name']}}</a>
    </li>
    @endif

 
    @endforeach
    
</ol>
</nav>
 