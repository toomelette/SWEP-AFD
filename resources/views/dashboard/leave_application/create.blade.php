@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Create Leave Application</h1>
  </section>

  <section class="content">

    <div class="box">
    
      <div class="box-header with-border">
        <h3 class="box-title">Form</h3>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form role="form" method="POST" autocomplete="off" action="{{ route('dashboard.leave_application.store') }}">

        <div class="box-body">
     
          @csrf    

          <input type="hidden" name="department_name" id="department_name" value="{{ old('department_name') }}">

          {!! FormHelper::textbox(
             '4', 'lastname', 'text', 'Lastname *', 'Lastname', old('lastname'), $errors->has('lastname'), $errors->first('lastname'), ''
          ) !!}

          {!! FormHelper::textbox(
             '4', 'firstname', 'text', 'Firstname *', 'Firstname', old('firstname'), $errors->has('firstname'), $errors->first('firstname'), ''
          ) !!}

          {!! FormHelper::textbox(
             '4', 'middlename', 'text', 'Middlename *', 'Middlename', old('middlename'), $errors->has('middlename'), $errors->first('middlename'), ''
          ) !!} 

          {!! FormHelper::datepicker('4', 'date_of_filling',  'Date of Filling *', old('date_of_filling'), $errors->has('date_of_filling'), $errors->first('date_of_filling')) !!}
          
          {!! FormHelper::textbox(
             '4', 'position', 'text', 'Position *', 'Position', old('position'), $errors->has('position'), $errors->first('position'), ''
          ) !!} 

          {!! FormHelper::textbox_numeric(
            '4', 'salary', 'text', 'Salary (Monthly) *', 'Salary', old('salary'), $errors->has('salary'), $errors->first('salary'), ''
          ) !!}
          

          {{-- TYPE OF LEAVE --}} 
          <div class="col-md-12" style="margin-bottom:20px;">
              
            <h4>TYPE OF LEAVE:</h4>

            {!! FormHelper::select_static('3', 'type', 'Leave Type *', old('type'), [
              'Vacation' => 'T1001',
              'Sick' => 'T1002',
              'Maternity' => 'T1003',
              'Others' => 'T1004',
            ], $errors->has('type'), $errors->first('type'), '', '') !!}
          
            <div class="col-md-9" id="type_vacation_div">
                
              {!! FormHelper::select_static('3', 'type_vacation', 'Vacation Type *', old('type_vacation'), [
                'To seek employment' => 'TV1001',
                'others' => 'TV1002',
              ], $errors->has('type_vacation'), $errors->first('type_vacation'), '', '') !!}
                
              {!! FormHelper::textbox(
                 '9', 'spent_sick_inhospital_specified', 'text', 'If (others) specify', 'Specify', old('spent_sick_inhospital_specified'), $errors->has('spent_sick_inhospital_specified'), $errors->first('spent_sick_inhospital_specified'), ''
              ) !!} 

            </div>

            <div class="col-md-9" id="type_others_div">

              {!! FormHelper::textbox(
                 '12', 'type_others_specified', 'text', 'If (others) specify *', 'Specify', old('type_others_specified'), $errors->has('type_others_specified'), $errors->first('type_others_specified'), ''
              ) !!} 
              
            </div>  

          </div>


          {{-- WHERE LEAVE WILL BE SPENT --}} 
          <div class="col-md-12" style="margin-bottom:20px;">
              
            <h4>WHERE LEAVE WILL BE SPENT:</h4>

            <div class="col-md-12">
              
              {!! FormHelper::select_static('3', 'spent_vacation', 'In case of Vacation Leave', old('spent_vacation'), [
                'Within the Philippines' => 'SV1001',
                'Abroad' => 'SV1002',
              ], $errors->has('spent_vacation'), $errors->first('spent_vacation'), '', '') !!}

              <div class="col-md-9" id="spent_vacation_abroad_div">
                  
                {!! FormHelper::textbox(
                   '12', 'spent_vacation_abroad_specified', 'text', 'If (Abroad) specify', 'Specify', old('spent_vacation_abroad_specified'), $errors->has('spent_vacation_abroad_specified'), $errors->first('spent_vacation_abroad_specified'), ''
                ) !!}

              </div>

            </div>

            <div class="col-md-12">
              
              {!! FormHelper::select_static('3', 'spent_sick', 'In case of Sick Leave', old('spent_sick'), [
                'In Hospital' => 'SS1001',
                'Out Patient' => 'SS1002',
              ], $errors->has('spent_sick'), $errors->first('spent_sick'), '', '') !!}

              <div class="col-md-9" id="spent_sick_inHospital_div">
                  
                {!! FormHelper::textbox(
                   '12', 'spent_sick_inhospital_specified', 'text', 'If (In Hospital) specify', 'Specify', old('spent_sick_inhospital_specified'), $errors->has('spent_sick_inhospital_specified'), $errors->first('spent_sick_inhospital_specified'), ''
                ) !!}

              </div>

              <div class="col-md-9" id="spent_sick_outPatient_div">
                  
                {!! FormHelper::textbox(
                   '12', 'spent_sick_outpatient_specified', 'text', 'If (Out Patient) specify', 'Specify', old('spent_sick_outpatient_specified'), $errors->has('spent_sick_outpatient_specified'), $errors->first('spent_sick_outpatient_specified'), ''
                ) !!}

              </div>

            </div>

          </div>


          {{-- NUMBER OF WORKING DAYS --}}
          <div class="col-md-12" style="margin-bottom:20px;">
              
            <h4>NUMBER OF WORKING DAYS APPLIED:</h4>  

            {!! FormHelper::textbox(
               '4', 'working_days_for', 'text', 'Number of Days *', 'Number of Days', old('working_days_for'), $errors->has('working_days_for'), $errors->first('working_days_for'), ''
            ) !!}

            {!! FormHelper::datepicker('4', 'working_days_date_from',  'Date From *', old('working_days_date_from'), $errors->has('working_days_date_from'), $errors->first('working_days_date_from')) !!}

            {!! FormHelper::datepicker('4', 'working_days_date_to',  'Date To *', old('working_days_date_to'), $errors->has('working_days_date_to'), $errors->first('working_days_date_to')) !!}

          </div>


          {{-- COMMUTATION --}}
          <div class="col-md-12" style="margin-bottom:20px;">
              
            <h4>COMMUTATION:</h4>  

            {!! FormHelper::select_static('3', 'commutation', 'Commutation', old('commutation'), [
              'Requested' => 'true',
              'Not Requested' => 'false',
            ], $errors->has('commutation'), $errors->first('commutation'), '', '') !!}

          </div>


        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save</button>
        </div>

      </form>

    </div>

  </section>

