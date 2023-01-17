<table  style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:50%">
    <tbody>
        <tr>
            <td>
                       <h1>{{$visitReport->customer->name}}</h1>
                       <p>Appointment_date : {{$visitReport->appointment_date}}</p>
                       <p>Assigned for report : {{$visitReport->assignedEmployee->name}} </p>
                       <hr/>
                       <p>
                            {!! $visitReport->report_text !!}
                       </p>
            </td>
        </tr>
    </tbody>
</table>