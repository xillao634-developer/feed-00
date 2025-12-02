   @props(['data'])

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-chart-pie me-2"></i>Feedback by Category
        </h6>
    </div>
    <div class="card-body">
        <canvas id="categoryChart" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($data)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($data)) !!},
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endpush