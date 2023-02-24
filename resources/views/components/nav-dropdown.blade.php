@props([
'icon' => null,
'label' => null,
'route' => null,
'url' => null,
'href' => null,
'click' => null,
'params' => [],
'active' => false,
])
@php
   $identifier= \Illuminate\Support\Str::studly($label);

    if(is_string($active) && strlen($active)>2 && !in_array(strtolower($active),['true','false']) ) {
        $active = url_contains($active);
    }
    if ($route) {
        $href = route($route, $params);
        $active = $active ?: request()->routeIs($route);
    } else if ($url){
        $href = url($url);

        $active = $active  ?: $href == url()->current();

       //  dd($href, $active);
    }


    $attributes = $attributes->class([
        'nav-link',
        'collapsed' => !$active,
    ]);
@endphp
<li class="nav-item">

    <a href="#"
       data-bs-toggle="collapse"
       data-bs-target="#collapse{{$identifier}}"
       aria-expanded="false"
       aria-controls="collapse{{$identifier}}"
        {{ $attributes->only('class') }}>

        <x-rpd::icon :name="$icon"/>
        <span class="text-capitalize">{{ $label }}</span>
    </a>
    <div id="collapse{{$identifier}}" data-parent="#accordionSidebar" class="collapse {{ $active ? 'show' : '' }}" style="">
        <div class="bg-white py-2 collapse-inner rounded">
            {{ $slot }}
        </div>
    </div>

</li>
