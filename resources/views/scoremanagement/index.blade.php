@extends('layout/header')

@section('content')

<style>
    .role-filter select.form-control,
    .status-filter select.form-control {
        -webkit-appearance: auto;
    }

    .status-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: green;
        /* Change to your desired color */
        color: white;
        font-size: 13px;
        font-weight: bold;
        line-height: 1;
    }

    .status-check::before {
        content: '\2714';
        /* Unicode character for checkmark */
    }



    .error-icon {
        display: inline-block;
        width: 25px;
        height: 25px;
        background-color: red;
        /* Red background */
        color: white;
        /* White icon color */
        text-align: center;
        line-height: 25px;
        border-radius: 50%;
        font-size: 15px;
        font-family: Arial, sans-serif;
        /* Ensure the icon displays correctly */
    }


    .disabled {

        cursor: not-allowed;
        pointer-events: none;
        opacity: 0.5;
    }
    .disabled-icon {
    opacity: 0.5;
    pointer-events: none; /* Prevents clicking */
}


    .feedback[data-status="inactive"] {
        pointer-events: none;
        /* Disable all mouse interactions */
        opacity: 0.5;
        /* Make the icon look disabled */
    }

    .feedback[data-status="inactive"] .fas {
        color: grey;
        /* Change color to indicate disabled state */
    }

    .Administration-filter {
        position: relative;
        display: inline-block;
        width: 150px;
    }

    /* Style for the button that acts as the dropdown trigger */
    .custom-select {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 10px;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-content {
    display: none;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    min-width: 150px;
    padding: 10px;
    z-index: 1;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}

.checkbox-content div {
    display: flex;
    justify-content: space-between; /* This aligns the label to the left and checkbox to the right */
    align-items: center;
    padding: 5px 0; /* Optional: Add some space between each checkbox */
}

.checkbox-content input {
    margin-left: auto; /* This pushes the checkbox to the right */
}

.checkbox-content.show {
    display: block;
}


    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }



    .pagination li a {
        text-decoration: none;
        display: block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #007bff;
    }

    .pagination li a:hover {
        background-color: #e9ecef;
    }

    .pagination li.active a {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination li.disabled a {
        color: #6c757d;
        cursor: not-allowed;
    }



    /* Optional: Adjust spacing and alignment within action icons */



    .action-icons {
        display: flex;
        /* Align items in a row */
        align-items: center;
        /* Center items vertically */
    }

    .action-icons a {
        display: flex;
        /* Align items inside the link in a row */
        align-items: center;
        /* Center items vertically */
        margin-right: 10px;
        /* Space between icons */
    }

    /* Optional: Remove margin from the last item */
    .action-icons a:last-child {
        margin-right: 0;
    }

    /* Increase icon size for specific icons */
    .feedback-icon {
        font-size: 1.2rem;
        /* Adjust size as needed */
    }

    .attempt-icon {
        font-size: 1rem;
        /* Adjust size as needed */
    }


    /* Center the modal in the window */
    /* Center the modal in the window */
    /* Center the modal in the window */
    .modal-dialog {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1.75rem);
    }

    .modal-content {
        padding: 20px;
        border-radius: 10px;
    }

    /* Icon Container */
    .icon-container {
        margin-bottom: 30px;
        text-align: center;
    }

    .icon-container i {
        font-size: 50px;
        margin-top: 20px;
        color: #f1b654;
    }

    /* Button Group */
    /* Button Group */
    .button-group {
        display: flex;
        justify-content: center;
        gap: 20px;
        /* Increased gap between buttons */
        margin-top: 10px;
    }

    /* Yes Button */
    /* Yes Button */
    .yes {
        background-color: #f1b654;
        /* Remove default border */
        border-color: #6c757d;
        color: white;
        padding: 12px 24px;
        /* Increased padding for larger button */
        font-weight: bold;
        border-radius: 8px;
        /* Rounded corners */
        width: 170px;
        /* Fixed width */
        text-align: center;
        font-size: 16px
    }

    /* Cancel Button */
    .cancel {
        background-color: grey;
        color: white;
        border: none;
        /* Remove default border */
        padding: 12px 24px;
        /* Increased padding for larger button */
        font-weight: bold;
        border-radius: 8px;
        /* Rounded corners */
        width: 170px;
        /* Fixed width */
        text-align: center;
        font-size: 16px
    }


    /* Hover Effects */
    .yes:hover {
        background-color: #d4a000;
        /* Darker shade on hover */
    }

    .cancel:hover {
        background-color: #4d4d4d;
        /* Darker grey on hover */
    }
