const notyf = new Notyf({position:{x:'right',y:'top'}});

const myTable = new JSTable("#basic", 
{
    sortable: true,
    searchable :false,
    columns: [
        {   
            select: [0, 2],
            sortable: false,
            searchable: true
        },
        {   
            select: 1,
            sortable: false,
            searchable: true
        },
        {   
            select: 3,
            sortable: false,
            searchable: true,
            render: function (cell, idx) {
                let data = cell.innerHTML;
                return '<i  data-reportid="'+data+'" class="far fa-edit"></i>';
            }
        }
    ],
    layout: {
        top: "{select}{info}",
        bottom: "{pager}"
    },
    serverSide : true,
    ajax : "/visitreport/datatable",
    ajaxParams: {
        dateInPast: document.getElementById('past_dates').checked
    }
}
);

document.getElementById('past_dates').addEventListener('click',function(){
    myTable.config.ajaxParams.dateInPast = document.getElementById('past_dates').checked;
    myTable.paginate(1);
})

document.body.addEventListener( 'click', function ( event ) {
    if( event.target.className == 'far fa-edit' ) {
        getDataAndShowModal(event.target.getAttribute('data-reportid'));
    };
});

document.getElementById('update_report').addEventListener('click',function(e){
    e.preventDefault();
    
    let serverdata = { 
        appointment_date: document.getElementById('ad').value,            
        report_text: document.getElementById('report_text').value
    };

    if(document.getElementById('as_select'))
    {
        serverdata.user_id = document.getElementById('as_select').value;
    }

    const requestOptions = {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json','X-CSRF-TOKEN': document.getElementById('csrf-token').getAttribute('content') },
        body: JSON.stringify(serverdata)       
    };
    
    let updateId = document.getElementById('update_report').getAttribute('data-reportid');
    updateReport(updateId,requestOptions);
})

document.getElementById('cancel_report').addEventListener('click',function(e){
    e.preventDefault();
    closeEditModal();
})

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editModal_firstDiv').style.display = 'none';
    document.getElementById('editModal_secondDiv').style.display = 'none';
    if(document.querySelector('.active a'))
        myTable.paginate(parseInt(document.querySelector('.active a').innerHTML));
    else
        myTable.paginate(1);
}

function getDataAndShowModal(id)
{
    fetch('/visitreport/'+id)
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            document.getElementById('customer_h').innerHTML = data.data.customer.name;
            document.getElementById('ad').value = data.data.appointment_date;
            document.getElementById('report_text').value = data.data.report_text;
            if(document.getElementById('as_select'))
                document.getElementById('as_select').value = data.data.user_id;
        });

        document.getElementById('editModal').style.display = 'block';
        document.getElementById('editModal_firstDiv').style.display = 'block';
        document.getElementById('editModal_secondDiv').style.display = 'block';
        document.getElementById('update_report').setAttribute('data-reportid',id);
}

async function updateReport(id,requestOptions)
{
    let response = await fetch('/visitreport/'+id, requestOptions);
    if(response.status === 403)
    {
        let resJSON = await response.json();
        console.log(resJSON.data);
        Object.keys(resJSON.data).forEach(key => {
            Object.keys(resJSON.data[key]).forEach(errkey => {
                notyf.error(resJSON.data[key][errkey]);
            });
        });
    } else {
        notyf.success('Report has been updated successfully');
        closeEditModal()
    }
    console.log(response.status);
}