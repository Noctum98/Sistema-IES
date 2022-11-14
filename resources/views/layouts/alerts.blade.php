@if(@session('alert_success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{@session('alert_success')}}
</div>
@endif

@if(@session('alert_danger'))
<div class="alert alert-danger">
    <i class="fas fa-times-circle"></i>
    {{@session('alert_danger')}}
</div>
@endif

@if(@session('alert_warning'))
<div class="alert alert-warning">
    <i class="fas fa-exclamation-circle"></i>
    {{@session('alert_warning')}}
</div>
@endif

@if(@session('alert_info'))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    {{@session('alert_info')}}
</div>
@endif