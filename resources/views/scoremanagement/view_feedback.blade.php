@extends('layout/header')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <title>Document</title>
  <style>

    #detailsPage {
   
      /* Hidden by default */
      padding: 20px;
      background-color: #f4f4f4;


  }

  .details {
      display: flex;
      justify-content: center;
      /* Center horizontally */
      align-items: center;
  }


  #header_detail {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
  }

  #backButton {
      display: inline-block;
      background-image: url('/mnt/data/image.png');
      background-repeat: no-repeat;
      background-position: left center;
      padding-left: 30px;
      /* Adjust padding to make space for the icon */
      font-size: 18px;
      text-decoration: none;
      color: #333;
  }

  #feedbackButton {
      background-color: #f1b82d;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      color: #000;
  }

  #feedbackButton img {
      margin-left: 10px;
  }

  #feedbackButton:hover {
      background-color: #f1b82d;
  }


  .box_detail {

      background-color: #ffffff;
      /* White background color */
      border-radius: 15px;
      /* Circular radius for rounded corners */
      padding: 20px;
      /* Padding inside the box */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Optional: Add shadow for depth */
      width: auto;
      /* Width of the box */
      height: 100%;
      /* Height of the box */
      margin: 20px;
      margin-right: 20px;
      /* Margin around the box */
  }

  .box_detail_fisrt {
      background-color: #ffffff;
      /* White background color */
      border-radius: 15px;
      border: 2px solid #cfcccc;
      /* Border color */
      padding: 20px;
      /* Padding inside the box */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Shadow for depth */
      width: auto;
      /* Width of the box */
      height: 100%;
      /* Height of the box */
      margin: 20px;
      /* Margin around the box */
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
  }

  .box_1 {
      font-size: 20px;
      display: flex;
      gap: 10px;
      flex-direction: column;
  }

  .box_1 p {
      color: #807b7b;
      margin: 0;
  }

  .box_1 span {
      color: #000;
  }

  .summary {
      margin-top: 10px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      font-size: 20px;
  }

  .summary p {
      color: #807b7b;
      margin: 0;
  }

  #total_Answer {
      background-color: #000;
      border: 2px solid #000;
      color:#f1b82d;
      padding: 5px 10px;
      /* Adjust padding as needed */
  }



  .box_detail_second {
      background-color: #ffffff;
      /* White background color */
      border: 2px solid #cfcccc;
      /* Black border */
      border-radius: 15px;
      /* Circular radius for rounded corners */
      /* Padding inside the box */
      width: auto;
      /* Width of the box */
      height: auto;
      /* Height of the box, adjusted to fit content */
      margin: 20px;
      margin-top: 40px;
      position: relative;
      /* Ensure child elements can be positioned relative to this container */
  }

  .box_2_h1 {
      text-align: center;
      background-color: #f1b82d;
      /* Background color for the heading */
      padding: 10px;
      /* Padding inside the heading for better appearance */
      margin: 0;
      /* Remove default margin */
      border-radius: 15px 15px 0 0;
      /* Rounded corners on the top */
  }

  .logo_box2_ {
      text-align: center;
      /* Background color for the heading */
      padding: 10px;
      /* Padding inside the heading for better appearance */
      margin: 0;
      margin-top: 50px;
      background-color:#f2efef;
      /* Remove default margin */
      border-radius: 0 0 15px 15px;

  }

  .img_box_2 {
      position: relative;
      /* Allows positioning of text_box_2 relative to the image */
      width: 100%;
      /* Full width of the parent container */
      height: auto;
      /* Height will adjust based on the content */
  }

  .img_box_2 img {
      width: 100%;
      /* Make the image full width of its parent */
      height: auto;
      /* Maintain the aspect ratio of the image */
      display: block;
      /* Remove any default inline spacing */
  }


  /* Remove hover effects that could affect visibility */

  .box_manger {
    display: flex;
    flex-direction: row;
    padding: 10px;
    justify-content: center;
    align-items: center;
    background-color: #f1b82d;
    gap: 10px; /* Adjust the gap as needed */
}

.box_manger > *:not(:last-child) {
    border-right: 1px solid black; /* Add a line between items */
    padding-right: 10px; /* Add padding to create space between the line and the content */
}


  .text_box_2 {
      background-color: #f2efef;
      /* Background color for the text box */
      padding: 10px;
      /* Add padding inside the text box */
      margin: 0;
      /* Remove any default margin */
  }


  .question {
      margin: 20px;
      padding: 20px;
      /* Add some padding around the question section */
      /* Light gray background for the entire section */
      border-radius: 8px;
      gap: 20px;
      /* Slightly round the corners */
  }

  .qa {
      margin-bottom: 15px;
      /* Add some space between each question and answer pair */
  }

  .qa h3 {
      margin: 0 0 5px 0;
      /* Add space below the question heading */
      font-weight: bold;
      /* Make the question bold */
  }

  .qa p {
      padding: 10px;
      margin: 0;
      background-color: #f2efef;
      /* Remove default margin from the paragraph */
  }


  .qa input[type="date"] {
      padding: 5px;
      border-radius: 4px;
      border: 1px solid #e4e1e1;
      font-size: 16px;
      width: auto;
      /* Adjust the width to fit the content */
      cursor: pointer;
      /* Add a pointer cursor on hover */
  }



  .btn_box2 {
      display: flex;
      justify-content: center;
      /* Center the buttons horizontally */
      align-items: center;
      /* Center the buttons vertically */
      gap: 10px;
      /* Optional: Add some space between the buttons */
      width: 100%;
      /* Make the container take up the full width */
  }

  button {
      padding: 10px 20px;
      /* Add padding for a better button appearance */
      border: none;
      /* Remove the default border */
      border-radius: 5px;
      /* Optional: Round the corners slightly */
      cursor: pointer;
      /* Change the cursor to a pointer on hover */
  }


  .star {
        font-size: 30px;
        color: lightgray;
    }
    .star.selected {
        color: gold;
    }

  </style>
