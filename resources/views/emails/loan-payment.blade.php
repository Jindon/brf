<!doctype html>
<html>

<body
    style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
<table
    style="max-width:640px;min-width:720px;margin:50px auto 10px;background-color:#fff;padding:50px 20px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
    <tbody>

    <tr>
        <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
            <strong style="display:block;margin:0 0 10px 0;">Dear</strong> {{ $patronName }}<br> You have the following pending loan payments.<br><br>
            <span style="font-style:italic">Please pay on time to avoid fines!</span><br>
        </td>
    </tr>
    <tr>
        <td style="height:35px;"></td>
    </tr>

    <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Pending Loan Payments</td>
    </tr>
    <tr>
        <td colspan="2" style="padding:15px;">
            @foreach($duePayments as $index=>$duePayment)
                <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                    <span style="display:block;font-size:13px;font-weight:normal;">Due date: {{ $duePayment->due_date->format('d-m-Y') }}</span>
                    <b style="font-size:12px;font-weight:300;"> Due amount:</b> ₹{{ $duePayment->due }}<b style="font-size:12px;font-weight:300;"> | Interest:</b> ₹{{ $duePayment->interest }} <b style="font-size:12px;font-weight:300;"> | Fine:</b> ₹{{ $duePayment->fine }}
                </p>
            @endforeach
            <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span
                    style="display:block;font-size:13px;font-weight:normal;">Total due to be paid</span>
                ₹{{ $dueTotal }}</p>
        </td>
    </tr>
    </tbody>
    <tfooter>
        <tr>
            <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                <strong style="display:block;margin:0 0 10px 0;">Regards</strong> Bright Future Admin<br><br>
            </td>
        </tr>
    </tfooter>
</table>
</body>

</html>
