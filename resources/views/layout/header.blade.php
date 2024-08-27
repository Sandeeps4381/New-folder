<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MIAS || UOM</title>
    <link href="{{asset('dist-assets/images/logo-2.png')}}" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

    <link href="{{asset('dist-assets/css/themes/lite-purple.css')}}" rel="stylesheet" />
    <link href="{{asset('dist-assets/css/plugins/perfect-scrollbar.css')}}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include DatePicker CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/quill.bubble.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/quill.snow.min.css')}}" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/custom.css')}}" />

    <link href="{{asset('dist-assets/css/plugins/metisMenu.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/script.js') }}"></script> -->

    <style>



input[type="checkbox"] {
  cursor: pointer;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: 0;
  background: lightgray;
  height: 16px;
  width: 16px;
  border: 1px solid white;
}

input[type="checkbox"]:checked {
  background: #f1b82d;
}

input[type="checkbox"]:hover {
  filter: brightness(90%);
}

input[type="checkbox"]:disabled {
  background: #e6e6e6;
  opacity: 0.6;
  pointer-events: none;
}

input[type="checkbox"]:after {
  content: '';
  position: relative;
  left: 40%;
  top: 16%;
    width: 25%;
    height: 54%;
  border: solid #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  display: none;
}

input[type="checkbox"]:checked:after {
  display: block;
}

input[type="checkbox"]:disabled:after {
  border-color: #f1b82d;
}
        img#site-logo {
            min-height: 120px;
            min-width: 190px;
            max-height: 40px;
            max-width: 190px;
            cursor: pointer;
        }
        .page-item.active .page-link {
            font-weight: 700;
            z-index: 1;
            color: #fff;
            background-color: #f1b82d;
            border-color: #f1b82d;
        }

        .page-item .page-link {
            font-weight: 700;
            z-index: 1;
            color: #000;

        }

        img#small-site-logo {
            min-height: 35px;
            min-width: 50px;
            max-height: 35px;
            max-width: 50px;
            cursor: pointer;
        }

        img.user-store-image {
            min-height: 18px;
            min-width: 18px;
            max-height: 18px;
            max-width: 18px;
            border-radius: 100%;
        }

        div#loading-image {
            display: none;
        }

        div#loading-image.show {
            display: block;
            position: fixed;
            z-index: 100;
            background-image: url('{{ asset('dist-assets/images/loadingLogo.gif') }}');
            background-color: #00000087;
            opacity: 0.7;
            background-repeat: no-repeat;
            left: 0;
            bottom: 0;
            right: 0;
            top: 0;
            background-position: 60% 50%;
        }

        ul.mm-collapse li a span.item-name {
            font-size: 14px !important;
        }

        .mobile-invalid,
        .email-invalid,
        #mobile-invalid,
        #email-invalid {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }

        a.menu-active {
            background-color: #f1b82d !important;

            transition: all 400ms ease;
            opacity: 9;
            color: #000000 !important;
            font-weight: 600;
        }

        a.menu-active>span {
            color: #000000 !important;
            opacity: 0.9 !important;
        }

        .currentDate {
            font-size: 11px;
            font-weight: 700;
            margin-top: -15px;
            text-align: right;
        }

        .mobileMenu {
            background: rebeccapurple;
            width: 30px;
            height: 30px;
            color: #fff;
            text-align: center;
            line-height: 30px;
            border-radius: 6px;
            font-size: 16px;
            margin-top: -10px;
            display: none;
        }

        .closeMobileManu {
            position: absolute;
            right: -34px;
            top: 15px;
            background: #fff;
            width: 40px;
            text-align: center;
            height: 30px;
            line-height: 30px;
            border-bottom-right-radius: 20px;
            border-top-right-radius: 20px;
            color: #663399;
            font-size: 16px;
            display: none;
        }

        .mobileMenu i:hover,
        .closeMobileManu i:hover {
            background: #000;
        }


        .switch {
    position: relative;
    display: inline-block;
    margin: 0px;
    padding-left: 0px;
}

