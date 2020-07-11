@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Take Attendance</div>

                <div class="card-body" style="margin:auto">
                    <form method="POST" action="{{ route('postAttendance') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="person_name" class="col-md-4 col-form-label text-md-right">Council</label>

                            <div class="">
                                <select class="form-control col-md-4 council-find" id="council" name="council" style="width:100%;" required>
                                
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="person_name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="">
                                <select class="form-control col-md-4 person-find" id="person_name" name="person_name" style="width:100%;" required disabled></select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Date</label>

                            <div class="">
                                <input id="date" type="text" name="date" required>

                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="rank" class="col-md-4 col-form-label text-md-right">Rank</label>
                            <div class="">
                                <select class="form-control rank" id="rank" name="rank" style="width:100%;">
                                    <option value='Pastor'>Pastor</option>
                                    <option value='Minister Shepherd'>Minister Shepherd</option>    
                                    <option value='GWO'>GWO</option>    
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="tv_or_online" class="col-md-4 col-form-label text-md-right">TV or Online</label>
                            <div class="">
                                <select class="form-control tv_or_online" id="tv_or_online" name="tv_or_online" style="width:100%;">
                                    <option value='Online'>Online</option>
                                    <option value='Tv'>TV</option>    
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float:right">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    
    $(document).ready(function(){
        $.noConflict();

        $('.council-find').select2({
            placeholder: 'Choose your Council',
            ajax: {
	            url: '/getcouncils',
	            delay: 250,
	            data: function (params) {
	              var query = {
	                search: params.term,
	              }
	              return query;
	            },
	            processResults: function (data) {
	              return {
	                  results: data
	              };
	            }
	        }
        })

        let data = {};
        $('.council-find').on('select2:select', function (e) {
            data = e.params.data;
            $('.person-find').prop('disabled', false);
        });

        $('.person-find').select2({
		    placeholder: 'Choose your name',
            ajax: {
	            url: '/getpersons',
	            delay: 250,
	            data: function (params) {
	              var query = {
	                search: params.term,
                    council_id: data.id
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
        
        $('input[name="date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2019,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                "format": "YYYY-MM-DD"
            }
        });

        $(".tv_or_online").select2({
            placeholder:'Tv Or Online'
        });
       
    });


</script>

@endsection