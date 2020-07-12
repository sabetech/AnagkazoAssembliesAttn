@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >
                    Select Date
                    <input id="date" type="text" name="date" value="{{ (isset($date)) ? $date:'f' }}" required style="width:10em;">

                    <div class="custom-control custom-switch">
                        
                        @if ($formStatus->form_status == true)
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1" id="lock-label">Form is Opened</label>
                        @else
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                            <label class="custom-control-label" for="customSwitch1" id="lock-label">Form is Closed</label>
                        @endif
                    </div>
                </div>
                <!-- <div class="card-header" >
                    Filter Options
                    <select class="form-control " style="float:left">
                        <option>
                            Filled Form
                        </option>
                        <option>
                            Form Not Filled
                        </option>
                    </select>
                    <select class="form-control col-md-5" style="float:left">
                        <option>
                            Select Council
                        </option>
                        
                    </select>
                </div> -->

                <div class="card-body">

                <table class="table-responsive table-striped">
                    
                    <thead>
                        <tr>
                            <!-- <th scope="col">Rank</th> -->
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPersons as $person)
                            <tr>
                                <!-- <th scope="row">{{ $person->rank }}</th> -->
                                <td style="width:20%">{{ $person->name }}
                                <span class="badge badge-pill badge-info">{{ $person->Council->council }}</span>
                                </td>
                                <td> 
                                    @if ($person->wasPresent($date)) 
                                        <span class="badge badge-pill badge-success">Form Filled</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">Not Filled</span>
                                    @endif
                                </td>
                                <td>{{ date("M d Y", strtotime($date)) }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>

                </table>
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

        $("#customSwitch1").change(function(){
            
            $("#lock-label").text( ($(this).is(':checked')) ? 'Form is Closed' : 'Form is Opened' );
            $.post('toggle-form', function(response){

            });

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

        $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
            console.log(picker.startDate.format('YYYY-MM-DD'));
            window.location = '?date_filter='+picker.startDate.format('YYYY-MM-DD');
            
        });

    });

</script>
@endsection