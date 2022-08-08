<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    {{-- <script src="{{ public_path('ajax.js') }}"></script> --}}
    <script src="{{ ('ajax.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div>

        <h1>Indian Pincode Search</h1>
        <form action="{{ route('search.pincode') }}" method="POST" id="PincodeForm">
            @csrf
            <div class="input-group">
                <div class="form-outline">
                <input type="search" id="form1" class="form-control" name="search"  placeholder="search"/>
                </div>
                <button type="submit" class="btn btn-primary" id="submitPin">
                    Search
                </button>
            </div>
        </form>
    </div>

    <div>
        <table class="table" id="pincode-result">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>BranchType</th>
                    <th>DeliveryStatus</th>
                    <th>Circle</th>
                    <th>District</th>
                    <th>Division</th>
                    <th>Region</th>
                    <th>Block</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pin Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                </tr>
            </tbody>
        </table>
    </div>

    <table>
        
    </table>

    <script>

        $(document).ready(function(){
            $('#PincodeForm').on('submit', function (event) {
                event.preventDefault();
                submitForm = $(this);
                submitBtn = $(this).find('#submitPin');
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: 'json',
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        submitBtn.attr("disabled", "disabled").text('Please wait..')
                        $(document).find('span.error-text').text('');
                    },
                    success: function (data) {
                        submitBtn.attr("disabled", false).text('Submit');
                        console.log(data[0].PostOffice)
                        
                        if (data[0].Status == 'Error') {
                            $('#pincode-result tbody').html('No data found');
                            
                        } else {
                            var rows = '';
                            $.each(data[0].PostOffice, function (index, value) {

                                    rows += "<tr>"
                                            + "<td>" + value.Name + "</td>"
                                            + "<td>" + value.BranchType + "</td>"
                                            + "<td>" + value.DeliveryStatus + "</td>"
                                            + "<td>" + value.Circle + "</td>"
                                            + "<td>" + value.District + "</td>"
                                            + "<td>" + value.Division + "</td>"
                                            + "<td>" + value.Region + "</td>"
                                            + "<td>" + value.Block + "</td>"
                                            + "<td>" + value.State + "</td>"
                                            + "<td>" + value.Country + "</td>"
                                            + "<td>" + value.Pincode + "</td>"
                                            + "</tr>";
                            })
                            $('#pincode-result tbody').html(rows);
                            
                        }
                    }

                })


            })
        })
    </script>
</body>

</html>