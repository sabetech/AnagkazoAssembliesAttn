@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="export">
                @csrf
                <div class="card">
                    <div class="card-header" >
                        Select Date
                        <input id="date" type="text" name="date_filter" value="{{ (isset($date)) ? $date:'f' }}" required style="width:10em;">

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
                    <div class="card-header" >
                        Filter Options
                        <select class="form-control col-md-4 filter_option" name="filter_option">
                            <option value="show_all" @if ($filter_option == 'show_all') selected @endif>
                                Show All
                            </option>
                            <option value="filled" @if ($filter_option == 'filled') selected @endif>
                                Show only Those who Filled
                            </option>
                            <option value="not_filled" @if ($filter_option == 'not_filled') selected @endif>
                                Show Only Those who Did not fill
                            </option>
                        </select>

                        <div class="form-group">
                            <button class="btn btn-primary" style="float:right;margin-top:1em;" type="submit">Export to Excel</button>
                        </div>
                    </div>
                </form>
                
                <div class="card-body">
                <!-- <table class="table-responsive table-striped">
                    
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPersons as $person)
                            @if ($filter_option == 'filled')
                                @if (! $person->wasPresent($date)) 
                                    @continue
                                @endif
                            @endif

                            @if ($filter_option == 'not_filled')
                                @if ($person->wasPresent($date)) 
                                    @continue
                                @endif
                            @endif

                            <tr>
                                <th scope="row">{{ $person->rank }}</th>
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

                </table>--> 

                <ul class="list-unstyled">
                  
                  @foreach($allPersons as $person)
                  
                  <li class="media">
                    
                    <div class="media-body shadow-sm p-3 mb-5 bg-white rounded">
                      <span class="badge badge-primary">
                          {{ $person->rank }}
                      </span>
                      
                    <h5 class="mt-0 mb-1" style="float:left;">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        {{ $person->name }}
                    </h5>
                    <span class="badge badge-pill badge-info">{{ $person->Council->council }}</span>

                      @if ($person->wasPresent($date)) 
                        <span class="badge badge-pill badge-success">Form Filled</span>
                      @else
                        <span class="badge badge-pill badge-danger">Not Filled</span>
                      @endif
                      <div class="pull-right">
                        <span class="badge badge-pill badge-primary">{{ $person->tvOrOnline($date) }}</span>
                      </div>

                    </div>
                  </li>

                  @endforeach

                </ul>



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

        $(".filter_option").change(function(){

            let option = $(this).val();
            let date = $("#date").val();

            window.location = '?date_filter='+date+"&filter_option="+option;

        });

        $('input[name="date_filter"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2019,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                "format": "YYYY-MM-DD"
            }
        });

        $('input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
            
            let option = $(".filter_option").val();
            window.location = '?date_filter='+picker.startDate.format('YYYY-MM-DD')+"&filter_option="+option;
            
        });

    });

</script>
@endsection