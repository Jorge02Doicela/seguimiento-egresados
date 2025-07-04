@props([
    'title' => 'Sin título',
    'value' => 'N/A',
    'icon' => 'bi-graph-up',
    'bg' => 'primary',
])

<div class="col-md-4 mb-4">
    <div class="card text-white bg-{{ $bg }} shadow">
        <div class="card-body d-flex align-items-center">
            <i class="bi {{ $icon }} me-3 fs-1"></i>
            <div>
                <h6 class="card-title mb-1">{{ $title }}</h6>
                <h4 class="mb-0">{{ $value }}</h4>
            </div>
        </div>
    </div>
</div>
