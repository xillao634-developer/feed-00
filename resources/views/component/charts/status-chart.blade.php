@props(['data'])

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-chart-bar me-2"></i>Feedback by Status
        </h6>
    </div>
    <div class="card-body">
        <canvas id="statusChart" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($data)) !!},
                datasets: [{
                    label: 'Number of Feedback',
                    data: {!! json_encode(array_values($data)) !!},
                    backgroundColor: [
                        '#FFCE56', // pending - yellow
                        '#36A2EB', // in_progress - blue
                        '#4BC0C0', // resolved - teal
                        '#FF6384'  // closed - red
                    ],
                    borderColor: [
                        '#FFCE56',
                        '#36A2EB',
                        '#4BC0C0',
                        '#