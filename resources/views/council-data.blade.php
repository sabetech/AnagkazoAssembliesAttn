@extends('layouts.app-council')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- @if($formStatus->form_status) --}}
                <div class="card-header">{{ $council->council }} Attendance for {{ date('M d, Y') }}</div>

                <div class="card-body" style="margin:auto">
                    <form method="POST" action="{{ route('postCouncilAttendance') }}">
                        @csrf

                        <h3>{{ $council->council }}</h3>
                        <input type='hidden' name='council_id' value="{{$council->id}}"/>
                        <hr>
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Date</label>

                            <div class="">
                                <input id="date" type="hidden" name="date" style="width:15em;">
                                <label class="form-control">{{ date("F d, Y") }}</label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="mission" class="col-md-4 col-form-label text-md-right">Branch/Missions</label>
                            <div class="">
                                <select class="form-control mission-find" id="mission" name="mission" style="width:15em;">

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rank" class="col-md-4 col-form-label text-md-right">Rank</label>
                            <div class="">
                                <select class="form-control rank" id="rank" name="rank" style="width:15em;">

                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="person_name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="">
                                <select class="form-control col-md-4 person-find" id="person_name" name="person_name" style="width:15em;" required disabled></select>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label for="person_name"
                            class="col-md-4 col-form-label text-md-right">
                            Select Shepherds that Participated in FLOW Today
                            </label>

                            <select class="form-control pastors-shepherds"
                            id="pastors-shepherds" name="pastors-shepherds[]"
                            style="width:15em;" multiple='multiple' disabled>
                                <option>N/a</option>
                            </select>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="person_name"
                            class="col-md-4 col-form-label text-md-right">
                            HOW MANY OF YOUR MEMBERS PARTICIPATED IN THE FLOW TODAY?
                            </label>

                            <input type="number" name="flow_member_attendance" placeholder="N/a"/>
                        </div>

                        <button type="submit" class="btn btn-primary" style="float:right;">
                            Submit
                        </button>

                    </form>
                </div>
                {{-- @else
                    <div class="card-header">Form is currently Closed</div>
                @endif --}}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>


    $(document).ready(function(){
        $.noConflict();

        let branch_val = {};
        let rank_val = {'id': 'Pastor'};
        let person = {};

        $('.mission-find').select2({
            placeholder: 'Choose your Mission/Branch',
            ajax: {
	            url: '/getbranches',
	            delay: 250,
	            data: function (params) {
	              var query = {
	                search: params.term,
                    council_id: {!!$council->id!!}
	              }
	              return query;
	            },
	            processResults: function (data) {
	              return {
	                  results: data
	              };
	            }
	        }
        });

        $('.person-find').select2({
		    placeholder: 'Choose your name',
            ajax: {
	            url: '/getpastors',
	            delay: 250,
	            data: function (params) {
	              var query = {
	                search: params.term,
                    council_id: {!!$council->id!!},
                    branch: branch_val.id,
                    rank: rank_val.id
	              }
	              return query;
	            },
	            processResults: function (data) {
	              return {
	                  results: data
	              };
	            }
	        }
        });

        $('.person-find').on('select2:select', function(e){
            person = e.params.data;
            $('.pastors-shepherds').prop('disabled', false);
        });

        $('.pastors-shepherds').select2({
            placeholder: 'Shepherds who FLOWED',
            ajax: {
	            url: '/shepherds',
	            delay: 250,
	            data: function (params) {
	              var query = {
                    search: params.term,
                    branch: branch_val.id,
                    person_id: person.id
	              }
	              return query;
	            },
	            processResults: function (data) {
	              return {
	                  results: data
	              };
	            }
	        }
        });

        $('.mission-find').on('select2:select', function (e) {
            branch_val = e.params.data;
            $('.person-find').prop('disabled', false);
        });

        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2019,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                "format": "YYYY-MM-DD"
            }
        });

        $(".rank").select2({
            placeholder:'Select Rank',
            data:[
                    {id:'Pastor', text:'Pastor'},
                    {id:'Minister Shepherd', text:'Minister Shepherd'},
                    {id:'GWO', text:'GWO'},
                ]
        })

        $(".rank").on('select2:select', function(e){
            rank_val = e.params.data;
        });

    });


</script>

@endsection
