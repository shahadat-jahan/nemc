@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Message Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/message') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-list-alt pr-2"></i>Messages</a>
            </div>
        </div>

        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                @if(in_array(Auth::guard('web')->user()->id, [$userMessage->created_by, $userMessage->user_id]))
                    <div class="col-sm-12">
                        @php
                            $messageBy='';
                        if($userMessage->createdBy->adminUser){
                            $messageBy = $userMessage->createdBy->adminUser->full_name;
                        }elseif($userMessage->createdBy->teacher){
                            $messageBy = $userMessage->createdBy->teacher->full_name;
                        }elseif($userMessage->createdBy->student){
                            $messageBy = $userMessage->createdBy->student->full_name_en;
                        }elseif($userMessage->createdBy->parent){
                            $messageBy = $userMessage->createdBy->parent->father_name;
                        }else{
                            $messageBy = $userMessage->createdBy->name;
                        }
                        @endphp
                        <h4><small class="text-uppercase">Recent Message</small></h4>
                        <hr>
                        <h5>{{$userMessage->subject}}</h5>
                        <h6>
                            <i class="far fa-clock"></i> Message by {{$messageBy}}, {{$userMessage->created_at->format('F j, Y, g:i A')}}
                        </h6>
                        <h5>Message:</h5>
                        <p>{!! $userMessage->message !!}</p>
                        <p>
                            <span class="badge badge-primary">Email : {{$userMessage->user->email}}</span>
                            <span class="badge {{($userMessage->is_seen == 0) ? 'badge-danger' : 'badge-success'}}">Seen: {{$userMessage->is_seen == 0 ? 'No' : 'Yes'}}</span>
                            <span
                                class="badge badge-info">Reply: {{$userMessage->is_replied == 0 ? 'Don not reply'  : 'Replied'}}</span>
                        </p>
                        @if(!empty($userMessage->file_path))
                            <div>
                                <span class="list-inline-item">Attachment File :</span>
                                <a target="_blank" href="{{ asset('nemc_files/message/'.$userMessage->file_path) }}" download title="Download attachment file">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        @endif
                        <hr>
                        @foreach($userMessage->messageReplies as $messageReply)
                            <div class="media">
                                @if(isset($messageReply->createdBy->adminUser))
                                    @if(!empty($messageReply->createdBy->adminUser->photo))
                                        <img src="{{asset($messageReply->createdBy->adminUser->photo)}}"
                                             alt="Admin image" width="70">
                                    @else
                                        <img src="{{asset('assets/global/img/male_avater.png')}}" alt="User image"
                                             width="70">
                                    @endif
                                @elseif(isset($messageReply->createdBy->student))
                                    @if(!empty($messageReply->createdBy->student->photo))
                                        <img src="{{asset($messageReply->createdBy->student->photo)}}" alt="Admin image"
                                             width="70">
                                    @else
                                        <img src="{{asset('assets/global/img/male_avater.png')}}" alt="User image"
                                             width="70">
                                    @endif
                                @elseif(isset($messageReply->createdBy->parent))
                                    <img src="{{asset('assets/global/img/male_avater.png')}}" alt="User image"
                                         width="70">
                                @else
                                    @if(!empty($messageReply->createdBy->teacher->photo))
                                        <img src="{{asset($messageReply->createdBy->teacher->photo)}}" alt="Admin image"
                                             width="70">
                                    @else
                                        <img src="{{asset('assets/global/img/male_avater.png')}}" alt="User image"
                                             width="70">
                                    @endif
                                @endif
                                <div class="media-body pl-3">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mt-0">
                                            @if(isset($messageReply->createdBy->adminUser))
                                                {{$messageReply->createdBy->adminUser->full_name}}
                                            @elseif(isset($messageReply->createdBy->student))
                                                {{$messageReply->createdBy->student->full_name_en}}
                                            @elseif(isset($messageReply->createdBy->parent))
                                                {{$messageReply->createdBy->parent->father_name}}
                                            @else
                                                {{$messageReply->createdBy->teacher->first_name}}
                                            @endif
                                        </h5>
                                        <span class="text-right"><i class="far fa-clock"></i> {{$messageReply->created_at->format('F j, Y, g:i A')}}</span>
                                    </div>
                                    <p>{{strip_tags($messageReply->reply_message)}}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <h4>Leave a Reply:</h4>
                        <p>Total <span class="badge badge-info">{{$userMessage->messageReplies->count()}}</span> replies
                        </p><br>

                        <form role="form" action="{{route('message.reply', [$userMessage->id])}}" method="post"
                              id="replyForm">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control summernote" name="reply_message" rows="3"></textarea>
                            </div>
                            @error('reply_message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="text-right">
                                <button type="submit" class="btn btn-success not-allowed" disabled><i
                                        class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                        </form>
                        <br><br>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> You are not authorized to see details.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Function to check if content is empty or whitespace only
            function isContentEmpty(contents) {
                let strippedContent = contents.replace(/<\/?[^>]+(>|$)/g, "").trim();
                // Also remove non-breaking spaces and other whitespace characters
                strippedContent = strippedContent.replace(/&nbsp;/g, '').replace(/\s+/g, '').trim();
                return strippedContent.length === 0;
            }

            $(".summernote").summernote({
                height: 150,
                callbacks: {
                    onChange: function (contents, $editable) {
                        if (isContentEmpty(contents)) {
                            $('button[type="submit"]').prop('disabled', true).addClass('not-allowed');
                        } else {
                            $('button[type="submit"]').prop('disabled', false).removeClass('not-allowed');
                        }
                    }
                }
            });

            // Form submission validation
            $('#replyForm').on('submit', function (e) {
                let content = $('.summernote').summernote('code');

                if (isContentEmpty(content)) {
                    e.preventDefault();
                    alert('Please enter a valid reply message. Whitespace only is not allowed.');
                    return false;
                }
            });
        });
    </script>
@endpush
