@extends('master')

@section('content')
    <div class="row">
        <h4>Edit Details</h4>
    </div>

    <div class="row">

        <div class="large-2 columns">
            {!! HTML::image($member->getAvatarThumbnailPath(200), $member->fullName(), ['width' => 200]) !!}
        </div>

        <div class="large-2 columns left">
            <form method="POST" action="/member/{{ $member->id }}/avatar" id="member-avatar-upload" class="dropzone" style="height:40px;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    <div class="row">
        <form method="POST" action="/member/{!! $member->slug !!}/edit">

            <input name="_token" type="hidden" value="{!! csrf_token() !!}"/>

            <div class="row panel radius">
                <div class="large-4 columns">
                    <label>First Name</label>
                    <input type="text" placeholder="Jamie" name="first_name" value="{!! $member->first_name !!}">
                </div>
                <div class="large-4 columns">
                    <label>Last Name</label>
                    <input type="text" placeholder="Doe" name="last_name" value="{!! $member->last_name !!}">
                </div>
                <div class="large-4 columns">
                    <label>Role</label>
                    <input type="text" placeholder="Analyst" name="role" value="{!! $member->role !!}">
                </div>
                <div class="large-3 columns">
                    <label>email address</label>
                    <input type="text" placeholder="jamie.doe@crowdcube.com" name="email" value="{!! $member->email !!}">
                </div>
                <div class="large-2 columns">
                    <label>Telephone</label>
                    <input type="text" placeholder="01392 123456" name="telephone" value="{!! $member->telephone !!}">
                </div>
                <div class="large-1 columns">
                    <label>Extension</label>
                    <input type="text" placeholder="123" name="extension" value="{!! $member->extension !!}">
                </div>
                <div class="large-2 columns">
                    <label>Skype Name</label>
                    <input type="text" placeholder="jamiedoe.crowdcube" name="skype_name" value="{!! $member->skype_name !!}">
                </div>
                <div class="large-2 columns">
                    <label>Location</label>
                    {!! Form::select('location_id', $locations, $member->location->id) !!}
                </div>
                <div class="large-2 columns">
                    <label>Department</label>
                    {!! Form::select('department_id', $departments, $member->department->id) !!}
                </div>
                <div class="large-12 columns">
                    <button class="small button" title="Update">Update</button>
                </div>
            </div>

        </form>

    </div>

@endsection

@section('scripts')
    <script>
        Dropzone.options.memberAvatarUpload = {
            paramName: "file",
            maxFilesize: 2, // MB
            maxFiles: 1, // Do not allow multiple uploads
            dictDefaultMessage: 'Drag your new avatar here'
        };
    </script>
@endsection
