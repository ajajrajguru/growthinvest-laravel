<div class="media mt-3">
    <div class="media-avatar mr-3 mw-60 mh-60">
        <img class="img-fluid" src="https://dummyimage.com/100x100" alt="Generic placeholder image">
    </div>
    <div class="media-body">
        <h6 class="mt-0 mb-0 d-inline-block font-weight-medium">{{ $comment->user->displayName() }}</h6> <small class="border-right pr-1 ml-3">{{ $comment->commentedOn() }}</small><small class="pl-1">{{ $comment->commentedOn('2') }}</small>
        <div>{{ $comment->data }}</div>
        <div class="media-action">
            <div class="reply-del-action"><a href="javascript:void(0)" class="btn btn-link btn-sm pl-0 reply-comment">Reply</a><a href="javascript:void(0)" comment-id="{{ $comment->id }}" class="btn btn-link btn-sm delete-comment">Delete</a></div>
            <div class="reply-to-comment d-none submit-query-cont">
                <textarea name="" id="" cols="" rows="3" class="form-control mb-2"></textarea>
                <button class="btn btn-sm btn-primary text-uppercase mb-3 submit-query" parent-id="{{ $comment->id }}">submit</button>
            </div>
        </div>
        @if(isset($comment->reply) && !empty($comment->reply))
            @foreach($comment->reply as $commentReply)
                @php
                    $comment = $commentReply;
                @endphp
                {!!  View::make('backoffice.clients.news-update-content', compact('comment'))->render() !!}
            @endforeach
        @endif
    </div>
</div>