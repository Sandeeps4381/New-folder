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
    <title>Score Management</title>

    <style>
        /* Your existing styles */
        /* ... */

        /* New styles for the details page */




        #detailsPage {
            display: none;
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
            color: #f1b82d;
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




        .total_completed {
            color: #f1b82d;
        }


        .box_feed_inst {

            background-color: #ffffff;
            /* White background color */
            border-radius: 15px;
            border: 2px solid #cfcccc;
            /* Border color */
            padding: 10px;
            /* Padding inside the box */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Shadow for depth */
            width: auto;
            /* Width of the box */
            height: 100%;
            /* Height of the box */
            margin: 20px;
            padding-left: 20px;
            margin-right: 20px;
            /* Margin around the box */


        }

        .box_feed_inst h4 {
            color: black;
        }

        .box_feed_inst p {
            color: #f1b82d;
        }

        .box_feed_inst hr {
            border: 0;
            height: 1px;
            margin-right: 20px;
            background: black;
            margin: 10px 0;
        }

        question-container {
            padding: 20px;
        }

        .answer {
            display: flex;
            margin-top: 10px;
            justify-content: space-between;
            /* Space out the left and right sections */
            align-items: flex-start;
            /* Align items to the top */
            gap: 20px;
            /* Gap between the left and right sections */
        }

        /* Default styling for checkboxes */
        .answer input[type="checkbox"] {
            cursor: pointer;
        }

        /* Disable checkboxes when guidelines are deactivated */
        .answer.disabled input[type="checkbox"] {
            cursor: not-allowed;
            opacity: 0.5;
            /* Make them appear disabled */
        }



        .guideline-icon {
            cursor: pointer;
            background-color: #f1b82d;
            color: #000;
            /* Yellowish color */
            position: absolute;
            /* Or use relative if you prefer */
            right: 40px;
            width: auto;
            padding: 5px;
            margin-top: 10px;
            transform: translateY(-50%);
            /* Center vertically */
            transition: background-color 0.3s, color 0.3s;
            /* Smooth transition */
        }

        .guideline-icon.inactive {
            /* Light gray color */
            background-color: #ffffff;
            color: #f1b82d;
            /* Dark gray color */
        }



        .gud_box {
            border: 2px solid grey;
            /* Adjust the border width and color as needed */
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            /* Optional: background color to match existing styles */
        }

        /* Modal Container */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            margin-bottom: 20px;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black w/ opacity for dim background */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            /* 10% from the top and centered */
            padding: 10px;
            margin-bottom: 10%;
            border-radius: 10px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less depending on screen size */
            max-width: 600px;
            /* Limit the maximum width for larger screens */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Modal Heading */
        .modal-content h3 {
            color: black;
            text-align: center;
            font-size: 24px;

        }

        /* Modal Text */
        .modal-content p {
            margin: 15px 0;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        /* Modal Checkbox Label */
        .modal-content label {
            font-size: 16px;
            display: block;

            cursor: pointer;
        }

        /* Buttons in Modal */
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;

        }

        /* Common Button Style */
        .modal-buttons button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        /* Primary Button */
        .modal-buttons button#giveScoreBtn {
            background-color: orange;
            color: white;
            cursor: not-allowed;
            /* Disabled by default */
        }

        /* Cancel Button */
        .modal-buttons button#cancelBtn {
            background-color: transparent;
            color: #f1b82d;
            border: 2px solid #f1b82d;
        }

        /* Enable the "Give Score" button when active */
        .modal-buttons button#giveScoreBtn:enabled {
            cursor: pointer;
        }

        /* Close Button for Modal */
        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
        }


        .star {
        font-size: 30px;
        color: lightgray;
    }
    .star.selected {
        color: gold;
    }
        .feed_write {
            margin-top: 10px;
            background-color: #fff;
            border-radius: 8px;
            border: 20px solid #f1b82d;
            /* Thicker border with color */
            padding-left: 40px;
            /* Increase left padding */
            padding-right: 40px;
            /* Increase right padding */
            text-align: center;
        }

        textarea {
            width: 100%;
            border: none;
            /* Remove border */
            resize: none;
            /* Optional: Prevent resizing */
            outline: none;
            /* Optional: Remove outline on focus */
        }

        .left-checkboxes,
        .right-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            /* Adjust the gap between checkboxes as needed */
        }

        .left-checkboxes label,
        .right-checkboxes label {
            display: flex;
            align-items: center;
            /* Aligns text and checkbox vertically */
            margin: 0;
            /* Remove default margin */
        }

        .left-checkboxes input[type="checkbox"],
        .right-checkboxes input[type="checkbox"] {
            width: 15px;
            /* Adjust checkbox size */
            height: 15px;
            /* Adjust checkbox size */
            margin-right: 10px;
            /* Space between checkbox and text */
            transform: scale(1.5);
            /* Scale checkbox for a larger appearance */
        }

        /* Adjust font size and position of text */
        .left-checkboxes span,
        .right-checkboxes span {
            font-size: 17px;
            /* Adjust text size */
            /* Adjust text position relative to checkbox */
        }
    </style>
