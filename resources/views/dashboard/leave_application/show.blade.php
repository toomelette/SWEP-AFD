@php

  $types = ['Vacation' => 'T1001', 'Sick' => 'T1002', 'Maternity' => 'T1003', 'Others' => 'T1004'];
  $inclusive_dates = Carbon::parse($leave_application->working_days_from)->format('M d, Y') .' - '. Carbon::parse($leave_application->working_days_to)->format('M d, Y');

@endphp

@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Leave Application Details</h1>
    <div class="pull-right" style="margin-top: -25px;">
      {!! HtmlHelper::back_button(['dashboard.leave_application.index', 'dashboard.leave_application.user_index']) !!}
    </div>
</section>

<section class="content">

    <div class="box">
        
      <div class="box-header with-border">
        
        <h3 class="box-title">Details</h3>

        <div class="box-tools">
          <a href="{{ route('dashboard.leave_application.print', [$leave_application->slug, 'front']) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print</a>
          <a href="{{ route('dashboard.leave_application.edit', $leave_application->slug) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</a>
        </div>

      </div>
      
      <div class="box-body">

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Agency: <strong>{{ $leave_application->agency }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Lastname: <strong>{{ $leave_application->lastname }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">firstname: <strong>{{ $leave_application->firstname }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">middlename: <strong>{{ $leave_application->middlename  }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Date of Filing: <strong>{{ DataTypeHelper::date_out($leave_application->date_of_filing) }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Position: <strong>{{ $leave_application->position }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Salary: <strong>{{ number_format($leave_application->salary, 2) }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Type of Leave: 
            <strong>
                    
              @foreach($types as $name => $key)
                @if($key ==  $leave_application->type)
                  {{ $name }}
                @endif
              @endforeach
          
            </strong>
          </span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Number of Days: <strong>{{ $leave_application->working_days }}</strong></span>
        </div>

        <div class="col-md-12" style="padding-bottom:10px;">
          <span style="font-size: 15px; ">Inclusive Dates: <strong>{{ $inclusive_dates }}</strong></span>
        </div>

      </div>

    </div>

</section>

@endsection

