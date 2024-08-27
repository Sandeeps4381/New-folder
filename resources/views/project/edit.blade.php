@extends('layout/header')

    @section('content')
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<style>

.role-filter select.form-control , .status-filter select.form-control {
    -webkit-appearance: auto;
}
.ck-editor__editable_inline {
    min-height: 200px;
}
.preview button {
    position: absolute;
    bottom: 10px;
    right: 17px;
}
</style>
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Edit Project</b></h3>
        </div>

    </div>
    <div class="col-md-12">
            @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{session('error')}}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success mt-2">
                {{session('success')}}
            </div>
            @endif
            <div id="pagination_links">

            </div>

    <div class="mt-3">
        <form method="post" action="{{ route('project.editsave')}}" name="frm_create_project" id="frm_create_project" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="0" name="imageremove" id="imageremove">
        <input class="form-control"  type="hidden" name="project_create_type" id="project_create_type" value ="{{$projDetails[0]->status}}" />
        <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Project Details</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label >Title <span class="text-danger"> *</span></label>
                            <input class="form-control"  type="text" name="project_title" id="project_title" value='{{$projDetails[0]->project_title}}'>
                            <input type = "hidden" name="project_id" id="project_id" value="{{$projDetails[0]->id}}" />
                            <span class="text-danger">
                                    @error('project_title')
                                        {{$message}}
                                    @enderror
                                </span>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label>Project Type <span class="text-danger"> *</span></label>
                            <select class="select2 form-control w-100" name="project_type" id="project_type" >
                            <option>Project Type</option>
                                <option value="Research" <?php if($projDetails[0]->project_type == 'Research'){ echo "selected";}?>>Research</option>
                                <option value="Non-Research" <?php if($projDetails[0]->project_type == 'Non-Research'){ echo "selected";}?>>Non-Research</option>
                            </select>
                            <span class="text-danger">
                                    @error('project_type')
                                        {{$message}}
                                    @enderror
                                </span>
                        </div>


                        <div class="col-md-3 form-group mb-3">
                            <label>Status</label> <span class="text-danger"> *</span></label>
                            <select class="select2 form-control w-100" name="status" id="status" data-placeholder="Select Status">
                                <option></option>
                                <option value="1" <?php if($projDetails[0]->status == '1'){ echo "selected";}?>>Draft</option>
                                <option value="2" <?php if($projDetails[0]->status == '2'){ echo "selected";}?>>Active</option>
                                <option value="3" <?php if($projDetails[0]->status == '3'){ echo "selected";}?>>Completed</option>
                            </select>
                            <span class="text-danger">
                                    @error('status')
                                        {{$message}}
                                    @enderror
                                </span>
                        </div>


                        <div class="col-md-3 form-group mb-3">
                            <label>Upload Image</label> </label>
                            <div class="custom-file">
                            <input type="file" id="project_image" name="project_image" value="" class="form-control custom-file-input" accept="image/jpg, image/jpeg, image/png" >
                            <span class="text-danger">
                                    @error('project_image')
                                        {{$message}}
                                    @enderror
                                </span>
                            <label class="custom-file-label" for="project_image">Select Upto 1 Image</label>
                            <div class="invalid-feedback">Please Upload Master Image!</div>
                        </div>

                       </div>

                       @if ($projDetails[0]->project_image)
                       <div class="col-md-12">
                            <div id="preview-container">
                                <div class="preview">
                                  <img src="{{url(IMG_UPLOAD_PATH.'/'.$projDetails[0]->project_image)}}" class="img-fluid rounded w-100">
                                  <button class="delete btn btn-warning">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description <span class="text-danger"> *</span></label>
                            <div>
                            <textarea name="project_description"  id="project_description"  style="width:100%; height:200px;" > {{$projDetails[0]->project_description}}</textarea>
                            <span class="text-danger">
                                @error('project_description')
                                    {{$message}}
                                @enderror
                            </span>

                        </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Add Guidelines</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description: <span class="text-danger"> *</span></label>
                            <div>
                                <textarea name="project_guideline" id="project_guideline"  style="width:100%; height:200px;" >{{$projDetails[0]->project_guideline}}</textarea>
                            </div>
                            <span class="text-danger">
                                    @error('project_guideline')
                                        {{$message}}
                                    @enderror
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 form-group">
                            <button class="btn btn-warning w-100" type="submit">Update Project</button>
                        </div>
                        <div class="col-md-2">
                            <a href="#" class="btn btn-light backlink" style="width: 100%;">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
            ClassicEditor.create( document.querySelector( '#project_description' ),{
                toolbar: {
                    items: [
                        'heading' ,'bold', 'italic', 'link', 'undo', 'redo' // Custom toolbar configuration
                   ]

                },
            } )
                .catch( error => {
                    console.error( error );
                } );
                ClassicEditor.create( document.querySelector( '#project_guideline' ),{
                    toolbar: {
                    items: [
                        'heading' ,'bold', 'italic', 'link', 'undo', 'redo' // Custom toolbar configuration
                   ]

                },
                } )
                .catch( error => {
                    console.error( error );
                } );


                $(document).ready(function(){
    $(".custom-file-input").on("change", function(){
        var files = $(this)[0].files;
        $("#preview-container").empty();
        if(files.length > 0){
            for(var i = 0; i < files.length; i++){
                var reader = new FileReader();
                reader.onload = function(e){
                    $("<div class='preview'><img src='" + e.target.result + "'><button class='delete btn btn-warning'>Remove</button></div>").appendTo("#preview-container");
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });
$(document).on("click", ".delete", function(e){
      e.preventDefault();
        $(this).parent(".preview").remove();
        $("#project_image").val(""); // Clear input value if needed
        $('#imageremove').val(1);
    });
});

$('#status').on('change', function() {
        let selectedVal = $(this).find('option:selected').val();
        $("#project_create_type").val(selectedVal);
    });

        </script>
    @endsection