@endsection


@section('modals')

  @if(Session::has('ACCOUNT_CREATE_SUCCESS'))
    {!! HtmlHelper::modal('account_create', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('ACCOUNT_CREATE_SUCCESS')) !!}
  @endif

@endsection 


@section('scripts')

  <script type="text/javascript">


    @if(Session::has('ACCOUNT_CREATE_SUCCESS'))
      $('#account_create').modal('show');
    @endif


    {!! JSHelper::datepicker_caller('date_of_filling', 'mm/dd/yy', 'bottom') !!}
    {!! JSHelper::datepicker_caller('working_days_date_from', 'mm/dd/yy', 'top') !!}
    {!! JSHelper::datepicker_caller('working_days_date_to', 'mm/dd/yy', 'top') !!}


    $('#type_vacation_div').hide();
    $('#type_others_div').hide();


    $(document).on("change", "#type", function () {
      var val = $(this).val();
        if(val == "T1001"){ 
          $('#type_vacation_div').show();
          $('#type_others_div').hide();
          $('#type_vacation').val('');
        }else if(val == "T1004"){
          $('#type_vacation_div').hide();
          $('#type_others_div').show();
        }else{
          $('#type_vacation_div').hide();
          $('#type_others_div').hide();
        }
   });


    $('#spent_sick_inHospital_div').hide();
    $('#spent_sick_outPatient_div').hide();


    $(document).on("change", "#spent_sick", function () {
        var val = $(this).val();
          if(val == "SS1001"){ 
            $('#spent_sick_inHospital_div').show();
            $('#spent_sick_outPatient_div').hide();
          }else if(val == "SS1002"){
            $('#spent_sick_outPatient_div').show();
            $('#spent_sick_inHospital_div').hide();
          }else{
            $('#spent_sick_outPatient_div').hide();
            $('#spent_sick_inHospital_div').hide();
          }
    });

  </script> 
    
@endsection