</style>

<div class="d-flex justify-content-between pt-3">
    <div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <b>Scrore Management</b>
        </h3>
    </div>


</div>

<div class="d-flex justify-content-between pt-3">
    <div class="bd-text">
        <div class="accordion" id="accordionRightIcon">
            <div class="card ul-card__v-space m-0" style="border-radius: 10px;">
                <div class="card-header header-elements-inline" data-toggle="collapse" href="#filters"
                    style="cursor: pointer;" aria-expanded="true">
                    <img src="{{url('assets/images/filter.png')}}" alt="filter">
                </div>
                <div class="collapse p-2) {
    echo 'show';
} ?>" id="filters" style="min-width:600px;">
                    <div class="d-flex justify-content-between">


                        <div class="Assessment-filter">
                            <select id="AssementFilter" class="form-control" style="min-width:150px;">
                                <option value="" disabled selected hidden><b>Assessment</b></option>
                                <option value="1"> assessment1</option>
                                <option value="2">assessment2</option>
                                <option value="3">assessment3</option>
                            </select>
                        </div>



                        <div class="Administration-filter">
                            <div class="custom-select" onclick="toggleCheckboxMenu()">
                                <b>Administration</b>
                            </div>
                            <div class="checkbox-content" id="checkboxMenu">
                                <div>
                                  
                                    <label for="assessment1">BaseLine</label>
                                    <input type="checkbox" id="assessment1" value="1">
                                </div>
                                <div>
                                  
                                    <label for="assessment2">Post Workshop</label>
                                    <input type="checkbox" id="assessment2" value="2">
                                </div>
                                <div>
                                   
                                    <label for="assessment3">Post Practice</label>
                                    <input type="checkbox" id="assessment3" value="3">
                                </div>
                            </div>
                        </div>
                        <div class="invite-filter">
                            <select id="inviteFilter" class="form-control" style="min-width:150px;">
                                <option value="" disabled selected hidden><b>Invited</b></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>

                            </select>
                        </div>



                        <div class="status-filter">
                            <select id="statusFilter" class="form-control" style="min-width:150px;">
                                <option value="" disabled selected hidden><b>Status</b></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>

                            </select>
                        </div>


                        <div class="score-filter">
                            <select id="scoreFilter" class="form-control" style="min-width:150px;">
                                <option value="" disabled selected hidden><b>Score</b></option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>

                            </select>
                        </div>







                        <div class="reset">
                            <a class="btn btn-raised btn-raised-secondary"
                                style="color: #ef4166 !important;font-weight: 800;"
                                href="{{ route('scoremanagement.list') }}">
                                <img src="{{url('assets/images/ic-replay.png')}}" alt="filter">
                                Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custome-btn d-flex justify-content-between">
        <form method="GET" action="">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search......"
                    name="search" value="{{ request()->search }}">
                <button type="button" id="search_project" style="border:none;"
                    class="ul-widget-app__find-font btn-warning">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <table class="table" id="data-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PROJECT TITLE</th>
                            <th>ASSESSMENT TITLE</th>
                            <th>STATUS</th>
                            <th>SCRORE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>01</td>
                            <td>Sandeep</td>
                            <td>sandeep@vtech.com</td>
                            <td>AI Research Project & Case Study</td>
                            <td>Personal and Professional Characteristics</td>
                            <td><span class="status-check" data-status="inactive"></span></td>
                            <td> N/A </td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{route('scoremanagement.view_feedback')}}" id="view_feedback"
                                        title="view"> <img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>

                                    <a href="{{ route('scoremanagement.feedback') }}" id="feedback" title="Feedback"
                                        class="disabled" aria-disabled="true">
                                        <i class="fas fa-tasks" style="color: #f0a000;"></i>
                                    </a>

                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>Alex</td>
                            <td>alex@example.com</td>
                            <td>AI Development</td>
                            <td>Project Overview</td>
                            <td><span class="status-check" data-status="inactive"></span></td>
                            <td>Yes</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('scoremanagement.view_feedback') }}" id="view_feedback"
                                        title="view">
                                        <img src="{{ url('dist-assets/images/eye.png') }}" alt="filter">
                                    </a>

                                    <a href="{{ route('scoremanagement.feedback') }}" id="feedback" title="Feedback"
                                        aria-disabled="false">
                                        <i class="fas fa-tasks" style="color: orange;"></i>
                                    </a>

                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>09</td>
                            <td>Sandeep</td>
                            <td>sandeep@vtech.com</td>
                            <td>AI Research Project & Case Study</td>
                            <td>Personal and Professional Characteristics</td>
                            <td><span class="status-check" data-status="inactive"></span></td>
                            <td>N/A</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('scoremanagement.view_feedback') }}" id="view_feedback"
                                        title="view">
                                        <img src="{{ url('dist-assets/images/eye.png') }}" alt="filter">
                                    </a>

                                    <a href="{{ route('scoremanagement.feedback') }}" id="feedback" title="Feedback"
                                        class="disabled" aria-disabled="true">
                                        <i class="fas fa-tasks" style="color: #f0a000;"></i>
                                    </a>

                                    
                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                           
                                </div>

                                
                            </td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>Maria</td>
                            <td>maria@example.com</td>
                            <td>Machine Learning</td>
                            <td>Model Evaluation</td>
                            <td><span class="status-check" data-status="inactive"></span></td>
                            <td>No</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('scoremanagement.view_feedback') }}" id="view_feedback"
                                        title="view">
                                        <img src="{{ url('dist-assets/images/eye.png') }}" alt="filter">
                                    </a>

                                    <a href="{{ route('scoremanagement.feedback') }}" id="feedback" title="Feedback"
                                        aria-disabled="false">
                                        <i class="fas fa-tasks" style="color: orange;"></i>
                                    </a>

                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                </div>


                            </td>
                        </tr>


                        <tr>
                            <td>4</td>
                            <td>Sandeep</td>
                            <td>sandeep@vtech.com</td>
                            <td>AI Research Project & Case Study</td>
                            <td>Personal and Professional Characteristics</td>
                            <td>
                                <div class="error-icon">✖</div>
                            </td>
                            <td>No</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{route('scoremanagement.view_feedback')}}" id="view_feedback"
                                        title="view"> <img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>


                                    <a href="{{route('scoremanagement.feedback')}}" id="feedback" title="Feedback">
                                        <i class="fas fa-tasks" style="color: orange;"></i>
                                    </a>


                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                </div>
                            </td>
                        </tr>

                        <tr>
    <td>5</td>
    <td>Sandeep</td>
    <td>sandeep@vtech.com</td>
    <td>AI Research Project & Case Study</td>
    <td>Personal and Professional Characteristics</td>
    <td>
        <div class="error-icon">✖</div>
    </td>
    <td>No</td>
    <td>
        <div class="action-icons">
            <a href="{{route('scoremanagement.view_feedback')}}" id="view_feedback" title="view">
                <img src="{{url('dist-assets/images/eye.png')}}" alt="filter">
            </a>

            <a href="{{route('scoremanagement.feedback')}}" id="feedback" title="Feedback">
                <i class="fas fa-tasks" style="color: orange;"></i>
            </a>

            <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
        </div>
    </td>
