

@component('mail::message')
# Introduction
{{ $mailData['label'] }} 


ID of your order is {{ $mailData['id'] }}


# Button component:
@component('mail::button', ['url' => $mailData['label']])
{{ $mailData['url'] }} 
@endcomponent

# Panel component:
@component('mail::panel')
    This is a panel
@endcomponent

# Table component:
@component('mail::table')
    | Laravel       | Table         | Example  |
    | ------------- |:-------------:| --------:|
    | Col 2 is      | Centered      | $10      |
    | Col 3 is      | Right-Aligned | $20      |
@endcomponent


# Subcopy component:
@component('mail::subcopy')
    This is a subcopy component
@endcomponent

Thanks,

{{ config('app.name') }}
@endcomponent