</head>

<body>











    <div id="FeedbackPage">
        <div style="margin-top: 16px;" id="header_detail">
            <!-- <a href="#" id="index_page" >
                <i class="fas fa-arrow-left"></i>
                Feedback & Review Assessment
            </a> -->
            <h3><a href="#" id="index_page" onclick="showMainPage()" class="backlink"><i class="fa fa-long-arrow-left"
                        aria-hidden="true"></i></a>
                <b>Feedback & Review Assessment </b>
            </h3>
        </div>
        <!-- Add more details here -->
        <div class="box_detail">

            <div class="box_detail_fisrt">
                <div class="box_1">
                    <p>Name: <span id="detailNames">sandeep</span></p>
                    <p>Email: <span id="detailEmails">singhsan@gmail.com</span></p>
                    <p>Submitted On: <span id="detailSubmitteds">7/9/2024</span></p>
                </div>
                <div class="summary">
                    <p
                        style="padding: 10px; border-radius: 5px; display: inline-block; color: #f1b82d; font-weight: bold; border: 2px solid #cfcccc;">
                        Total Questions Completed
                        <span id="totalcompletd_answer" style="color: #f1b82d;">15</span>
                    </p>


                    <p>Total Question :<span style="color:black;">20</span></p>
                    <p>Project: <span style="color:black" id="detailProjects">Al tech project</span>/BaseLine</p>
                </div>
            </div>

            <div class="box_feed_inst">
                <h4>Instructions</h4>
                <hr />
                <ul style="list-style-type: none; padding: 10px; display: inline-block; color: #f1b82d; font-size: 20px;">
    <li style="position: relative; padding-left: 20px; color: grey;">
        <span style="position: absolute; left: 0; top: 0; color: grey;">&#8226;</span>
        This is answer and really do this is answer and really do this is answer and really do this
    </li>
    <li style="position: relative; padding-left: 20px;">
        <span style="position: absolute; left: 0; top: 0; color: #f1b82d;">&#8226;</span>
        O= Open- End Question
    </li>
    <li style="position: relative; padding-left: 20px;">
        <span style="position: absolute; left: 0; top: 0; color: #f1b82d;">&#8226;</span>
        A= Affirmation
    </li>
    <li style="position: relative; padding-left: 20px;">
        <span style="position: absolute; left: 0; top: 0; color: #f1b82d;">&#8226;</span>
        R = Summaries
    </li>
