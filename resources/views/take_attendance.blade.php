@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Take Attendance</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('postAttendance') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="person_name" class="col-md-4 col-form-label text-md-right">Council</label>

                            <div class="">
                                <select class="form-control col-md-4 council-find" id="council" name="council" style="width:100%;">
                                
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="person_name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="">
                                <select class="form-control col-md-4 person-find" id="person_name" name="person_name" style="width:100%;"></select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Date</label>

                            <div class="">
                                <input id="date" type="text" name="date" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tv_or_online" class="col-form-label text-md-right">TV or Online</label>
                            <select class="form-control col-md-4 col-form-label text-md-right" id="tv_or_online" name="tv_or_online">
                                <option value='Tv'>TV</option>
                                <option value='Online'>Online</option>    
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

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

       
    });


</script>

@endsection