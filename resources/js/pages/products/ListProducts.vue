<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Product</h3>
                    <button type="button" class="btn btn-primary btn-sm float-right">
                        <ion-icon name="add-circle-outline"></ion-icon> New Product
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="product_name">Product Title</label>
                                <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Title">
                            </div>
                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Product Price">
                            </div>  
                        </div>
                        <div class="col-md-7">
                            <textarea id="summernote" name="product_details">
                                
                            </textarea>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputFile">Fiture Photo</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>