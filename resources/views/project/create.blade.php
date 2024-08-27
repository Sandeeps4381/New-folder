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
</style>
    <div class="d-flex justify-content-between pt-3">
        <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a> <b>Create Project</b></h3>
        </div>
        <div class="custome-btn d-flex justify-content-between">
            <a class="btn btn-warning" href="javascript:void(0)" onClick = "saveAsDraft()">Save as Draft</a>
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
            @if (session("projectid"))

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="display:block;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                 <h2 class="text-center mb-3" style="font-weight: 700; color:#000;">New Assessment</h2>
                     <div class="assessment_create_box d-flex justify-content-between align-items-center">
                        <a href="{{ route('assessment.create', ['preproductid' => session('projectid') ]) }}" class="assessment_b">
                            <div >
                                <img src="{{url('dist-assets/images/assessment_c1.svg')}}" alt="" class="mb-3">
                                <div class="assessment_title"><h3>Start From Scratch</h3></div>
                                <div class="assessment_content">
                                    <p>Create a new template and provide the required inputs to be reflected in the newly created project.</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('assessmentclonelist' , ['preproductid' => session('projectid') ]) }}" class="assessment_b">
                            <div >
                            <img src="{{url('dist-assets/images/assessment_c.svg')}}" alt="" class="mb-3">
                            <div class="assessment_title"><h3>Clone Assessment</h3></div>
                                <div class="assessment_content">
                                    <p>Copy any preexisting assessments and edit/modify the copied assessment file for creating the new assessment by cloning method.</p>
                                </div>
                            </div>
                        </a>
                     </div>
                </div>
            </div>
        </div>
    </div>

            <script>
                    $(document).ready(function(){
                        $('#exampleModal').modal('show');
                    });
            </script>

            @endif

    <div class="mt-3">
    <form action="{{ route('project.save')}}" name="frm_create_project" id="frm_create_project" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="card-title mb-3">Project Details</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label >Title</label> <span class="text-danger"> *</span></label>
                            <input class="form-control"  type="text" name="project_title" id="project_title" value="{{ old('project_title') }}"/>
                            <input class="form-control"  type="hidden" name="project_create_type" id="project_create_type" value ="1" />
                            <span class="text-danger">
                                    @error('project_title')
                                        {{$message}}
                                    @enderror
                                </span>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label>Project Type</label> <span class="text-danger"> *</span></label>
                            <select class="select2 form-control w-100" name="project_type" id="project_type" data-placeholder="Select Project Type">
                                <option></option>
                                <option>Project Type</option>
                                <option value="Research">Research</option>
                                <option value="Non-Research">Non-Research</option>
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
                                <option value="1">Draft</option>
                                <option value="2">Active</option>
                                <option value="3">Completed</option>
                            </select>
                            <span class="text-danger">
                                    @error('status')
                                        {{$message}}
                                    @enderror
                                </span>
                        </div>


                        <div class="col-md-3 form-group mb-3">
                            <label>Upload Image</label></label>
                            <div class="custom-file">
                            <input type="file" id="project_image" name="project_image" class="form-control custom-file-input" accept="image/jpg, image/jpeg, image/png"  value="">

                            <span class="text-danger">
                                    @error('project_image')
                                        {{$message}}
                                    @enderror
                                </span>
                            <label class="custom-file-label" for="project_image">Select Upto 1 Image</label>
                            <div class="invalid-feedback">Please Upload Master Image!</div>
                        </div>
                        </div>

                        <div class="col-md-12">
                            <div id="preview-container"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description</label> <span class="text-danger"> *</span></label>
                            <div>
                            <textarea name="project_description"  id="project_description"  style="width:100%; height:200px;" >{{ old('project_description') }}</textarea>
                            </div>
                            <span class="text-danger">
                                @error('project_description')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="row">
                            <div class="col-md-2">
                                <h4 class="card-title mb-3">Add Guidelines</h4>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto col-md-12 mb-3" style="height: 100%; width:100%">
                            <label>Description: </label> <span class="text-danger"> *</span></label>
                            <div>
                                <textarea name = "project_guideline" id="project_guideline"  style="width:100%; height:200px;" >{{ old('project_guideline') }}</textarea>
                            </div>
                            <span class="text-danger">
                                    @error('project_guidelines')
                                        {{$message}}
                                    @enderror
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-light backlink" style="width: 100%;">Back</a>
                        </div>
                        <div class="col-md-3 form-group">
                            <button class="btn btn-warning w-100" type="submit">Save & Create Assessments</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
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

    function saveAsDraft(){
        $("#project_create_type").val(1);
        $("#frm_create_project").submit();
    }


    $('#status').on('change', function() {
        let selectedVal = $(this).find('option:selected').val();
        $("#project_create_type").val(selectedVal);
    });


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
$("#preview-container").on("click", ".delete", function(){
        $(this).parent(".preview").remove();
        $("#project_image").val(""); // Clear input value if needed
    });
});
    </script>
    @endsection