</ul>

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
                    <h3>Project Manger : <span id="manger">SKy</span></h3>
                    <h3>Project Type :<span id="project_type"> Assesment</span></h3>
                </div>

                <div class="question">
                    <!-- Question 1 -->
                    <div class="qa">
                        <div class="guideline-icon" id="guidelineIcon1">
                            <span style="font-size:15px">Guidelines</span>
                            <i class="fas fa-tasks" id="guidelineIcon1Image"></i>
                        </div>
                        <h3>Question 1: Tell me about yourself?<span style="color: red;">*</h3>
                        <p>Answer: John Doe...</p>
                        <div class="answer">
                            <div class="left-checkboxes">
                                <label><input type="checkbox" class="checkbox1"><span>O</span></label>
                                <label><input type="checkbox" class="checkbox1"><span>A</span></label>
                                <label><input type="checkbox" class="checkbox1"><span>R</span> </label>
                                <label><input type="checkbox" class="checkbox1"> <span>S</span></label>
                            </div>
                            <div class="right-checkboxes">
                                <label><input type="checkbox" class="checkbox1"> <span>0</span></label>
                                <label><input type="checkbox" class="checkbox1"> <span>1</span></label>
                                <label><input type="checkbox" class="checkbox1"> <span>2</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Guidelines -->
                    <div id="guidelineModal1" class="modal">
                        <div class="modal-content">
                            <h3 style="text-align: center; color:black;">Question Guidelines</h3>
                            <div class="gud_box">
                                <h4> Test Rules and Polices</h4>
                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>

                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>
                                <img src="\assets\images\Screenshot 2024-08-21 051550.png" alt="Guideline Image"
                                    style="width:100%;">
                            </div>
                            <label>
                                <input type="checkbox" id="guidelineCheckbox1"> I have read all the guidelines.
                            </label>
                            <div class="modal-buttons">
                                <button id="giveScoreBtn1" disabled>Give Score</button>
                                <button id="cancelBtn1">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <!-- Question 2 -->
                    <div class="qa">
                        <div class="guideline-icon" id="guidelineIcon2">
                            <span style="font-size:15px">Guidelines</span>
                            <i class="fas fa-tasks" id="guidelineIcon2Image"></i>
                        </div>
                        <h3>Question 2: When it luanch first time ?<span style="color: red;">*</h3>
                        <p><input type="date" id="dob" name="dob" value="1990-01-01"></p>
                        <div class="answer">
                            <div class="left-checkboxes">
                                <label><input type="checkbox" class="checkbox2"><span>O</span></label>
                                <label><input type="checkbox" class="checkbox2"><span>A</span></label>
                                <label><input type="checkbox" class="checkbox2"><span>R</span> </label>
                                <label><input type="checkbox" class="checkbox2"> <span>S</span></label>
                            </div>
                            <div class="right-checkboxes">
                                <label><input type="checkbox" class="checkbox2"> <span>0</span></label>
                                <label><input type="checkbox" class="checkbox1"> <span>1</span></label>
                                <label><input type="checkbox" class="checkbox2"> <span>2</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Guidelines -->
                    <div id="guidelineModal2" class="modal">
                        <div class="modal-content">
                            <h3 style="text-align: center;">Question 2 Guidelines</h3>

                            <div class="gud_box">
                                <h4> Test Rules and Polices</h4>
                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>

                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>
                                <img src="\assets\images\Screenshot 2024-08-21 051550.png" alt="Guideline Image"
                                    style="width:100%;">
                            </div>
                            <label>
                                <input type="checkbox" id="guidelineCheckbox2"> I have read all the guidelines.
                            </label>
                            <div class="modal-buttons">
                                <button id="giveScoreBtn2" disabled>Give Score</button>
                                <button id="cancelBtn2">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <!-- Question 3 -->
                    <div class="qa">
                        <div class="guideline-icon" id="guidelineIcon3">
                            <span style="font-size:15px">Guidelines</span>
                            <i class="fas fa-tasks" id="guidelineIcon3Image"></i>
                        </div>
                        <h3>Question 3: Which of the following represents your institution?<span style="color: red;">*
                        </h3>
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
</p>      
                        <div class="answer">
                            <div class="left-checkboxes">
                                <label><input type="checkbox" class="checkbox3"><span>O</span></label>
                                <label><input type="checkbox" class="checkbox3"><span>A</span></label>
                                <label><input type="checkbox" class="checkbox3"><span>R</span> </label>
                                <label><input type="checkbox" class="checkbox3"> <span>S</span></label>
                            </div>
                            <div class="right-checkboxes">
                                <label><input type="checkbox" class="checkbox3"> <span>0</span></label>
                                <label><input type="checkbox" class="checkbox3"> <span>1</span></label>
                                <label><input type="checkbox" class="checkbox3"> <span>2</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Guidelines -->
                    <div id="guidelineModal3" class="modal">
                        <div class="modal-content">
                            <h3 style="text-align: center;">Question 3 Guidelines</h3>

                            <div class="gud_box">
                                <h4> Test Rules and Polices</h4>
                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>

                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>
                                <img src="\assets\images\Screenshot 2024-08-21 051550.png" alt="Guideline Image"
                                    style="width:100%;">
                            </div>
                            <label>
                                <input type="checkbox" id="guidelineCheckbox3"> I have read all the guidelines.
                            </label>
                            <div class="modal-buttons">
                                <button id="giveScoreBtn3" disabled>Give Score</button>
                                <button id="cancelBtn3">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="question">
                    <!-- Question 4 -->
                    <div class="qa">
                        <div class="guideline-icon" id="guidelineIcon4">
                            <span style="font-size:15px">Guidelines</span>
                            <i class="fas fa-tasks" id="guidelineIcon4Image"></i>
                        </div>
                        <h3>Question 4: How much would you rate UOM?</h3>
                        <p class="star-rating" style="pointer-events: none;">
    <span class="star selected" data-value="1">&#9733;</span>
    <span class="star selected" data-value="2">&#9733;</span>
    <span class="star selected" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
