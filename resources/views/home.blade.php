@extends('layouts.app')

@section('content')
    <div id="mainDiv" class="container" style="margin-top: 50px">
        <div>
            <button type="button" class="btn btn-outline-primary" id="datePickerButton">
                <input id="datePicker" type="text" style="height: 0; width: 0; border: 0;" />
                Pick a date
            </button>
            <select id="tables" class="form-control" style="width:auto; float:right">
                <option value="Day">Day</option>
                <option value="Week">Week</option>
                <option selected value="Month">Month</option>
            </select>
        </div>
        Hello
    </div>
@endsection