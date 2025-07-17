@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}

    <style>
        #dropzoneWrapperAdd {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .image-preview {
            position: relative;
            width: 120px;
            height: 120px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .img-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-preview {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }

        .dropzone-hover {
            border-color: #4CAF50;
            background-color: #f8f9fa;
        }

        .ck.ck-content {
            height: 250px;
        }

        /*------------------------------------
        Tagsinput
        ------------------------------------*/
        .u-tagsinput .bootstrap-tagsinput {
            width: 100%;
            border-color: #e7eaf3;
            border-radius: 0.3125rem;
            box-shadow: none;
            padding: 0.25rem;
            padding-bottom: 0;
        }
        .u-tagsinput .bootstrap-tagsinput::before {
            content: "|";
            display: inline-block;
            width: 1px;
            line-height: 1;
            font-size: 0.625rem;
            opacity: 0;
            padding: 0.75rem 0;
        }
        .u-tagsinput .bootstrap-tagsinput .tag {
            position: relative;
            display: inline-block;
            font-size: 0.875rem;
            color: #ffffff;
            background-color: #4fc6c9;
            border-radius: 0.3125rem;
            padding: 0.25rem 1.875rem 0.25rem 0.75rem;
            margin-bottom: 0.25rem;
            margin-right: 0;
        }
        .u-tagsinput .bootstrap-tagsinput .tag [data-role="remove"] {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            color: #fff;
            font-size: 1.25rem;
            outline: none;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        .u-tagsinput .bootstrap-tagsinput .tag [data-role="remove"]::after {
            content: "\00d7";
        }
        .u-tagsinput .bootstrap-tagsinput .tag [data-role="remove"]:hover {
            color: #fff;
            box-shadow: none;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Wings</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                        <li class="breadcrumb-item active">Product!</li>
                    </ol>
                </div>
                <h4 class="page-title">Product!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Image</th>
                        <th>EAN</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Model No</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Available Stock</th>
                        <th>Stock Sell</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key=>$productData)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @php
                                    $images = json_decode($productData->image, true);
                                    $firstImage = $images ? $images[0] : 'default.png';
                                @endphp
                                <img src="{{ asset('images/product/' . $firstImage) }}" alt="Product Image" style="max-width: 50px;">
                            </td>
                            <td>{{$productData->ean_no}}</td>
                            <td>{{$productData->name}}</td>
                            <td>{{$productData->brand->name}}</td>
                            <td>{{$productData->model_no}}</td>
                            <td>{{$productData->price? $productData->price :'N/A'}}</td>
                            <td>{{$productData->sale_price? $productData->sale_price :'N/A'}}</td>

                            <td>{{$productData->stock}}</td>
                            <td>{{$productData->available_stock? $productData->available_stock :'N/A'}}</td>
                            <td>{{$productData->stock_sell? $productData->stock_sell :'N/A'}}</td>
                            <td>{{$productData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{route('admin.product.destroy',$productData->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$productData->id}}">Delete</a>
                                </div>
                            </td>
                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$productData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$productData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$productData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('admin.product.destroy',$productData->id)}}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin.product.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="category-select" class="form-label">Category</label>
                                    <select name="category_id" id="category-select" class="form-select" required>
                                        <option selected value="">Select Category</option>
                                        @foreach($categories as $categoryData)
                                            <option value="{{ $categoryData->id }}">{{ $categoryData->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="brand-select" class="form-label">Brand</label>
                                    <select name="brand_id" id="brand-select" class="form-select">
                                        <option selected value="">Select Brand</option>
                                        @foreach($brand as $brandData)
                                            <option value="{{ $brandData->id }}">{{ $brandData->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control" placeholder="Enter Name" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="model_no" class="form-label">Model No</label>
                                    <input type="text" id="model_no" name="model_no"
                                           class="form-control" placeholder="Enter Model No" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <input type="text" id="type" name="type"
                                           class="form-control" placeholder="Enter Type">
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="year" id="year" name="year"
                                           class="form-control" placeholder="Enter Year">
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="example-fileinput" class="form-label">Price</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           placeholder="Enter price" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="example-fileinput" class="form-label">Sale Price</label>
                                    <input type="text" id="sale_price" name="sale_price"
                                           class="form-control" placeholder="Enter Sale Price">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="example-fileinput" class="form-label">Stock</label>
                                    <input type="text" id="stock" name="stock"
                                           class="form-control" placeholder="Enter Stock" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label>Images</label>
                                    <div id="dropzoneWrapperAdd">
                                        <i class="h1 text-muted ri-upload-cloud-2-line"></i><br>
                                        <span>Drag and drop Product images</span>
                                        <input type="file" name="image[]" id="image-input-add" multiple accept="image/*" style="opacity: 0; position: absolute;" required>
                                    </div>
                                    <div id="image-preview-container-add" class="image-preview-container"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label> Details </label>
                                    <textarea class="form-control editor" name="details" style="height: 500px;" placeholder="Enter the Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <h4>Product Specification:</h4>
                        <div id="specification-fields">
                            <div class="row specification-field">
                                <div class="col-5 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="spec_title[]" class="form-control" placeholder="Enter Title" required>
                                </div>
                                <div class="col-5 mb-3">
                                    <label for="value" class="form-label">Value</label>
                                    <input type="text" name="spec_value[]" class="form-control" placeholder="Enter Value" required>
                                </div>
                                <div class="col-2 d-flex align-items-end mb-3">
                                    <button type="button" class="btn btn-danger remove-spec-field">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" id="add-spec-more">Add More Specification</button>

                        <h4>Product Cross Reference:</h4>
                        <div id="cross-reference-fields">
                            <div class="row cross-reference-field">
                                <div class="col-5 mb-3">
                                    <label for="part_number" class="form-label">Part Number</label>
                                    <input type="text" name="part_number[]" class="form-control" placeholder="Enter Part Number" required>
                                </div>
                                <div class="col-5 mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" name="company_name[]" class="form-control" placeholder="Enter Company Name" required>
                                </div>
                                <div class="col-2 d-flex align-items-end mb-3">
                                    <button type="button" class="btn btn-danger remove-cross-ref-field">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" id="add-cross-ref-more">Add More Cross Reference</button>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image upload for add form
            const dropzoneWrapper = document.getElementById('dropzoneWrapperAdd');
            const imageInput = document.getElementById('image-input-add');
            const previewContainer = document.getElementById('image-preview-container-add');

            // Click handler for dropzone
            dropzoneWrapper.addEventListener('click', () => imageInput.click());

            // Drag and drop handlers
            dropzoneWrapper.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzoneWrapper.classList.add('dropzone-hover');
            });

            dropzoneWrapper.addEventListener('dragleave', () => {
                dropzoneWrapper.classList.remove('dropzone-hover');
            });

            dropzoneWrapper.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzoneWrapper.classList.remove('dropzone-hover');
                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    handleImageUpload({ target: imageInput });
                }
            });

            // Image input change handler
            imageInput.addEventListener('change', handleImageUpload);

            // Handle image upload and preview
            function handleImageUpload(event) {
                const files = event.target.files;

                // Clear previous previews if not multiple selection
                if (!event.dataTransfer) {
                    previewContainer.innerHTML = '';
                }

                for (const file of files) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const imageUrl = e.target.result;
                            createImagePreview(imageUrl, file.name);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            }

            // Create image preview element
            function createImagePreview(imageUrl, filename) {
                const imagePreview = document.createElement('div');
                imagePreview.classList.add('image-preview');

                const imgElement = document.createElement('img');
                imgElement.src = imageUrl;
                imgElement.classList.add('img-preview');

                const removeButton = document.createElement('div');
                removeButton.classList.add('remove-preview');
                removeButton.innerHTML = '×';
                removeButton.addEventListener('click', function() {
                    imagePreview.remove();
                    // You might want to update the file input here if needed
                });

                imagePreview.appendChild(imgElement);
                imagePreview.appendChild(removeButton);
                previewContainer.appendChild(imagePreview);
            }

            // Add More Specification Fields
            document.getElementById('add-spec-more').addEventListener('click', function() {
                const container = document.getElementById('specification-fields');
                const newField = document.createElement('div');
                newField.classList.add('row', 'specification-field', 'mb-3');
                newField.innerHTML = `
                <div class="col-5">
                    <label class="form-label">Title</label>
                    <input type="text" name="spec_title[]" class="form-control" placeholder="Enter Title" required>
                </div>
                <div class="col-5">
                    <label class="form-label">Value</label>
                    <input type="text" name="spec_value[]" class="form-control" placeholder="Enter Value" required>
                </div>
                <div class="col-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-spec-field">Remove</button>
                </div>
            `;
                container.appendChild(newField);
            });

            // Remove Specification Fields
            document.getElementById('specification-fields').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-spec-field')) {
                    e.target.closest('.specification-field').remove();
                }
            });

            // Add More Cross Reference Fields
            document.getElementById('add-cross-ref-more').addEventListener('click', function() {
                const container = document.getElementById('cross-reference-fields');
                const newField = document.createElement('div');
                newField.classList.add('row', 'cross-reference-field', 'mb-3');
                newField.innerHTML = `
                <div class="col-5">
                    <label class="form-label">Part Number</label>
                    <input type="text" name="part_number[]" class="form-control" placeholder="Enter Part Number" required>
                </div>
                <div class="col-5">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Enter Company Name" required>
                </div>
                <div class="col-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-cross-ref-field">Remove</button>
                </div>
            `;
                container.appendChild(newField);
            });

            // Remove Cross Reference Fields
            document.getElementById('cross-reference-fields').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-cross-ref-field')) {
                    e.target.closest('.cross-reference-field').remove();
                }
            });
        });
    </script>
@endsection
