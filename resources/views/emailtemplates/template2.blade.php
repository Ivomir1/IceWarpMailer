

@component('mail::message')
# TEMPLATE 2
{{ $mailData['label'] }} 


ID of your order is {{ $mailData['id'] }}


# Button component:
@component('mail::button', ['url' => $mailData['label']])
{{ $mailData['url'] }} 
@endcomponent



# Table component:
@component('mail::table')
    | Laravel       | Table         | Example  |
    | ------------- |:-------------:| --------:|

@endcomponent


# Subcopy component:
@component('mail::subcopy')
    This is a subcopy component
@endcomponent

Thanks,

{{ config('app.name') }}
@endcomponent
