@if(!empty($customer->payments))
    <table class="centered highlight">
        <thead>
        <tr>
            <th>Date</th>
            <th>Resource</th>
            <th>Paid</th>
            <th>Method</th>
            <th>Purchased</th>
            <th>Remaining</th>
        </tr>
        </thead>
        <tbody>
        @forelse($customer->payments as $payment)
            <tr>
                <td>{{$payment->created_at}}</td>
                <td>{{$payment->resource}}</td>
                <td>{{$payment->paid}}</td>
                <td>{{$payment->method}}</td>
                <td>{{$payment->purchased}}</td>
                <td>{{$payment->remained}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <h5>No Payment found</h5>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@else
    <h5>No Payment found</h5>
@endif