</p>
                        <div class="answer">
                            <div class="left-checkboxes">
                                <label><input type="checkbox" class="checkbox4"><span>O</span></label>
                                <label><input type="checkbox" class="checkbox4"><span>A</span></label>
                                <label><input type="checkbox" class="checkbox4"><span>R</span> </label>
                                <label><input type="checkbox" class="checkbox4"> <span>S</span></label>
                            </div>
                            <div class="right-checkboxes">
                                <label><input type="checkbox" class="checkbox4"> <span>0</span></label>
                                <label><input type="checkbox" class="checkbox4"> <span>1</span></label>
                                <label><input type="checkbox" class="checkbox4"> <span>2</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Guidelines -->
                    <div id="guidelineModal4" class="modal">
                        <div class="modal-content">
                            <h3 style="text-align: center;">Question 4 Guidelines</h3>

                            <div class="gud_box">
                                <h4> Test Rules and Polices</h4>
                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>

                                <ul>
                                    <li>
                                        <h4> Academic</h4>
                                    </li>
                                    <ul>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                        <li>
                                            <h4> Academic</h4>
                                        </li>
                                    </ul>
                                </ul>
                                <img src="\assets\images\Screenshot 2024-08-21 051550.png" alt="Guideline Image"
                                    style="width:100%;">
                            </div>
                            <label>
                                <input type="checkbox" id="guidelineCheckbox4"> I have read all the guidelines.
                            </label>
                            <div class="modal-buttons">
                                <button id="giveScoreBtn4" disabled>Give Score</button>
                                <button id="cancelBtn4">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="feed_write">
                        <textarea placeholder="Enter your feedback here..."></textarea>
                    </div>
                </div>




                <div class="btn_box2 margin-top:10px" style="align-items: center;">
                    <button id="cancel">cancel</button>
                    <button style="background-color: #f1b82d;" id="submitedd">Submit</button>
                </div>
















                <div class="logo_box2_" style="background-color: #e8e3e3;">
                <img src="\assets\images\logo-1.png" alt="" width="20%" height="20%">
                </div>

            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
            <script>

                document.addEventListener("DOMContentLoaded", function () {
                    // Function to handle guidelines logic for each question
                    function setupGuidelines(guidelineIconId, guidelineModalId, guidelineCheckboxId, giveScoreBtnId, cancelBtnId, checkboxClass) {
                        const checkboxes = document.querySelectorAll("." + checkboxClass);

                        // Initially disable checkboxes
                        checkboxes.forEach(checkbox => checkbox.disabled = true);

                        // Open modal when guideline icon is clicked
                        document.getElementById(guidelineIconId).onclick = function () {
                            document.getElementById(guidelineModalId).style.display = "block";
                        };

                        // Enable Give Score button when guideline checkbox is checked
                        document.getElementById(guidelineCheckboxId).onclick = function () {
                            document.getElementById(giveScoreBtnId).disabled = !this.checked;
                        };

                        // Enable checkboxes and close modal on Give Score button click
                        document.getElementById(giveScoreBtnId).onclick = function () {
                            if (!document.getElementById(giveScoreBtnId).disabled) {
                                // Deactivate the guideline icon
                                document.getElementById(guidelineIconId).style.pointerEvents = "none";
                                document.getElementById(guidelineIconId).classList.add("inactive");

                                // Change icon to fa-check-circle
                                document.getElementById(guidelineIconId + "Image").classList.remove("fa-tasks");
                                document.getElementById(guidelineIconId + "Image").classList.add("fa-check-circle");

                                // Hide the modal
                                document.getElementById(guidelineModalId).style.display = "none";

                                // Enable checkboxes
                                checkboxes.forEach(checkbox => checkbox.disabled = false);
                            }
                        };

                        // Close modal on Cancel button click
                        document.getElementById(cancelBtnId).onclick = function () {
                            document.getElementById(guidelineModalId).style.display = "none";
                        };
                    }

                    // Setup guidelines for question 1
                    setupGuidelines("guidelineIcon1", "guidelineModal1", "guidelineCheckbox1", "giveScoreBtn1", "cancelBtn1", "checkbox1");
                    setupGuidelines("guidelineIcon2", "guidelineModal2", "guidelineCheckbox2", "giveScoreBtn2", "cancelBtn2", "checkbox2");

                    setupGuidelines("guidelineIcon3", "guidelineModal3", "guidelineCheckbox3", "giveScoreBtn3", "cancelBtn3", "checkbox3");
                    setupGuidelines("guidelineIcon4", "guidelineModal4", "guidelineCheckbox4", "giveScoreBtn4", "cancelBtn4", "checkbox4");
                    // Add more setupGuidelines calls here for other questions as needed...
                });


                document.querySelectorAll('.modal-close').forEach(closeBtn => {
                    closeBtn.onclick = function () {
                        closeBtn.closest('.modal').style.display = "none";
                    };
                });


                // Toggle filter row



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


                document.getElementById('index_page').addEventListener('click', function () {
                    window.location.href = "{{ route('scoremanagement.index') }}";
                });
                document.getElementById('submitedd').addEventListener('click', function () {
                    window.location.href = "{{ route('scoremanagement.assessment_result') }}";
                });
            </script>
</body>

</html>

@endsection