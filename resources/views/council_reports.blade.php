@extends('layouts.app-council')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="export-council">
                @csrf
                <div class="card">
                    <div class="card-header" >
                        Select Date
                        <input id="date" type="text" name="date_filter" value="{{ (isset($date)) ? $date:'f' }}" required style="width:10em;">

                        <div class="custom-control custom-switch">

                            @if ($formStatus->form_status == true)
                                <input type="checkbox" class="custom-control-input" id="council-switch">
                                <label class="custom-control-label" for="council-switch" id="council-lock-label">Council Form is Opened</label>
                            @else
                                <input type="checkbox" class="custom-control-input" id="council-switch" checked>
                                <label class="custom-control-label" for="council-switch" id="council-lock-label">Council Form is Closed</label>
                            @endif

                        </div>
                    </div>
                    <div class="card-header" >
                        {{-- Councils
                        <select class="form-control col-md-4 councils" name="councils">

                        </select> --}}

                        <div class="form-group">
                            <button class="btn btn-primary" style="float:right;margin-top:1em;" type="submit">Export to Excel</button>
                        </div>
                    </div>
                </form>

                <div class="card-body">

                <ul class="list-unstyled">
                    {{-- PREPARING SUM VARIABLES --}}
                    <?php
                        $ofaakor_pastors_who_prayed = 0;
                        $ofaakor_total_pastors = 0;

                        $ofaakor_minister_shepherd_who_prayed = 0;
                        $ofaakor_minister_shepherds = 0;

                        $ofaakor_gwo_who_prayed = 0;
                        $ofaakor_gwos = 0;

                        $ofaakor_center_overseers_who_prayed = 0;
                        $ofaakor_center_overseers = 0;

                        $ofaakor_shepherds_who_prayed = 0;
                        $ofaakor_shepherds = 0;

                        $ofaakor_members_who_prayed = 0;
                        $ofaakor_members = 0;



                    ?>

                    @for($i = 9;$i <= 15;$i++)

                    <li class="media">

                        <div class="media-body shadow-sm p-3 mb-5 bg-white rounded">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                              </svg>
                            <h5 class="mt-0 mb-1">
                                {{ $councils[$i]->council }} - OFAAKOR COUNCIL<br>
                                <label class="">{{ date("F d, Y", strtotime($date)) }}</label>
                            </h5>
                            <label>Number of Pastors Who Prayed
                                <h4>
                                    <span class="badge badge-primary">
                                        <?php

                                            $val_prayed = $councils[$i]->getPastorsWhoFlowed($date)->count();
                                            $val_total = $councils[$i]->getTotalPastors()->count();
                                            $display_val = '';

                                            if (0 == $val_total){
                                               $display_val = 'N/a';
                                            }else{
                                                $ofaakor_pastors_who_prayed += $val_prayed;
                                                $ofaakor_total_pastors += $val_total;
                                                $display_val = $val_prayed . '/' . $val_total;
                                            }

                                        ?>
                                        {{ $display_val }}

                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of Minister shepherds who prayed
                                <h4>
                                    <span class="badge badge-secondary">
                                        <?php

                                        $val_prayed = $councils[$i]->getMinisterShepherdsWhoFlowed($date)->count();
                                        $val_total = $councils[$i]->getTotalMinisterShepherds()->count();
                                        $display_val = '';

                                        if (0 == $val_total){
                                            $display_val = 'N/a';
                                        }else{
                                            $ofaakor_minister_shepherd_who_prayed += $val_prayed;
                                            $ofaakor_minister_shepherds += $val_total;
                                            $display_val = $ofaakor_minister_shepherd_who_prayed . '/' . $ofaakor_minister_shepherds;
                                        }


                                    ?>
                                    {{$display_val}}


                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of GWOs who prayed
                                <h4>
                                    <span class="badge badge-info">
                                        <?php

                                        $val_prayed = $councils[$i]->getGWOwhoFlowed($date)->count();
                                        $val_total = $councils[$i]->getTotalGWOs()->count();
                                        $display_val = '';

                                        if (0 == $val_total){
                                            $display_val = 'N/a';
                                        }else{
                                            $ofaakor_gwo_who_prayed += $val_prayed;
                                            $ofaakor_gwos += $val_total;
                                            $display_val = $ofaakor_gwo_who_prayed . '/' . $ofaakor_gwos;
                                        }


                                    ?>
                                    {{$display_val}}
                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of Shepherds who prayed
                                <h4>
                                    <span class="badge badge-dark">
                                        <?php

                                            $val_prayed = $councils[$i]->getShepherdsWhoFlowed($date);
                                            $val_total = $councils[$i]->getTotalShepherds()->count();
                                            $display_val = '';

                                            if (0 == $val_total){
                                               $display_val = 'N/a';
                                            }else{
                                                $ofaakor_shepherds_who_prayed += $val_prayed;
                                                $ofaakor_shepherds += $val_total;
                                                $display_val = $val_prayed . '/' . $val_total;
                                            }

                                        ?>
                                        {{ $display_val }}


                                    </span>
                                </h4>
                            </label><br>
                            @if (15 === $i)
                            <label>Number of Center Overseers who prayed
                                <h4>
                                    <span class="badge badge-dark">
                                        <?php

                                            $val_prayed = $councils[$i]->getCenterLeadersWhoFlowed($date)->count();
                                            $val_total = $councils[$i]->getCenterLeaders()->count();
                                            $display_val = '';

                                            if (0 == $val_total){
                                               $display_val = 'N/a';
                                            }else{
                                                $ofaakor_center_overseers_who_prayed += $val_prayed;
                                                $ofaakor_center_overseers += $val_total;
                                                $display_val = $val_prayed . '/' . $val_total;
                                            }

                                        ?>
                                        {{ $display_val }}
                                    </span>
                                </h4>
                            </label><br>
                            @endif


                            <label>Number of Members who prayed
                                <h4>
                                    <span class="badge badge-warning">
                                        <?php

                                            $val_prayed = $councils[$i]->getTotalMembersWhoFlowed($date);
                                            $val_total = $councils[$i]->getTotalMembersAvg();
                                            $display_val = '';

                                            if (0 == $val_total){
                                               $display_val = 'N/a';
                                            }else{
                                                $ofaakor_members_who_prayed += $val_prayed;
                                                $ofaakor_members += $val_total;
                                                $display_val = $val_prayed . '/' . $val_total;
                                            }

                                        ?>
                                        {{ $display_val }}

                                    </span>
                                </h4>
                            </label>

                        </div>

                      </li>

                    @endfor

                      {{-- OFAAKOR TOTALS GOES HERE --}}
                    <li class="media">

                        <div class="media-body shadow-sm p-3 mb-5 bg-white rounded">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                              </svg>
                            <h5 class="mt-0 mb-1">
                                OFAAKOR COUNCIL<br>
                                <label class="">{{ date("F d, Y", strtotime($date)) }}</label>
                            </h5>
                            <label>Number of Pastors Who Prayed
                                <h4>
                                    <span class="badge badge-primary">
                                        {{ $ofaakor_pastors_who_prayed }} /
                                        {{ $ofaakor_total_pastors }}
                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of Minister shepherds who prayed
                                <h4>
                                    <span class="badge badge-secondary">
                                    {{ $ofaakor_minister_shepherd_who_prayed }}/
                                    {{ $ofaakor_minister_shepherds }}

                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of GWOs who prayed
                                <h4>
                                    <span class="badge badge-info">
                                        {{ $ofaakor_gwo_who_prayed }} / {{ $ofaakor_gwos }}
                                    </span>
                                </h4>
                            </label><br>
                            <label>Number of Shepherds who prayed
                                <h4>
                                    <span class="badge badge-dark">
                                        {{$ofaakor_shepherds_who_prayed}} /{{ $ofaakor_shepherds }}
                                    </span>
                                </h4>
                            </label><br>

                            <label>Number of Center Overseers who prayed
                                <h4>
                                    <span class="badge badge-dark">
                                        {{ $ofaakor_center_overseers_who_prayed }}
                                        /
                                        {{ $ofaakor_center_overseers }}
                                    </span>
                                </h4>
                            </label><br>

                            <label>Number of Members who prayed
                                <h4>
                                    <span class="badge badge-warning">
                                        {{ $ofaakor_members_who_prayed }} /
                                        {{ $ofaakor_members }}
                                    </span>
                                </h4>
                            </label>

                        </div>

                      </li>





                    </ul>

                    <hr />
                    {{-- THE REMAINDER OF THE CODE IS FOR THE OTHER COUNCILS --}}
                    <ul class="list-unstyled">
                    <?php $count = 0; ?>
                  @foreach($councils as $council)
                    <?php $count++ ?>

                    @if ($count == 5)
                        @continue;
                    @endif

                    <li class="media">

                    <div class="media-body shadow-sm p-3 mb-5 bg-white rounded">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                            <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                          </svg>
                        <h5 class="mt-0 mb-1">
                            {{ $council->council }}<br>
                            <label class="">{{ date("F d, Y", strtotime($date)) }}</label>
                        </h5>
                        <label>Number of Pastors Who Prayed
                            <h4>
                                <span class="badge badge-primary">
                                    {{ $council->getPastorsFlowRatio($date) }}

                                </span>
                            </h4>
                        </label><br>
                        <label>Number of Minister shepherds who prayed
                            <h4>
                                <span class="badge badge-secondary">
                           {{ $council->getMinisterShepheredFlowRatio($date) }}

                                </span>
                            </h4>
                        </label><br>
                        <label>Number of GWOs who prayed
                            <h4>
                                <span class="badge badge-info">
                                    {{ $council->getGWO_FlowRatio($date) }}
                                </span>
                            </h4>
                        </label><br>
                        <label>Number of Shepherds who prayed
                            <h4>
                                <span class="badge badge-dark">
                                    {{ $council->getShepherdsWhoFlowed($date) }} /
                                    {{ $council->getTotalShepherds()->count() }}
                                </span>
                            </h4>
                        </label><br>
                        <label>Number of Members who prayed
                            <h4>
                                <span class="badge badge-warning">
                                    {{ $council->getTotalMembersWhoFlowed($date) }} /
                                    {{ $council->getTotalMembersAvg() }}
                                </span>
                            </h4>
                        </label>

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

        $("#council-switch").change(function(){

            $("#council-lock-label").text( ($(this).is(':checked')) ? 'Council Form is Closed' : 'Council Form is Opened' );
            $.post('toggle-form-council', function(response){

            });

        });


        $(".council").change(function(){

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