</tr>

<tr>
    <td>6</td>
    <td>Sandeep</td>
    <td>sandeep@vtech.com</td>
    <td>AI Research Project & Case Study</td>
    <td>Personal and Professional Characteristics</td>
    <td>
        <div class="error-icon">✖</div>
    </td>
    <td>No</td>
    <td>
        <div class="action-icons">
            <a href="{{route('scoremanagement.view_feedback')}}" id="view_feedback" title="view">
                <img src="{{url('dist-assets/images/eye.png')}}" alt="filter">
            </a>

            <a href="{{route('scoremanagement.feedback')}}" id="feedback" title="Feedback">
                <i class="fas fa-tasks" style="color: orange;"></i>
            </a>

           <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
        </div>
    </td>
</tr>

                        <tr>
                            <td>7</td>
                            <td>Sandeep</td>
                            <td>sandeep@vtech.com</td>
                            <td>AI Research Project & Case Study</td>
                            <td>Personal and Professional Characteristics</td>
                            <td>
                                <div class="error-icon">✖</div>
                            </td>
                            <td>No</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{route('scoremanagement.view_feedback')}}" id="view_feedback"
                                        title="view"> <img src="{{url('dist-assets/images/eye.png')}}" alt="filter"></a>


                                    <a href="{{route('scoremanagement.feedback')}}" id="feedback" title="Feedback">
                                        <i class="fas fa-tasks" style="color: orange;"></i>
                                    </a>

                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>09</td>
                            <td>Sandeep</td>
                            <td>sandeep@vtech.com</td>
                            <td>AI Research Project & Case Study</td>
                            <td>Personal and Professional Characteristics</td>
                            <td><span class="status-check" data-status="inactive"></span></td>
                            <td>N/A</td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('scoremanagement.view_feedback') }}" id="view_feedback"
                                        title="view">
                                        <img src="{{ url('dist-assets/images/eye.png') }}" alt="filter">
                                    </a>

                                    <a href="{{ route('scoremanagement.feedback') }}" id="feedback" title="Feedback"
                                        class="disabled" aria-disabled="true">
                                        <i class="fas fa-tasks" style="color: #f0a000;"></i>
                                    </a>

                                    
                                    <a class="text-danger invite-assessment"  data-id="" style="cursor: pointer !important;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Invite">   <i class="fas fa-play" style="color: #f0a000;"></i></a>
                                           
                                </div>

                                
                            </td>
                        </tr>


                    </tbody>
                </table>





                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div id="showing-info">Showing 1 to 5 of 20</div>
                    <div id="pagination-controls">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0" id="pagination">
                                <!-- Pagination buttons will be inserted here by JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>




            </div>

        </div>


    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

 <script type="text/javascript">
           

           function toggleCheckboxMenu() {
    const menu = document.getElementById('checkboxMenu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
}







$(document).ready(function() {
    $('tr').each(function() {
        var status = $(this).find('.status-check').data('status');
        var inviteAssessmentIcon = $(this).find('.invite-assessment');

        if (status === 'inactive') {
            inviteAssessmentIcon.addClass('disabled-icon');
            inviteAssessmentIcon.attr('aria-disabled', 'true');
            inviteAssessmentIcon.css('cursor', 'not-allowed'); // Optional: Change cursor to indicate disabled state
        } else {
            inviteAssessmentIcon.removeClass('disabled-icon');
            inviteAssessmentIcon.removeAttr('aria-disabled');
            inviteAssessmentIcon.css('cursor', 'pointer'); // Optional: Reset cursor
        }
    });
});


   




    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 5;
        const rows = document.querySelectorAll('#data-table tbody tr');
        const rowsCount = rows.length;
        const pageCount = Math.ceil(rowsCount / rowsPerPage);
        const paginationElement = document.getElementById('pagination');
        const showingInfo = document.getElementById('showing-info');
        let currentPage = 1;

        function displayPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            showingInfo.textContent = `Showing ${start + 1} to ${end > rowsCount ? rowsCount : end} of ${rowsCount}`;
        }

        function setupPagination() {
            paginationElement.innerHTML = '';

            // Previous button
            const prevButton = document.createElement('li');
            prevButton.className = 'page-item';
            prevButton.innerHTML = `<a href="#" class="page-link">&lt;</a>`;
            prevButton.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });
            paginationElement.appendChild(prevButton);

            // Page number buttons
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.className = 'page-item';
                li.innerHTML = `<a href="#" class="page-link">${i}</a>`;
                li.addEventListener('click', (e) => {
                    e.preventDefault();
                    goToPage(i);
                });
                paginationElement.appendChild(li);
            }

            // Next button
            const nextButton = document.createElement('li');
            nextButton.className = 'page-item';
            nextButton.innerHTML = `<a href="#" class="page-link">&gt;</a>`;
            nextButton.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage < pageCount) {
                    goToPage(currentPage + 1);
                }
            });
            paginationElement.appendChild(nextButton);

            // Initialize button states
            updatePaginationButtons();
        }

        function goToPage(page) {
            if (page < 1 || page > pageCount) return;
            currentPage = page;
            displayPage(page);
            updatePaginationButtons();
        }

        function updatePaginationButtons() {
            const buttons = paginationElement.querySelectorAll('.page-item');
            buttons.forEach((button, index) => {
                if (index === 0) { // Previous button
                    button.classList.toggle('disabled', currentPage === 1);
                } else if (index === buttons.length - 1) { // Next button
                    button.classList.toggle('disabled', currentPage === pageCount);
                } else { // Page number buttons
                    button.classList.remove('active');
                    if (index === currentPage) {
                        button.classList.add('active');
                    }
                }
            });
        }

        setupPagination();
        displayPage(currentPage);
    });

    

    $(document).on('click', '.invite-assessment', function(e) {
    let thisRef = $(this);
    e.preventDefault();
    var scoremanagementId = $(this).data('id');
    
    swal({
        title: "<h3>Would you like to send an invitation reminder?</h3>",
        text: "",
        icon: "warning",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#f1b82d',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
    }).then(function(isConfirm) {
        if (isConfirm.value) {
            $.ajax({
                url: '{{url('scoremanagement/delete')}}',
                type: 'POST',
                data: {'id': scoremanagementId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    thisRef.closest('tr').remove();
                    swal({
                        text: response.message,
                        timer: 2000,
                        type: "success",
                        confirmButtonColor: "#f1b82d",
                    });
                    window.location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});









</script>



@endsection