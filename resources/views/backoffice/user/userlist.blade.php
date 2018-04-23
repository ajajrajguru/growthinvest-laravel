<div class="table-responsive mt-3">
    <table id="datatable-users" class="table dataFilterTable table-hover table-solid-bg">
        <thead>
            <tr>
                <th class="w-search">Name</th>
                <th class="w-search toggle-mob">Email</th>
                <th class="w-search toggle-mob">Role</th>
                <th class="w-search">Firm</th>
                <th class="toggle-mob" style="min-width: 100px;">Action</th>
            </tr>
        </thead>
        <thead>
            <tr class="filters">
                <td class="data-search-input" data-search="name"></td>
                <td class="data-search-input toggle-mob" data-search="email"></td>
                <td class="data-search-input toggle-mob" data-search="role"></td>
                <td class="data-search-input" data-search="firm"></td>
                <td class="toggle-mob"></td>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr >

                    <td><b><a href="{{ url('backoffice/user/'.$user->gi_code.'/intermediary-registration')}}">{{  title_case($user->first_name.' '.$user->last_name) }}</a></b></td>
                    <td class="toggle-mob">{{  $user->email }}</td>
                    <td class="toggle-mob">{{ title_case($user->roles()->pluck('display_name')->implode(' ')) }} </td>
                    <td>@if(!empty($user->firm)) <a href="{{ url('backoffice/firms/'.$user->firm->gi_code.'/')}}" target="_blank">{{  $user->firm->name  }}</a> @endif</td>
                    <td class="toggle-mob">
                        <!-- <select data-id="78523" class="firm_actions form-control form-control-sm" edit-url="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">
                        <option>--select--</option>
                        <option value="edit-intermediary">Edit Profile</option>
                        </select> -->
                        <a href="{{ url('backoffice/user/'.$user->gi_code.'/intermediary-registration')}}">View Profile</a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>