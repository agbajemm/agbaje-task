@extends('layout.app')

@section('content')
    <h1 class="page-header text-center">Products Web Page.</h1>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2>Products Table
                <button type="button" id="add" data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-primary pull-right"> Add Product</button>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-bordered table-responsive table-striped">
                <thead>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Valur Number</th>
                </thead>
                <tbody id="memberBody">
                </tbody>

            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            // Instantiates the header csrf token for laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Populates products to the table
            showProduct();

            // For creating new product
            $('#addForm').on('submit', function(e){
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form,
                    dataType: 'json',
                    success: function(){
                        $('#addnew').modal('hide');
                        $('#addForm')[0].reset();
                        showProduct();
                    }
                });
            });

            // Opens the edit form and populates the product data into the form
            $(document).on('click', '.edit', function(event){
                event.preventDefault();
                console.log('got here');
                var id = $(this).data('id');
                var name = $(this).data('name');
                var quantity = $(this).data('quantity');
                var price = $(this).data('price');
                $('#editmodal').modal('show');
                $('#name').val(name);
                $('#price').val(price);
                $('#quantity').val(quantity);
                $('#memid').val(id);
            });

            // Deletes the product record
            $(document).on('click', '.delete', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                $('#deletemodal').modal('show');
                $('#deletemember').val(id);
            });

            // Submit the edited data on the edit form
            $('#editForm').on('submit', function(e){
                e.preventDefault();
                var form = $(this).serialize();
                var url = $(this).attr('action');
                $.post(url,form,function(data){
                    $('#editmodal').modal('hide');
                    showProduct();
                })
            });

            //Deletes a product
            $('#deletemember').click(function(){
                var id = $(this).val();
                $.post("{{ URL::to('delete') }}",{id:id}, function(){
                    $('#deletemodal').modal('hide');
                    showProduct();
                })
            });

        });

        // Shows all products
        function showProduct(){
            $.get("{{ URL::to('show') }}", function(data){
                console.log(data);
                $('#memberBody').empty().html(data);
            })
        }

    </script>
@endsection