</head>
<body>
   <!-- Details page -->
   
    <div style="margin-top: 10px;" id="header_detail">
       <!-- <h3> <a style="color: #000;" href="#" id="index_page" onclick="showMainPage()">
            <i class="fa fa-long-arrow-left"></i>
            </a> View Submitted Assessment</h3> -->
            <h3><a href="#"  id="index_page" onclick="showMainPage()" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <b>View submit Assessment </b></h3>

            <a href="#" id="feedback" style="
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    background-color: #f1b82d;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
    position: relative;
">
    Give Feedback
    <img src="{{url('dist-assets/images/edit.png')}}" alt="filter" style="filter: brightness(0) invert(0); margin-left: 10px;">
</a>



<!-- Include Font Awesome for the pencil icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

          </a>
          
          
          
    </div>

    <div class="box_detail">



        <div class="box_detail_fisrt">
            <div class="box_1">
                <p>Name: <span id="detailName"> Sandeep</span></p>
                <p>Email: <span id="detailEmail">sandeep@gmail.com</span></p>
                <p>Submitted On: <span id="detailSubmitted">1/1/2024</span></p>
            </div>
            <div class="summary">
                <p>
                    <span id="total_Answer">Total Answer: 15/20</span>
                </p>
                <p style="margin-top:40px" >Project: <span style="color:black" id="detailProject">AI TEch</span>/ BaseLine</p>
            </div>
        </div>



        <div class="box_detail_second">
            <h3 class="box_2_h1">AI Technologies Used</h3>
            <div class="img_box_2">
                <img src="\assets\images\Screenshot 2024-08-21 051550.png" alt="">
            </div>
            <div class="text_box_2">
                <p id="">This isPeople use it because it has a fairly normal distribution of letters and words
                    (making it look like normal English), but it’s also Latin, which means your average reader won’t
                    get distracted by trying to read it. It’s perfect for showcasing design work as it should look
                    when fleshed out with text, because it allows viewers to focus on the design work itself,
                    instead of the text. It’s also a great way to showcase the functionality of programs like word
                    processors, font types, </p>
            </div>
            <div class="box_manger">
                <h3>Project Manger :<span id="manger">SKy</span></h3>
                <h3>Project Type :<span id="project_type"> Assesment</span></h3>
            </div>

            <div class="question">
                <div class="qa">
                    <h3>Question 1: Tell me about self?</h3>
                    <p>Answer: John Doe
                        People use it because it has a fairly normal distribution of letters and words (making it
                        look like normal English), but it’s also Latin, which means your average reader won’t get
                        distracted by trying to read it. It’s perfect for showcasing design work as it should look
                        when fleshed out with text, because it allows viewers to focus on the design work itself,
                        instead of the text. It’s also a great way to showcase the functionality of programs like
                        word processors, font types,
                    </p>
                </div>
                <div class="qa">
                    <h3>Question 2: Date of Birth?</h3>
                    <p>Answer: <input type="date" id="dob" name="dob" value="1990-01-01"></p>
                </div>

                <div class="qa">
                    <h3>Question 3:Which of the following represents your institution?</h3>
                    <p style="display: flex; gap: 20px; align-items: center; margin-top: 10px;">
    <label style="font-size: 18px; margin-right:10px; margin-left: 10px;">
        <input type="radio" name="institution" value="1862"
            style="transform: scale(1.5); margin-right: 5px;" onclick="disableOthers(this)"> 1862
    </label>
    <label style="font-size: 18px;">
        <input type="radio" name="institution" value="1890" checked
            style="transform: scale(1.5); margin-right: 5px;" onclick="disableOthers(this)"> 1890
    </label>
    <label style="font-size: 18px;">
        <input type="radio" name="institution" value="1994"
            style="transform: scale(1.5); margin-right: 5px;" onclick="disableOthers(this)"> 1994
    </label>
</p>            </div>
                <div class="qa">
                    <h3>Question 4: How much would you rate UOM ?</h3>
                    <p class="star-rating" style="pointer-events: none;">
    <span class="star selected" data-value="1">&#9733;</span>
    <span class="star selected" data-value="2">&#9733;</span>
    <span class="star selected" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
</p>



                </div>
            

            </div>
            <div class="logo_box2_" >
                <img src="\assets\images\logo-1.png" alt="" width="20%" height="20%">
            </div>






        </div>







</div>




















            <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>

         <script>
function disableOthers(selectedRadio) {
    const radios = document.querySelectorAll('input[name="institution"]');
    radios.forEach(radio => {
        if (radio !== selectedRadio) {
            radio.disabled = true;
        }
    });
}
window.onload = function() {
    const checkedRadio = document.querySelector('input[name="institution"]:checked');
    if (checkedRadio) {
        disableOthers(checkedRadio);
    }
};





            document.getElementById('index_page').addEventListener('click', function() {
                        window.location.href = "{{ route('scoremanagement.index') }}";
                    });
          document.getElementById('feedback').addEventListener('click', function() {
            window.location.href = "{{ route('scoremanagement.feedback') }}";
        });
        </script>     
</body>
</html>

@endsection