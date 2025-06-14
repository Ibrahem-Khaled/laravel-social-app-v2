{{-- resources/views/components/stats-card.blade.php --}}
@props([
    // أيقونة FontAwesome، مثال: "fas fa-users"
    'icon',

    // عنوان البطاقة
    'title',

    // القيمة المراد عرضها
    'value',

    // لون البطاقة: primary, success, info, warning, danger (افتراضي 'primary')
    'color' => 'primary',
])

<div class="card border-left-{{ $color }} shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-{{ $color }} text-uppercase mb-1">
                    {{ $title }}
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $value }}
                </div>
            </div>
            <div class="col-auto">
                <i class="{{ $icon }} fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>