.switch .slider {
    position: absolute;
    cursor: pointer;
    height: 15px;
    width: 34px;
    top: 24%;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 34px;
    background-color: #dbdbdb;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}
.switch-danger input:checked + .slider {
    background-color: #c6f9e0;
}

.switch .slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: -1px;
    top: 0px;
    bottom: -4px;
    background-color: #14ba6d;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 50%;
    box-shadow:
}
        @media only screen and (max-width: 1150px) {
            .app-admin-wrap.sidebar-full .sidebar-panel.mbOpen {
                left: 0px;
            }

            .app-admin-wrap.sidebar-full .sidebar-panel.mbOpen .closeMobileManu {
                display: block;
            }

            .mobileMenu {
                display: block;
            }
        }


        .cloase-l1{
            width: 30px;
    height: 30px;
    background-color: transparent;
    display: block;
    float: right;
    /* padding: 12px; */
    border-radius: 114px;
    text-align: center;
    line-height: 26px;
    border: 2px solid #000;
    opacity: 9;
    margin: 5px 10px 0px 0px;
        }

   .table-container{
            height: 400px;
            overflow-y: auto;
            border: 1px solid #e3e3e3;
            border-radius: 18px;
    }

    </style>
</head>

<body class="text-left">


    <div class="app-admin-wrap layout-sidebar-vertical sidebar-full">
        <div class="sidebar-panel bg-white">
            <div class="closeMobileManu">
                <i class="far fa-times-circle"></i>
            </div>
            <div id="customePosition" class="scroll-nav ps ps--active-y" data-perfect-scrollbar="data-perfect-scrollbar" data-suppress-scroll-x="true">
                <div class="gull-brand pr-3 text-center mt-4 mb-2 d-flex justify-content-center align-items-center">
                    <img id="site-logo" class="pl-3" src="{{url('assets/images/logo-1.png')}}">
                    <img id="small-site-logo" class="pl-3 d-none" src="{{asset('dist-assets/images/logo-2.png')}}">

                </div>
                <?php
                $role_module_permission = Session::get("role_module_permission");
               // echo "<pre>";
               // print_r($role_module_permission);
               // exit;
                ?>
                <div>
                    <div class="side-nav">
                        <div class="main-menu">
                        <ul class="metismenu" id="menu">
                            <?php if(array_key_exists(1,$role_module_permission)){?>
                                <li><a href="{{ url('/dashboard') }}" class=" {{ Request::routeIs('dashboard') ? 'menu-active' : '' }}">
                                <img class="mr-2" src="{{url('dist-assets/images/dashbord.svg')}}" style="max-width:50px;">
                                <span class="item-name text-15 text-muted">Dashboard</span></a>
                                </li>
                            <?php } ?>
                            <?php if(array_key_exists(2,$role_module_permission)){?>
                            <li><a  href="{{ url('/user/list') }}" class="{{ Request::routeIs('user.list') ? 'menu-active' : '' }}">
                            <img class="mr-2" src="{{url('dist-assets/images/user.svg')}}" style="max-width:50px;">
                            <span class="item-name text-15 text-muted">User Management</span></a> </li>
                            <?php } ?>
                            <?php if(array_key_exists(4,$role_module_permission)){?>
                            <li ><a  class="{{ Request::routeIs('project.list') ? 'menu-active' : '' }}" href="{{ url('/project/list') }}">
                            <img class="mr-2" src="{{url('dist-assets/images/project.svg')}}" style="max-width:50px;">
                            <span class="item-name text-15 text-muted">Project Management</span></a> </li>
                            <?php } ?>
                            <?php if(array_key_exists(5,$role_module_permission)){?>
                            <li ><a  class="{{ Request::routeIs('assessment.list') ? 'menu-active' : '' }}" href="{{ url('/assessment/list') }}">
                            <img class="mr-2" src="{{url('dist-assets/images/assessment.svg')}}" style="max-width:50px;">
                            <span class="item-name text-15 text-muted">Assessments</span></a> </li>
                            <?php } ?>
                            <?php if(array_key_exists(5,$role_module_permission)){?>
                                <li ><a  class="{{ Request::routeIs('scoremanagement.list') ? 'menu-active' : '' }}" href="{{ url('/scoremanagement/list') }}">
                                <img class="mr-2" src="{{url('dist-assets/images/scoremanagement.svg')}}" style="max-width:50px;">
                                <span class="item-name text-15 text-muted">Score Management</span></a> </li>
                            <?php } ?>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content-wrap mobile-menu-content bg-off-white m-0">


        <header class="main-header bg-white d-flex justify-content-between p-2">
                <div class="header-toggle">
                    <div class="menu-toggle custome-toggle">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>

                       </div>
                <div class="header-part-right">
                   <div class="">
                   <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                   </div>
                   <div class="ml-3">
                   <p class="m-0">
                            <div class="d-flex">
                                  <div class="mr-2">{{Auth::user()->name}}
                                   {{Auth::user()->lname}}</p></div>
                                   <div><img class="mr-2" style="cursor:pointer;" src="{{url('dist-assets/images/dropdown.svg')}}" style="max-width:50px;" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                   <div class="dropdown-menu" id="dropdownMenuButton" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" >
                                    <a class="dropdown-item b-1" href="{{ url('profile') }}">My Account </a>
                                    <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                                </div>
                                </div>
                                </div>
                                </div>



                    <!-- <div class="dropdown dropleft">
                        <div id="dropdownMenuButton" style=" display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-around;align-items: center; width: 99px;}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-2x" aria-hidden="true"></i><div><p class="m-0"><b></b> {{Auth::user()->name}} {{Auth::user()->lname}}s</b></p> <p class="m-0">Admin</p></div> </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item" href="#"> Log Out</a>


                        </div>
                    </div> -->
                </div>
            </header>



            <div class="p-3">
                <div id="loading-image" class="show"></div>
               @yield('content')
            </div>


            <footer class="mt-5">
                <div class="app-footer">
                    <div class="footer-bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="m-0 text-center">MITAS UOM &copy; <?= date("Y"); ?>. All right reserved.</p>
                                <p class="m-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="{{ asset('dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/tooltip.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/script_2.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/metisMenu.min.js') }}/"></script>
    <script src="{{ asset('dist-assets/js/scripts/layout-sidebar-vertical.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/echarts.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/form.validation.script.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.12.15/dist/sweetalert2.all.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" rel="stylesheet">>

    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

    <script src="{{ asset('dist-assets/js/plugins/quill.min.js')}}"></script>
    <script src="{{ asset('dist-assets/js/scripts/quill.script.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


    <script>
        $(document).ready(function() {


            $('.backlink').click(function() {
                    parent.history.back();
                    return false;
            });

            $('.select2').select2({
                dropdownAutoWidth : true,
                minimumResultsForSearch: -1
            });



            $('#date-filter, #startDate, #endDate').datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: 'focus',
                showButtonPanel: true,
                todayHighlight: true,
                clearBtn: true,
                orientation: "bottom",
                autoclose: true
            });



            var quill = new Quill('#editor', {
            modules: {
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: 'snow'
        });
            var quill = new Quill('#editor2 ', {
            modules: {
                syntax: !0,
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: "1"
                    }, {
                        header: "2"
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video", "formula"],
                    ["clean"]
                ]
            },
            theme: 'snow'
        });
            $(document).on('click', '.menu-toggle i, .menu-toggle', function() {
                $('.sidebar-panel').addClass('mbOpen');
            })

            $(document).on('click', '.closeMobileManu i, .menu-toggle', function() {
                $('.sidebar-panel').removeClass('mbOpen');
            })


            $(".viewTable").DataTable({
                "pageLength": 100
            });

            $("table.viewTable").find("tfoot").addClass("d-none");
            $("table.viewTable>thead>tr>th:last-child").removeClass("sorting_asc");
            $("div#loading-image").removeClass("show");
        });

        $(document).on("click", "img#site-logo, img#small-site-logo", function(e) {
            $(".sidebar-compact-switch").trigger("click");
        });

        $(document).on("click", ".custome-toggle", function(e) {

            $('.layout-sidebar-vertical').toggleClass('sidebar-compact-onhover');

            $('.layout-sidebar-vertical').toggleClass('sidebar-compact');
        });


        $(".sidebar-panel").on("mouseenter", function(e) {
            if ($("div.layout-sidebar-vertical").hasClass("sidebar-compact-onhover")) {
                $("img#site-logo").removeClass("d-none");
                $("img#small-site-logo").addClass("d-none");
            }
        }).on("mouseleave", function(e) {
            if ($("div.layout-sidebar-vertical").hasClass("sidebar-compact-onhover")) {
                $("img#site-logo").addClass("d-none");
                $("img#small-site-logo").removeClass("d-none");
            }
        });

        //keep selected menu active
        // $(document).on("click", "ul > li> a", function(e) {
        //     let menu = $(this).text();
        //     localStorage.setItem('menuAtive', menu);
        // });

        // $(document).ready(function() {
        //     let menuAtive = localStorage.getItem('menuAtive');

        //     $('ul > li> a').each(function(index, obj) {
        //         let menuactivename = $(this).text();
        //         if (menuactivename == menuAtive) {
        //             $(this).addClass('menu-active');
        //             $(this).closest('ul').closest('li').find('a:eq(0)').addClass('menu-active');
        //         }

        //     })

        // });

        $(document).on("click", ".metismenu li:last-child>ul>li:last-child", function(e) {
            localStorage.clear();
        });

        $(document).on('click', '.delete-o>i', function(e){
             $(this).parents('.option_tick').remove();
        });
        $(document).on('click', '.battery', function(e){
            $('.add_new').toggle();
        });

        $(document).on('click', '.add_new', function(e){
            $('.q_frame').toggle();
        });


        $(document).on('click', '.-z_-448', function(e){
             e.preventDefault();

             let optionCount = $(this).closest('div').siblings('.option_html').find('.option_tick').length;
             if(optionCount <= 5){
                var html = `<span><input type="radio" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div><span class="delete-o"><i class="fa fa-trash"></i></span>`;

                $(this).parents('.q-html').find('.option_html').append(`<div class="option_tick">${html}</div>`);

             }else{
                swal({

                    title: "<h3>You can't add more options</h3>",
                    timer: 2000,
                    type: "error",
                    buttons: false,
                    showCancelButton: false,
                    showConfirmButton: false
                });
             }


        });


        $(document).on('click', '.multiQty', function(e){
             e.preventDefault();

             let optionCount = $(this).closest('div').siblings('.option_html').find('.option_tick').length;
             if(optionCount <= 5){
                var html = `<span><input type="checkbox" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div><span class="delete-o"><i class="fa fa-trash"></i></span>`;

                $(this).parents('.q-html').find('.option_html').append(`<div class="option_tick">${html}</div>`);

             }else{
                swal({

                    title: "<h3>You can't add more options</h3>",
                    timer: 2000,
                    type: "error",
                    buttons: false,
                    showCancelButton: false,
                    showConfirmButton: false
                });
             }


        });
        // single type
        $(document).on('click', '#single-choice-type', function(e){
            e.preventDefault();
            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }

            var choiceHtml = `<div class="q-html t-html" data-id="0">
                <input type="hidden" class="typeCheck"  value="singleType">
                <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                    <span class="audio-video">
                    <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                    <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                    ${checkedSoringhtml}
                    <span class="d-flex justify-content-end align-items-center mr-4"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                    <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
                </div>
                <div class="question-title">
                <span class="count_d"><b></b></spna>
                    <span class="editable" contenteditable="true" style="outline:none;"> Question </span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>
                <div class="option_html">
                    <div class="option_tick">
                            <span><input type="radio" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>
                    <div class="option_tick">
                            <span><input type="radio" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
                <div class="-xH-441"><button class="-z_-448" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
            </div>`;
            $('.all-question').append(choiceHtml);
            count();
        });
        // MultiSelect type
        $(document).on('click', '#multi-select-type', function(e){
            e.preventDefault();
            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }

            var choiceHtml = `<div class="q-html t-html" data-id="0">
                <input type="hidden" class="typeCheck"  value="multiType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                <span class="d-flex justify-content-end align-items-center mr-4"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>

                <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable" contenteditable="true" style="outline:none;"> Question </span>
                </div>
                 <div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>
                <div class="option_html">
                    <div class="option_tick">
                            <span><input type="checkbox" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>
                    <div class="option_tick">
                            <span><input type="checkbox" disabled></span>
                            <div class="option_title editable" style="outline:none;" contenteditable="true">
                            </div>
                            <span class="delete-o"><i class="fa fa-trash"></i></span>
                    </div>
                </div>
                <div class="-xH-441"><button class="multiQty" aria-label="Add option"><i class="fas fa-plus"></i> Add option</button></div>
            </div>`;
            $('.all-question').append(choiceHtml);
            count();
        });
        // text type question
        $(document).on('click', '#text-qes-type', function(e){
            e.preventDefault();

            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }


             var textHtml = `<div class="q-html t-html textType" data-id="0">
             <input type="hidden" class="typeCheck"  value="textType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class="d-flex justify-content-end align-items-center mr-4"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>
             <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable textq text" contenteditable="true" style="outline:none;"> Question </span>
                </div>
                 <div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>
              <div class="aswer-i">
              <input class="---G-553 anstype" disabled="" readonly="" placeholder="Enter your answer" value="Enter your answer">
              </div>
             </div>`;


            $('.all-question').append(textHtml);
            count();
        });

        // Yes and no type question
        $(document).on('click', '#ynq-type', function(e){
            e.preventDefault();

            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }


             var textHtml = `<div class="q-html t-html yesNoType" data-id="0">
             <input type="hidden" class="typeCheck"  value="yesNoType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class="d-flex justify-content-end align-items-center mr-4"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>
             <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable textq text" contenteditable="true" style="outline:none;"> Question </span>
                </div>
                 <div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>
              <div class="aswer-i">
               <div class="d-flex align-items-center">
                   <div class="yes d-flex align-items-center mr-3">
                   <label class="btn btn-default label_button" for="yes"> <input type="radio" name="yesno"  value="1" class="mr-2 anstype d-none "> Yes</label>
                    </div>
                     <div class="no d-flex align-items-center">
                    <label class="btn btn-default label_button" for="no"> <input type="radio"  name="yesno" value="0" class="mr-2 anstype d-none" > No</label>
                    </div>
              </div>
             </div>`;


            $('.all-question').append(textHtml);
            count();
        });
        // true and false type
        $(document).on('click', '#tfq-type', function(e){
            e.preventDefault();

            var checkedSoringhtml = '';
            var display = '';
            if( $('#scoringRequired').val() == 0 ){
                display= "d-none"
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }else{
                display= "";
                checkedSoringhtml = `<span class="mr-4 scoringGuideLine ${display}">+ Add to Scoring Guidelines <b class="text-danger"> *</b></span>
              `;
             }


             var textHtml = `<div class="q-html t-html trueFalseType" data-id="0">
             <input type="hidden" class="typeCheck"  value="trueFalseType">
             <div class="mb-2 text-right d-flex justify-content-end align-items-center">
                <span class="audio-video">
                <img src="{{url('dist-assets/images/videos.png')}}" alt="filter" class="mr-3" style="max-width:17px; cursor:pointer;"></span>
                <span><img src="{{url('dist-assets/images/delete.png')}}" alt="filter" class="mr-3" onClick="removeDiv(this)" style="max-width:17px; cursor:pointer;"></span>
                ${checkedSoringhtml}
                    <span class="d-flex justify-content-end align-items-center mr-4"><input type="checkbox" name="addtoquestionbank" class="mr-2"> Add to Item Bank</span>
                <span class="d-flex justify-content-end align-items-center"><input type="checkbox" name="required" class="mr-2"> Required</span>
             </div>
             <div class="question-title">
                <span class="count_d"><b></b></spna>
                <span class="editable textq text" contenteditable="true" style="outline:none;"> Question </span>
                </div>
                 <div class="row">
                    <div class="col-md-4">
                           <div class="preview-container"></div>
                    </div>
                    <div class="col-md-8">
                         <div class="videoPreview" style="margin-top: 20px;"></div>
                    </div>
                </div>
              <div class="aswer-i">
               <div class="d-flex align-items-center">
                   <div class="yes d-flex align-items-center mr-3">
                   <label class="btn btn-default label_button" for="true"> <input type="radio" name="trueFalse"  value="1" class="mr-2 anstype d-none" > True</label>
                    </div>
                     <div class="no d-flex align-items-center">
                  <label class="btn btn-default label_button" for="false">  <input type="radio"  name="trueFalse" value="0" class="mr-2 anstype d-none"> False</label>
                    </div>
              </div>
             </div>`;


            $('.all-question').append(textHtml);
            count();
        });


        $(document).ready(function() {
            $('#productFilter').select2({
                placeholder: 'Search for Projects',
                allowClear: true,
                ajax: {
                    type: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('project.search')}}', // Replace with your API endpoint
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text:item.project_title
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: {
                    noResults: function() {
                        return "No results found";
                    }
                }
            });
        });



        function count(){
            $('.count_d').each(function(index) {
                $(this).find('b').text(index + 1 +'.');
            });
        }

    </script>
</body>

</html>

